<div class="admin-approval-overlay" id="adminApprovalOverlay">
  <div class="admin-approval-container">
    <!-- Close Button -->
    <button type="button" class="admin-approval-close" aria-label="Close">&times;</button>

    <!-- Header -->
    <h2 id="adminApprovalTitle">Admin Approval Request</h2>

    <!-- Report Details -->
    <section class="admin-approval-section">
      <h3>Item / Report Details</h3>
      <div class="admin-approval-grid">
        <div class="admin-approval-group">
          <label for="adminApprovalItemId">Item ID</label>
          <div id="adminApprovalItemId" class="admin-approval-field">—</div>
        </div>

        <div class="admin-approval-group">
          <label for="adminApprovalItemName">Item Name</label>
          <div id="adminApprovalItemName" class="admin-approval-field">—</div>
        </div>

        <div class="admin-approval-group">
          <label for="adminApprovalType">Type</label>
          <div id="adminApprovalType" class="admin-approval-field">—</div>
        </div>
      </div>
    </section>

    <!-- Status Section -->
    <section class="admin-approval-section">
      <h3>Status</h3>
      <div class="admin-approval-status">
        <span id="adminApprovalStatus" class="status-label pending">Pending</span>
      </div>
      <p class="admin-approval-message">
        Your request has been submitted successfully and is awaiting admin review.
      </p>
    </section>
  </div>
</div>

