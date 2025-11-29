<div class="reportform-overlay" id="reportformOverlay">
  <div class="reportform-container">
    <button class="reportform-close">&times;</button>
    <h2>Report Lost / Found Item</h2>

    <form id="reportForm" 
          method="POST" 
          action="{{ route('reports.store') }}" 
          enctype="multipart/form-data"
          autocomplete="off">
      @csrf

      <!-- Report Type -->
      <section class="reportform-section">
        <h3>Report Type</h3>
        <div class="reportform-type-options">
          <button type="button" class="reportform-type-btn active" data-type="lost">Lost Item</button>
          <button type="button" class="reportform-type-btn" data-type="found">Found Item</button>
          <input type="hidden" name="report_type" id="report_type" value="lost">
        </div>
      </section>

      <!-- Item Description -->
      <section class="reportform-section">
        <h3>Item Description</h3>
        <div class="reportform-grid">
          <div class="reportform-group">
            <label>Item Name</label>
            <input type="text" name="item_name" placeholder="e.g., iPhone 18 Pro" class="form-group__input" required>
          </div>
          <div class="reportform-group">
          <label>Category</label>
          <select name="category" class="form-group__input" required>
            <option value="">Select Category</option>
            <option value="Electronics & Gadgets">Electronics &amp; Gadgets</option>
            <option value="Bags & Accessories">Bags &amp; Accessories</option>
            <option value="Clothing & Wearables">Clothing &amp; Wearables</option>
            <option value="Documents & IDs">Documents &amp; IDs</option>
            <option value="School Supplies">School Supplies</option>
            <option value="Personal Items">Personal Items</option>
          </select>
        </div>
        </div>

        <div class="reportform-group">
          <label>Item Description</label>
          <textarea name="description" placeholder="Brand, color, features, condition, etc." rows="3" class="form-group__input"></textarea>
        </div>

        <div class="reportform-group">
          <label>Upload Photo</label>
          <input type="file" name="photo" accept="image/png, image/jpeg, image/jpg" class="form-group__input">
        </div>
      </section>

      <!-- Date & Location -->
      <section class="reportform-section">
        <h3>Date & Location</h3>
        <div class="reportform-grid">
          <div class="reportform-group">
            <label>Location</label>
            <select name="location" class="form-group__input" required>
              <option value="">Select Location</option>
              <option value="front_gate">Front Gate</option>
              <option value="back_gate">Back Gate</option>
              <option value="unp_gymnasium">UNP Gymnasium</option>
              <option value="unp_pavillion">UNP Pavillion</option>
              <option value="unp_main_library">UNP Main Library</option>
              <option value="unp_graduate_library">UNP Graduate Library</option>
              <option value="unp_oval">UNP Oval</option>
              <option value="canteen">Canteen</option>
              <option value="unp_admin">UNP Admin</option>
              <option value="unp_student_center">UNP Student Center</option>
              <option value="new_admin_building">New Admin Building</option>
              <option value="architecture">Architecture</option>
              <option value="arts_and_sciences">Arts and Sciences</option>
              <option value="business_administration_and_accountancy">Business Administration and Accountancy</option>
              <option value="criminal_justice_and_education">Criminal Justice and Education</option>
              <option value="communication_and_information_technology">Communication and Information Technology</option>
              <option value="health_sciences">Health Sciences</option>
              <option value="public_administration">Public Administration</option>
              <option value="teacher_education">Teacher Education</option>
              <option value="engineering">Engineering</option>
              <option value="nursing">Nursing</option>
              <option value="medicine">Medicine</option>
              <option value="law">Law</option>
              <option value="hospitality_and_tourism_management">Hospitality and Tourism Management</option>
              <option value="fine_arts_and_design">Fine Arts and Design</option>
              <option value="technology">Technology</option>
            </select>
          </div>
          <div class="reportform-group">
            <label>Additional Location</label>
            <input type="text" name="add_location" placeholder="e.g., Near Exit Gate" class="form-group__input">
          </div>
        </div>

        <div class="reportform-group">
          <label>Date</label>
          <input type="date" name="date_reported" class="form-group__input" required>
        </div>
      </section>

      <!-- Buttons -->
      <div class="reportform-actions">
        <button type="button" class="reportform-btn reportform-clear">Clear</button>
        <button type="submit" class="reportform-btn reportform-submit">Submit</button>
      </div>
    </form>
  </div>
</div>

<!-- script -->
<script src="{{ asset('js/report_form.js') }}"></script>