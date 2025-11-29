<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// PageController handles static page views.
class PageController extends Controller
{
    // Display the report form view.
    public function reportForm()
    {
        return view('pages.components.report_form');
    }

    // Display the proof form view.
    public function proofForm()
    {
        return view('pages.components.proof_form');
    }

    // Display the admin approval view.
    public function adminApproval()
    {
        return view('pages.components.admin_approval');
    }
}