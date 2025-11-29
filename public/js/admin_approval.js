window.showAdminApprovalOverlay = async function (data = {}) {
    let overlay = document.getElementById('adminApprovalOverlay');

    if (!overlay) {
        try {
            const response = await fetch('/admin/approval', { credentials: 'include' });
            if (!response.ok) throw new Error('Fetch failed: ' + response.status);
            const html = await response.text();
            document.body.insertAdjacentHTML('beforeend', html);
        } catch (err) {
            showErrorBanner("❌ Failed to load Admin Approval overlay: " + err.message);
            return;
        }

        // Load CSS if not already loaded
        const cssPath = '/css/components/admin_approval.css';
        if (![...document.styleSheets].some(s => s.href && s.href.includes('admin_approval.css'))) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = cssPath;
            document.head.appendChild(link);
        }

        overlay = document.getElementById('adminApprovalOverlay');
        if (!overlay) {
            showErrorBanner("⚠️ Admin Approval overlay could not be inserted.");
            return;
        }
    }

    // Helper to ensure an element exists within the overlay
    function ensureEl(id, tag = 'div', cls = '') {
        let el = overlay.querySelector('#' + id);
        if (!el) {
            el = document.createElement(tag);
            el.id = id;
            if (cls) el.className = cls;
            overlay.appendChild(el);
        }
        return el;
    }

    // Get overlay elements
    const titleEl = ensureEl('adminApprovalTitle', 'h2');
    const itemIdEl = ensureEl('adminApprovalItemId', 'div');
    const itemNameEl = ensureEl('adminApprovalItemName', 'div');
    const typeEl = ensureEl('adminApprovalType', 'div');
    const statusEl = ensureEl('adminApprovalStatus', 'span', 'status-label');

    // Determine if data is for a claim or report
    const isClaim = Boolean(data.claim_id || (data.item_name && data.full_name));
    const typeLabel = isClaim ? 'Claim' : 'Report';

    // Populate elements with provided data
    titleEl.textContent = isClaim ? 'Claim Under Review' : 'Report Under Review';
    itemIdEl.textContent = data.item_id || data.id || 'N/A';
    itemNameEl.textContent = data.item_name || data.name || 'Unnamed Item';
    typeEl.textContent = typeLabel;

    const statusText = (data.status || 'pending').toString();
    statusEl.textContent = statusText.toUpperCase();
    statusEl.className = 'status-label ' + statusText.toLowerCase();

    let messageEl = overlay.querySelector('.admin-approval-message');
    if (!messageEl) {
        messageEl = document.createElement('p');
        messageEl.className = 'admin-approval-message';
        overlay.querySelector('.admin-approval-container')?.appendChild(messageEl);
    }
    messageEl.textContent = isClaim
        ? 'Your claim has been submitted and is pending admin verification.'
        : 'Your report is awaiting admin review.';

    overlay.classList.add('active');

    // Set up close button handler
    const closeBtn = overlay.querySelector('.admin-approval-close');
    if (closeBtn) closeBtn.onclick = () => overlay.classList.remove('active');

    // close on outside click
    if (!overlay._clickHandler) {
        overlay._clickHandler = (e) => {
            if (e.target === overlay) overlay.classList.remove('active');
        };
        overlay.addEventListener('click', overlay._clickHandler);
    }

    // Helper function to show error banners
    function showErrorBanner(msg) {
        const banner = document.createElement('div');
        banner.textContent = msg;
        banner.style.cssText =
            "position:fixed;top:0;left:0;right:0;padding:10px;background:red;color:white;z-index:9999;font-weight:bold;text-align:center;";
        document.body.appendChild(banner);
        setTimeout(() => banner.remove(), 5000);
    }
};



