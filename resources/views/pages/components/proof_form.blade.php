<div class="proofform-overlay" id="proofformOverlay">
  <div class="proofform-container">
    <button class="proofform-close" type="button">&times;</button>
    <h2>Proof of ownership</h2>

    <form id="proofForm" enctype="multipart/form-data">
      <input type="hidden" name="item_id" id="proof_item_id" value="">

      <!-- Claim Details -->
      <section class="proofform-section">
        <h3>Claim Details</h3>
        <div class="proofform-grid">
          <div class="proofform-group">
            <label>Full Name</label>
            <input type="text" name="full_name" placeholder="ex: Juan Dela Cruz" required>
          </div>
          <div class="proofform-group">
            <label>Contact Details</label>
            <input type="text" name="contact_details" placeholder="+63" required>
          </div>
        </div>
      </section>

      <!-- Item Description -->
      <section class="proofform-section">
        <h3>Item Description</h3>
        <div class="proofform-grid">
          <div class="proofform-group">
            <label>Item Name</label>
            <input type="text" name="item_name" id="proof_item_name" placeholder="e.g., iPhone 18 Pro" required>
          </div>
          <div class="proofform-group">
            <label>Unique Identifier</label>
            <input type="text" name="unique_identifier" placeholder="e.g., Serial Number">
          </div>
        </div>

        <div class="proofform-group">
          <label>Item Description</label>
          <textarea name="description" placeholder="Brand, color, features, condition, etc." rows="3"></textarea>
        </div>

        <div class="proofform-group">
          <label>Upload Photo</label>
          <!-- file input name must match controller validation ("photo") -->
          <input type="file" name="photo" accept="image/*">
        </div>
      </section>

      <!-- Date & Location -->
      <section class="proofform-section">
        <h3>Date & Location Lost</h3>
        <div class="proofform-grid">
          <div class="proofform-group">
            <label>Location</label>
            <select name="location" required>
              <option value="">Select Location</option>
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
          </div>
          <div class="proofform-group">
            <label>Additional Location</label>
            <input type="text" name="add_location" placeholder="e.g., Near Exit Gate">
          </div>
        </div>
      </section>

      <!-- Actions -->
      <div class="proofform-actions">
        <button type="button" class="proofform-btn proofform-clear">Clear</button>
        <button type="submit" class="proofform-btn proofform-submit">Submit</button>
      </div>
    </form>
  </div>
</div>

<!-- script -->
<script src="{{ asset('js/proof_form.js') }}"></script>