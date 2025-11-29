// Initialize manage functionality when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    // Select manage content elements
    const manageContent = document.querySelector(".manage-content");
    const reportsGrid = document.getElementById("reportsGrid");
    const claimsGrid = document.getElementById("claimsGrid");
    const manageSearch = document.getElementById("manageSearch");
    const manageFilter = document.getElementById("manageFilter");
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // Track current active tab
    let currentTab = "reports";

    // Cache all report cards for efficient filtering
    let allReports = Array.from(document.querySelectorAll("#reportsGrid .manage-card")).map(card => ({
        element: card,
        title: card.querySelector("h4")?.textContent.toLowerCase() || "",
        description: card.querySelector("p")?.textContent.toLowerCase() || "",
        status: card.querySelector(".status")?.textContent.toLowerCase() || "",
        date: card.querySelector("p:last-child")?.textContent.replace("Date: ", "").trim() || "",
    }));

    // Cache all claim cards for efficient filtering
    let allClaims = Array.from(document.querySelectorAll("#claimsGrid .manage-card")).map(card => ({
        element: card,
        title: card.querySelector("h4")?.textContent.toLowerCase() || "",
        description: card.querySelector("p")?.textContent.toLowerCase() || "",
        status: card.querySelector(".status")?.textContent.toLowerCase() || "",
        date: card.querySelector("p:last-child")?.textContent.replace("Date: ", "").trim() || "",
    }));

    // Debounce function to limit filter execution frequency
    const debounce = (fn, delay = 300) => {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => fn(...args), delay);
        };
    };

    // Function to render filtered grid based on tab, search, and filter
    function renderGrid(tab) {
        const grid = tab === "reports" ? reportsGrid : claimsGrid;
        const allItems = tab === "reports" ? allReports : allClaims;
        const query = manageSearch?.value.toLowerCase() || "";
        const filter = manageFilter?.value || "all";

        // Filter items based on search query and status filter
        const filtered = allItems.filter(item => {
            const matchesSearch = item.title.includes(query) || item.description.includes(query);
            const matchesFilter = filter === "all" || item.status === filter;
            return matchesSearch && matchesFilter;
        });

        // Hide all cards, then show only filtered ones
        allItems.forEach(item => item.element.style.display = "none");
        filtered.forEach(item => item.element.style.display = "block");

        // Update title dynamically based on filters
        const tabName = tab === "reports" ? "Reports" : "Claims";
        const filterName = filter === "all" ? "All" : filter.charAt(0).toUpperCase() + filter.slice(1);
        const titleText = filtered.length === allItems.length ? `${filterName} ${tabName}` : `${filterName} ${tabName} (${filtered.length})`;
        const manageTitle = document.getElementById("manageTitle");
        if (manageTitle) manageTitle.textContent = titleText;
    }

    // Handle tab switching
    const manageTab = document.getElementById("manageTab");
    if (manageTab) {
        manageTab.addEventListener("change", () => {
            currentTab = manageTab.value;
            document.getElementById("reportsTab").style.display = currentTab === "reports" ? "block" : "none";
            document.getElementById("claimsTab").style.display = currentTab === "claims" ? "block" : "none";
            renderGrid(currentTab);
        });
    }

    // Add debounced search input listener
    if (manageSearch) manageSearch.addEventListener("input", debounce(() => renderGrid(currentTab)));
    // Add filter change listener
    if (manageFilter) manageFilter.addEventListener("change", () => renderGrid(currentTab));

    // Function to delete item from DOM and cache
    async function deleteItem(id, tab) {
        try {
            // Make API call to delete
            const endpoint = tab === "reports" ? `/reports/${id}` : `/claims/${id}`;
            const response = await fetch(endpoint, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) throw new Error("Delete failed");

            // Remove from DOM and cache on success
            const card = document.querySelector(`.manage-card[data-id="${id}"]`);
            if (card) card.remove();

            if (tab === "reports") {
                allReports = allReports.filter(item => item.element.dataset.id != id);
            } else {
                allClaims = allClaims.filter(item => item.element.dataset.id != id);
            }
            renderGrid(currentTab);

            // Success alert
            alert("Deleted successfully!");
            
            // Reload notifications for admin
            if (window.loadNotifications) window.loadNotifications();
        } catch (error) {
            alert("Failed to delete item. Please try again.");
        }
    }

    // Function to update item status in DOM and database
    async function updateStatus(id, status, tab) {
        try {
            const endpoint = tab === "reports" ? `/reports/${id}/${status}` : `/claims/${id}/${status}`;
            const response = await fetch(endpoint, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) throw new Error("Update failed");

            // Otherwise, just update status visually
            const card = document.querySelector(`.manage-card[data-id="${id}"] .status`);
            if (card) {
                card.textContent = status;
                card.className = `status ${status}`;
            }

            const allItems = tab === "reports" ? allReports : allClaims;
            const item = allItems.find(item => item.element.dataset.id == id);
            if (item) item.status = status;

            renderGrid(currentTab);

            if (status === "approved") alert("Approved successfully!");
            else if (status === "rejected") alert("Rejected successfully!");

            if (window.loadNotifications) window.loadNotifications();

        } catch (error) {
            alert("Failed to update status. Please try again.");
        }
    }

    // Function to claim item (delete item and claim) - Moved inside scope
    async function claimItem(id, tab) {
        try {
            const response = await fetch(`/claims/${id}/claimed`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) throw new Error("Claim failed");

            // Remove from DOM and cache
            const card = document.querySelector(`.manage-card[data-id="${id}"]`);
            if (card) card.remove();

            if (tab === "claims") {
                allClaims = allClaims.filter(item => item.element.dataset.id != id);
            }
            renderGrid(currentTab);

            alert("Item claimed and removed successfully!");
            
            // Reload notifications
            if (window.loadNotifications) window.loadNotifications();
        } catch (error) {
            alert("Failed to claim item. Please try again.");
        }
    }

    // Handle action button clicks (view, approve, delete, reject, claimed) - Consolidated
    document.addEventListener("click", async (e) => {
        const btn = e.target.closest("button[data-action]");
        if (!btn) return;

        const action = btn.dataset.action;
        const card = btn.closest(".manage-card");
        const id = card?.dataset.id;

        if (action === "view") {
            // Parse item data and show overlay if function exists
            const item = JSON.parse(card.dataset.item);
            if (typeof showItemOverlay === "function") {
                showItemOverlay(item, true, currentTab, id); // Pass isManage, tab, and id
            }
        } else if (action === "approve") {
            // Add confirmation dialog for approve
            const itemType = currentTab === "reports" ? "report" : "claim";
            const confirmed = confirm(`Are you sure you want to approve this ${itemType}? This action cannot be undone.`);
            if (confirmed) {
                await updateStatus(id, "approved", currentTab);
            }
        } else if (action === "delete") {
            if (confirm("Are you sure you want to delete this item?")) {
                await deleteItem(id, currentTab);
            }
        } else if (action === "reject") {
            await updateStatus(id, "rejected", currentTab);
        } else if (action === "claimed") {
            // Handle claimed action
            const confirmed = confirm("Are you sure you want to mark this claim as claimed? This will remove the item and claim from the system.");
            if (confirmed) {
                await claimItem(id, currentTab);
            }
        }
    });

    // Initial render for reports tab
    if (manageContent) renderGrid("reports");
});
