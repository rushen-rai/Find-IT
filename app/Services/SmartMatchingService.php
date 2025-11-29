<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Alert;
use Illuminate\Support\Facades\Storage;

class SmartMatchingService
{
    public static function findMatches(Item $item): array
    {
        $oppositeType = $item->report_type === 'lost' ? 'found' : 'lost';

        // Step 1: Candidate filtering
        $candidates = Item::where('report_type', $oppositeType)
            ->where('category', $item->category)
            ->where('location', $item->location)
            ->where('status', 'active')
            ->where('item_id', '!=', $item->item_id)
            ->get();

        $potentialMatches = [];

        // Step 2: Compare text + image similarity
        foreach ($candidates as $candidate) {
            $nameSimilarity = self::textSimilarity($item->item_name, $candidate->item_name);
            $descSimilarity = self::textSimilarity($item->description ?? '', $candidate->description ?? '');
            $imageSimilarity = self::compareImages($item, $candidate);

            // Weighted overall similarity
            $textScore = ($nameSimilarity + $descSimilarity) / 2;
            $score = ($textScore * 0.7) + ($imageSimilarity * 0.3);

            if ($score >= 0.55) {
                $potentialMatches[] = $candidate;
            }
        }

        return $potentialMatches;
    }

    private static function textSimilarity(string $text1, string $text2): float
    {
        $text1 = strtolower(trim($text1));
        $text2 = strtolower(trim($text2));

        if (empty($text1) || empty($text2)) {
            return 0.0;
        }

        $words1 = array_count_values(str_word_count($text1, 1));
        $words2 = array_count_values(str_word_count($text2, 1));

        $common = array_intersect_key($words1, $words2);
        $sharedCount = array_sum(array_map(fn($w) => min($words1[$w], $words2[$w]), array_keys($common)));
        $totalCount = max(array_sum($words1), array_sum($words2));

        return $totalCount > 0 ? $sharedCount / $totalCount : 0.0;
    }

    private static function compareImages(Item $item1, Item $item2): float
    {
        if (!$item1->photo || !$item2->photo) {
            return 0.0;
        }

        try {
            $path1 = Storage::disk('public')->path($item1->photo);
            $path2 = Storage::disk('public')->path($item2->photo);

            if (!file_exists($path1) || !file_exists($path2)) {
                return 0.0;
            }

            $hash1 = self::generateImageHash($path1);
            $hash2 = self::generateImageHash($path2);

            // Compare bitwise difference (Hamming distance)
            $distance = 0;
            for ($i = 0; $i < strlen($hash1); $i++) {
                $distance += ($hash1[$i] !== $hash2[$i]) ? 1 : 0;
            }

            // Convert to 0–1 similarity
            $maxLength = max(strlen($hash1), 1);
            return 1 - ($distance / $maxLength);
        } catch (\Exception $e) {
            return 0.0;
        }
    }

    private static function generateImageHash(string $path): string
    {
        [$width, $height] = getimagesize($path);
        $img = imagecreatefromstring(file_get_contents($path));

        // Downscale to small grayscale image (8x8)
        $small = imagecreatetruecolor(8, 8);
        imagecopyresampled($small, $img, 0, 0, 0, 0, 8, 8, $width, $height);

        $pixels = [];
        $totalBrightness = 0;

        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $rgb = imagecolorat($small, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $brightness = (0.3 * $r + 0.59 * $g + 0.11 * $b);
                $pixels[] = $brightness;
                $totalBrightness += $brightness;
            }
        }

        $avg = $totalBrightness / 64;
        imagedestroy($small);
        imagedestroy($img);

        // Generate binary hash (1 = bright, 0 = dark)
        return implode('', array_map(fn($px) => $px >= $avg ? '1' : '0', $pixels));
    }

    public static function createMatchAlerts(Item $item, array $matches): void
    {
        if (empty($matches)) {
            return;
        }

        // If the current item is LOST → alert the reporter
        if ($item->report_type === 'lost') {
            foreach ($matches as $match) {
                Alert::create([
                    'user_id'      => $item->user_id,
                    'title'        => 'Potential Match Found',
                    'message'      => 'A potential match for your lost item "' . $item->item_name . '" has been found. Please verify if it’s yours.',
                    'type'         => 'match_found',
                    'status'       => 'matched',
                    'label'        => 'lost',
                    'is_read'      => false,
                    'related_id'   => $match->item_id,
                    'related_type' => Item::class,
                ]);
            }
        }
        // If the current item is FOUND → alert owners of lost reports
        else {
            foreach ($matches as $match) {
                if ($match->report_type === 'lost') {
                    Alert::create([
                        'user_id'      => $match->user_id,
                        'title'        => 'Potential Match Found',
                        'message'      => 'A found item might match your lost report for "' . $match->item_name . '". Please review and confirm if it’s yours.',
                        'type'         => 'match_found',
                        'status'       => 'matched',
                        'label'        => 'lost',
                        'is_read'      => false,
                        'related_id'   => $item->item_id,
                        'related_type' => Item::class,
                    ]);
                }
            }
        }
    }
}
