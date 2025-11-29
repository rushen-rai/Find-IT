// Initialize item overlay functionality when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    // Select overlay and close button elements
    const overlay = document.getElementById("itemOverlay");
    const closeBtn = document.querySelector(".close-overlay");

    // Add click listeners to view buttons to show item overlay
    document.querySelectorAll(".report-card .view-item-btn").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const card = e.target.closest(".report-card");
            const item = JSON.parse(card.dataset.item);
            showItemOverlay(item); // Default for non-manage
        });
    });

    // Function to display item details in the overlay
    window.showItemOverlay = async function (item, isManage = false, tab = 'reports', manageId = null) {
        // Store current item ID for proof submission
        window.currentItemId = item.item_id;

        // Populate overlay fields with item data
        document.getElementById("itemName").textContent = item.item_name || "Unnamed Item";
        document.getElementById("itemCategory").textContent = item.category || "Uncategorized";
        document.getElementById("itemDescription").textContent = item.description || "No description provided.";
        document.getElementById("itemLocation").textContent = item.location || "No location info";
        document.getElementById("itemAddLocation").textContent = item.add_location || "No additional info";
        document.getElementById("itemStatus").textContent = item.status || "Active";

        // Set report type label and class
        const typeEl = document.getElementById("itemType");
        if (typeEl) {
            const reportType = (item.report_type || "lost").toLowerCase();
            typeEl.textContent = reportType.toUpperCase();
            typeEl.className = `label ${reportType}`;
        }

        // Format and display date reported
        const formattedDate = item.date_reported
            ? new Date(item.date_reported).toLocaleString("en-US", {
                weekday: "short",
                year: "numeric",
                month: "short",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            })
            : "N/A";
        document.getElementById("itemDate").textContent = formattedDate;

        // Populate reporter details
        document.getElementById("reporterName").textContent = item.user?.name || "Unknown Reporter";
        document.getElementById("reporterEmail").textContent = item.user?.email || "No email";

        // Set item photo source with fallback
        const itemPhoto = document.getElementById("itemPhoto");
        itemPhoto.src = item.photo ? `/storage/${item.photo}` : "{{ asset('images/no-image.png') }}";

        // Handle claims: Fetch and display claim details
        const claimDetailsSection = document.getElementById("claimDetailsSection");
        if (tab === 'claims' && isManage) {
            if (claimDetailsSection) claimDetailsSection.style.display = "grid"; // Show claim section
            try {
                const response = await fetch(`/claims/${manageId}/details`); // Fixed URL
                if (!response.ok) throw new Error("Failed to fetch claim details");
                const claim = await response.json();

                // Populate claim details with null checks (fixed IDs to match HTML)
                const claimDescriptionEl = document.getElementById("claimDescription");
                if (claimDescriptionEl) {
                    claimDescriptionEl.textContent = claim.description || "No claim description.";
                } else {
                    console.warn("Element with ID 'claimDescription' not found in DOM.");
                }

                // Updated: Use user name and email for claimant details
                const claimantNameEl = document.getElementById("claimantName");
                if (claimantNameEl) {
                    claimantNameEl.textContent = claim.user?.name || "Unknown Claimant";
                } else {
                    console.warn("Element with ID 'claimantName' not found in DOM.");
                }

                const claimantContactEl = document.getElementById("claimantContact");
                if (claimantContactEl) {
                    claimantContactEl.textContent = claim.user?.email || "No email";
                } else {
                    console.warn("Element with ID 'claimantContact' not found in DOM.");
                }

                const claimantLocationEl = document.getElementById("claimantLocation");
                if (claimantLocationEl) {
                    claimantLocationEl.textContent = claim.location || "No location";
                } else {
                    console.warn("Element with ID 'claimantLocation' not found in DOM.");
                }

                // Added: Populate additional location
                const claimAddLocationEl = document.getElementById("claimAddLocation");
                if (claimAddLocationEl) {
                    claimAddLocationEl.textContent = claim.add_location || "No additional location";
                } else {
                    console.warn("Element with ID 'claimAddLocation' not found in DOM.");
                }

                const claimUniqueIdentifierEl = document.getElementById("claimUniqueIdentifier");
                if (claimUniqueIdentifierEl) {
                    claimUniqueIdentifierEl.textContent = claim.unique_identifier || "No unique identifier";
                } else {
                    console.warn("Element with ID 'claimUniqueIdentifier' not found in DOM.");
                }

                // Set claim proof photo
                const claimPhotoEl = document.getElementById("claimPhoto");
                if (claimPhotoEl) {
                    claimPhotoEl.src = claim.photo ? `/storage/${claim.photo}` : "{{ asset('images/no-image.png') }}";
                } else {
                    console.warn("Element with ID 'claimPhoto' not found in DOM.");
                }
            } catch (error) {
                console.error("Error loading claim details:", error);
                alert("Failed to load claim details.");
            }
        } else {
            if (claimDetailsSection) claimDetailsSection.style.display = "none"; // Hide for reports or non-manage
        }

        // Show overlay and prevent body scrolling
        overlay.classList.add("active");
        document.body.classList.add("no-scroll");

        // Attach action button functionality (Claim or Approve)
        attachActionButton(isManage, tab, manageId);
    };

    // Close overlay on close button click
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            overlay.classList.remove("active");
            document.body.classList.remove("no-scroll");
        });
    }

    // Close overlay on outside click
    overlay.addEventListener("click", (e) => {
        if (e.target === overlay) {
            overlay.classList.remove("active");
            document.body.classList.remove("no-scroll");
        }
    });

    // Function to attach action button event handler (Claim or Approve)
    function attachActionButton(isManage, tab, manageId) {
        const actionBtn = document.getElementById("claimBtn");
        if (!actionBtn) return;

        if (isManage) {
            // For manage mode: Show "Approve" button
            actionBtn.textContent = "Approve";
            actionBtn.onclick = async () => {
                const itemType = tab === "reports" ? "report" : "claim";
                const confirmed = confirm(`Are you sure you want to approve this ${itemType}? This action cannot be undone.`);
                if (!confirmed) return;

                try {
                    const endpoint = `/${tab}/${manageId}/approved`;
                    const response = await fetch(endpoint, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Content-Type": "application/json"
                        }
                    });

                    if (!response.ok) throw new Error("Approve failed");

                    alert("Approved successfully!");
                    overlay.classList.remove("active");
                    document.body.classList.remove("no-scroll");
                    // Reload notifications
                    if (window.loadNotifications) window.loadNotifications();
                } catch (error) {
                    alert("Failed to approve. Please try again.");
                }
            };
        } else {
            // For non-manage mode: Show "Claim" button
            actionBtn.textContent = "Claim";
            actionBtn.onclick = async () => {
                let proofOverlay = document.getElementById("proofformOverlay");

                if (!proofOverlay) {
                    try {
                        const response = await fetch("/proof");
                        const html = await response.text();
                        document.body.insertAdjacentHTML("beforeend", html);
                        proofOverlay = document.getElementById("proofformOverlay");

                        const cssPath = "/css/components/proof_form.css";
                        if (![...document.styleSheets].some(s => s.href && s.href.includes("proof_form.css"))) {
                            const link = document.createElement("link");
                            link.rel = "stylesheet";
                            link.href = cssPath;
                            document.head.appendChild(link);
                        }
                    } catch (error) {
                        alert("Failed to load proof form. Please try again.");
                        return;
                    }
                }

                const closeProofBtn = proofOverlay.querySelector(".proofform-close");
                if (closeProofBtn) {
                    closeProofBtn.onclick = () => proofOverlay.classList.remove("active");
                }

                proofOverlay.addEventListener("click", (e) => {
                    if (e.target === proofOverlay) proofOverlay.classList.remove("active");
                });

                proofOverlay.classList.add("active");
            };
        }
    }

    // Handle proof form submission (unchanged)
    document.addEventListener("submit", async (e) => {
        const form = e.target.closest("#proofForm");
        if (!form) return;
        e.preventDefault();

        const formData = new FormData(form);
        if (window.currentItemId) formData.append("item_id", window.currentItemId);

        try {
            const response = await fetch("/claims", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData,
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const result = await response.json();

            form.reset();
            document.getElementById("proofformOverlay").classList.remove("active");

            if (!window.showAdminApprovalOverlay) {
                await loadScript("/js/admin_approval.js");
            }

            if (result.success && typeof showAdminApprovalOverlay === "function") {
                showAdminApprovalOverlay(result.item);
                startStatusPolling(result.item.id, result.item.item_id);
            }

            alert("Claim submitted successfully!");
        } catch (err) {
            alert("Something went wrong. Please try again.");
        }
    });

    // Function to poll claim status for dynamic updates (unchanged)
    function startStatusPolling(claimId, itemId) {
        const pollInterval = setInterval(async () => {
            try {
                const response = await fetch(`/claims/${claimId}/status`);
                if (!response.ok) throw new Error("Polling failed");

                const data = await response.json();
                if (data.status !== "pending") {
                    if (typeof showAdminApprovalOverlay === "function") {
                        showAdminApprovalOverlay({ ...data, item_id: itemId });
                    }
                    clearInterval(pollInterval);
                }
            } catch (error) {
                console.error("Error polling status:", error);
                clearInterval(pollInterval);
            }
        }, 10000);
    }

    // Function to load script dynamically (unchanged)
    async function loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement("script");
            script.src = src;
            script.onload = resolve;
            script.onerror = () => reject(new Error(`Failed to load script: ${src}`));
            document.body.appendChild(script);
        });
    }
});
