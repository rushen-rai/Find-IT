<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Find IT Dashboard</title>

  <!-- Global Styles -->
  <link rel="stylesheet" href="{{ asset('css/base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/analytics.css') }}">

  <!-- Components -->
  <link rel="stylesheet" href="{{ asset('css/components/floating_bttn.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components/report_form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components/proof_form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/manage.css') }}">

  <!-- Icons -->
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
<body>
  <div class="dashboard">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar__logo">
        <img src="{{ asset('images/logo.png') }}" alt="Find IT Logo" class="info__logo">
        <h2>Find IT</h2>
      </div>
      <nav class="sidebar__menu">
        @if(Auth::check() && Auth::user()->role !== 'admin')  <!-- Only show Home for students -->
          <a href="#" data-view="dashboard" class="active">
            <i class="bi bi-house"></i> Home
          </a>
        @endif
        @if(Auth::check() && Auth::user()->role === 'admin')  <!-- Only show for admins -->
          <a href="#" data-view="manage" class="active">
            <i class="bi bi-gear"></i> Manage
          </a>
        @endif
        <a href="#" data-view="analytics">
          <i class="bi bi-graph-up"></i> Analytics
        </a>
      </nav>
      <div class="sidebar__bottom">
        <div class="user">
          <i class="bi bi-person-circle"></i>
          <span>{{ Auth::user()->name ?? 'Guest' }}</span>
        </div>
        <!-- Sign-Out Form -->
        <form method="POST" action="{{ route('logout') }}" class="signout-form">
          @csrf
          <button type="submit" class="signout-btn">
            <i class="bi bi-box-arrow-left"></i> Sign out
          </button>
        </form>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main">
      <header class="header">
        <div class="header__top">
          <div class="header__text">
            @if(Auth::check() && Auth::user()->role === 'admin')
              <h3>Manage Reports & Claims</h3>
              <h4>Search and filter reports and claims</h4>
            @else
              <h3>Find Lost & Found Items</h3>
              <h4>Search through reported items and browse by category</h4>
            @endif
          </div>

          <div class="header__actions">
            <div class="dropdown">
              <i class="bi bi-bell" id="notifIcon"></i>
              <div class="dropdown-menu" id="notifMenu">
                <h4>Notifications</h4>
                <ul id="notifList"></ul>
              </div>
            </div>
            <div class="dropdown">
              <i class="bi bi-exclamation-triangle" id="alertIcon"></i>
              <div class="dropdown-menu" id="alertMenu">
                <h4>Alerts</h4>
                <ul id="alertList"></ul>
              </div>
            </div>
          </div>
        </div>

        <!-- SEARCH + FILTERS -->
        <div class="header__filters dashboard-filters" style="display: {{ Auth::user()->role === 'admin' ? 'none' : 'flex' }};">
          <div class="search-bar">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search for items, locations, or descriptions...">
          </div>
          <section class="filters">
            <select>
              <option>Time</option>
              <option>Newest</option>
              <option>Oldest</option>
            </select>
            <select>
              <option>Location</option>
              <option>Front Gate</option>
              <option>Back Gate</option>
              <option>UNP Gymnasium</option>
              <option>UNP Pavillion</option>
              <option>UNP Main Library</option>
              <option>UNP Graduate Library</option>
              <option>UNP Oval</option>
              <option>Canteen</option>
              <option>UNP Admin</option>
              <option>UNP Student Center</option>
              <option>New Admin Building</option>
              <option>Architecture</option>
              <option>Arts and Sciences</option>
              <option>Business Administration and Accountancy</option>
              <option>Criminal Justice and Education</option>
              <option>Communication and Information Technology</option>
              <option>Health Sciences</option>
              <option>Public Administration</option>
              <option>Teacher Education</option>
              <option>Engineering</option>
              <option>Nursing</option>
              <option>Medicine</option>
              <option>Law</option>
              <option>Hospitality and Tourism Management</option>
              <option>Fine Arts and Design</option>
              <option>Technology</option>
            </select>
            <select>
              <option>Status</option>
              <option>Lost</option>
              <option>Found</option>
            </select>
          </section>
        </div>

        <!-- SEARCH + FILTERS -->
        <div class="header__filters manage-filters" style="display: {{ Auth::user()->role === 'admin' ? 'flex' : 'none' }};">
          <div class="search-bar">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search for reports, claims, or descriptions..." id="manageSearch">
          </div>
          <section class="filters">
            <select id="manageFilter">
              <option value="all">All</option>
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
              <option value="claimed">Claimed</option>
            </select>
            <!-- Tab report/claim -->
            <select id="manageTab" class="tab-filter">
              <option value="reports">Reports</option>
              <option value="claims">Claims</option>
            </select>
          </section>
        </div>
      </header>

      <!-- CATEGORIES -->
      <section class="categories-section" style="display: {{ Auth::user()->role === 'admin' ? 'none' : 'block' }};">
        <div class="categories-header"><h3>Browse by Category</h3></div>
        <div class="categories">
          @php
            $categoryIcons = [
                'Electronics & Gadgets' => 'bi-laptop',
                'Bags & Accessories' => 'bi-bag',
                'Clothing & Wearables' => 'bi-gem',  // 👈 jewelry category icon
                'Documents & IDs' => 'bi-file-earmark-text',
                'School Supplies' => 'bi-pencil-square',
                'Personal Items' => 'bi-person-badge'
            ];
          @endphp

          @foreach (['Electronics & Gadgets', 'Bags & Accessories', 'Clothing & Wearables', 'Documents & IDs', 'School Supplies', 'Personal Items'] as $cat)
            <div class="category">
              <div class="icon">
                <i class="bi {{ $categoryIcons[$cat] ?? 'bi-tag' }}"></i>
              </div>
              <h3>{{ $cat }}</h3>
              <div class="count">{{ $counts[$cat] ?? 0 }} items</div>
            </div>
          @endforeach
        </div>
      </section>

      <!-- REPORTS -->
      <section class="reports" style="display: {{ Auth::user()->role === 'admin' ? 'none' : 'block' }};">
        <h3>Recent Reports</h3>
        <div class="report-grid">
          @foreach($recentItems as $item)
            <div class="report-card {{ $item->report_type }}"
                data-item='@json($item->load("user"))'>
              <div class="card-header">
                <h4>{{ $item->item_name }}</h4>
                <span class="label {{ $item->report_type }}">{{ strtoupper($item->report_type) }}</span>
              </div>
              <p>{{ $item->category }}</p>
              <p><i class="bi bi-geo-alt"></i> {{ $item->location }}</p>
              <p><i class="bi bi-clock"></i> {{ $item->date_reported->diffForHumans() }}</p>
              <div class="card-footer">
                <span class="status {{ $item->status }}">{{ $item->status }}</span>
                <button class="view-item-btn">View</button>
              </div>
            </div>
          @endforeach
        </div>
      </section>

      <!-- ANALYTICS CONTENT -->
      <div class="content analytics-content" style="display: none;">
        <section class="analytics-dashboard">
          <!-- Top Summary Cards -->
          <div class="analytics-cards">
            <div class="card lost">
              <i class="bi bi-x-circle"></i>
              <h3>Lost Items</h3>
              <h2 id="lostCount">0</h2>
              <p><span class="up">↑</span> 3 from last week</p>
            </div>
            <div class="card found">
              <i class="bi bi-search"></i>
              <h3>Found Items</h3>
              <h2 id="foundCount">0</h2>
              <p><span class="up">↑</span> 5 from last week</p>
            </div>
            <!-- Removed: Success Rate card -->
            <div class="card reports">
              <i class="bi bi-file-earmark-text"></i>
              <h3>Reports</h3>
              <h2 id="totalReports">0</h2>
              <p>Approved Reports</p>
            </div>
            <div class="card pending">
              <i class="bi bi-clock"></i>
              <h3>Pending Claims</h3>
              <h2 id="pendingReports">0</h2>
              <p>Claims under review</p>
            </div>
          </div>

          <!-- Middle Charts Row -->
          <div class="analytics-charts">
            <div class="chart card">
              <h3>Items by Category</h3>
              <p>Lost vs Found Items by Category</p>
              <canvas id="barChart" width="400" height="200"></canvas>
            </div>
            <div class="chart card">
              <h3>Category Distribution</h3>
              <p>Most reported Categories</p>
              <canvas id="pieChart" width="400" height="200"></canvas>
            </div>
          </div>

          <!-- Bottom Lists -->
          <div class="analytics-lists">
            <div class="list card">
              <h3><i class="bi bi-geo-alt"></i> Top Locations</h3>
              <p>Most common report locations</p>
              <ul id="topLocationsList">
                <li>Loading...</li>
              </ul>
            </div>
            <div class="list card">
              <h3><i class="bi bi-activity"></i> Recent Activity</h3>
              <p>Latest reports and updates</p>
              <ul class="activity" id="recentActivityList">
                <li>Loading...</li>
              </ul>
            </div>
          </div>
        </section>
      </div>

      <!-- ITEM OVERLAY -->
      <div id="itemOverlay" class="item-overlay">
        <div class="item-modal">
          <button class="close-overlay">&times;</button>
          <div class="item-header">
            <h2 id="itemName"></h2>
            <p id="itemCategory"></p>
          </div>
          <div class="item-grid">
            <div class="item-box image-box">
              <img id="itemPhoto" src="{{ asset('images/no-image.png') }}" alt="Item photo">
            </div>
            <div class="item-box status-box">
              <div class="status-header">
                <h3>Status</h3>
                <span id="itemType" class="label lost">LOST</span>
              </div>
              <div class="status-item">
                <i class="bi bi-tag"></i>
                <p id="itemStatus">Active</p>
              </div>
              <div class="status-item">
                <i class="bi bi-geo-alt"></i>
                <div>
                  <p id="itemLocation">–</p>
                  <small>Main Location</small>
                </div>
              </div>
              <div class="status-item">
                <i class="bi bi-geo"></i>
                <div>
                  <p id="itemAddLocation">–</p>
                  <small>Additional Location Info</small>
                </div>
              </div>
              <div class="status-item">
                <i class="bi bi-calendar-event"></i>
                <p id="itemDate">–</p>
              </div>
            </div>
            <div class="item-box desc-box">
              <h3>Description</h3>
              <p id="itemDescription">–</p>
            </div>
            <div class="item-box contact-box">
              <h3>Reporter</h3>
              <div class="contact-card">
                <i class="bi bi-person-circle"></i>
                <div>
                  <h4 id="reporterName">–</h4>
                  <p id="reporterEmail">–</p>
                </div>
              </div>
            </div>
          </div>

          <!-- CLAIM DETAILS SECTION (Only for claims in manage mode) -->
          <div id="claimDetailsSection" class="item-grid" style="display: none;">
            <div class="item-box desc-box">
              <h3>Claim Description</h3>
              <p id="claimDescription">–</p>
            </div>
            <div class="item-box contact-box">
              <h3>Claimant Details</h3>
              <div class="contact-card">
                <i class="bi bi-person-circle"></i>
                <div>
                  <h4 id="claimantName">–</h4>
                  <p id="claimantContact">–</p>
                </div>
              </div>
            </div>
            <div class="item-box image-box">
              <img id="claimPhoto" src="{{ asset('images/no-image.png') }}" alt="Claim proof photo">
            </div>
            <div class="item-box status-box">
              <h3>Claim Location</h3>
              <div class="status-item">
                <i class="bi bi-geo-alt"></i>
                <p id="claimantLocation">–</p>
              </div>
              <div class="status-item">
                <i class="bi bi-geo"></i>
                <p id="claimAddLocation">–</p>
              </div>
              <div class="status-item">
                <i class="bi bi-fingerprint"></i>
                <p id="claimUniqueIdentifier">–</p>
              </div>
            </div>
          </div>


          <div class="claim-container">
            <button class="claim-btn" id="claimBtn">Claim</button>
          </div>
        </div>
      </div>


      <!-- MANAGE -->
      @if(Auth::check() && Auth::user()->role === 'admin')
      <div class="content manage-content" style="display: block;">
        <!-- Tabs -->
        <section class="manage-section">
          <div class="tab-content" id="reportsTab">
            <div class="manage-grid" id="reportsGrid">
              @foreach($reports as $report)
                <div class="manage-card" data-id="{{ $report->item_id }}" data-item='@json($report->load("user"))'>
                  <h4>{{ $report->item_name }}</h4>
                  <p>{{ $report->description }}</p>
                  <p><strong>Status:</strong> <span class="status {{ $report->status }}">{{ $report->status }}</span></p>
                  <p><strong>Date:</strong> {{ $report->date_reported->format('Y-m-d') }}</p>
                  <div class="manage-actions">
                    <button class="btn-view" data-action="view">View</button>
                    <button class="btn-approve" data-action="approve">Approve</button>
                    <button class="btn-delete" data-action="delete">Delete</button>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="tab-content" id="claimsTab" style="display: none;">
            <div class="manage-grid" id="claimsGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem; margin-top: 1rem;">
              @foreach($claims as $claim)
                <div class="manage-card" data-id="{{ $claim->claim_id }}" data-item='@json($claim->item->load("user") ?? [])'>
                  <h4>{{ $claim->item_name ?? 'Claim for Item' }}</h4>
                  <p>{{ $claim->description }}</p>
                  <p><strong>Status:</strong> <span class="status {{ $claim->status }}">{{ $claim->status }}</span></p>
                  <p><strong>Date:</strong> {{ $claim->created_at->format('Y-m-d') }}</p>
                  <div class="manage-actions">
                    <button class="btn-view" data-action="view">View</button>
                    <button class="btn-claimed" data-action="claimed">Claimed</button>  <!-- Added Claimed button -->
                    <button class="btn-reject" data-action="reject">Reject</button>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </section>
      </div>
      @endif
    </main>

    <!-- Floating Button -->
    @if(Auth::check() && Auth::user()->role == 'user')  <!-- Only show for students -->
      <button class="floating-btn" id="addReportBtn">
        <i class="bi bi-plus"></i>
      </button>
    @endif
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/view.js') }}"></script>
  <script src="{{ asset('js/report_form.js') }}"></script>
  <script src="{{ asset('js/item_overlay.js') }}"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @if(Auth::check() && Auth::user()->role === 'admin')  <!-- Only load manage.js for admins -->
    <script src="{{ asset('js/manage.js') }}"></script>
  @endif
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/analytics.js') }}"></script> 
  <script>
    window.userRole = '{{ Auth::user()->role }}';
  </script>
</body>
</html>