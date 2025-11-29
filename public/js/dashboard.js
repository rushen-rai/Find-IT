    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.querySelector(".search-bar input");
        const filters = document.querySelectorAll(".filters select");
        const reportGrid = document.querySelector(".report-grid");
        const reportTitle = document.querySelector(".reports h3");
        const categoryElements = document.querySelectorAll(".category");

        let allItems = Array.from(document.querySelectorAll(".report-card")).map(card => ({
            element: card,
            name: card.querySelector("h4")?.textContent.toLowerCase() || "",
            category: card.querySelector("p")?.textContent.toLowerCase() || "",
            location: card.querySelector(".bi-geo-alt")?.parentElement?.textContent
                ?.replace("📍", "")
                ?.trim()
                ?.toLowerCase() || "",
            reportType: card.classList.contains("lost") ? "lost" : "found",
            date: card.querySelector(".bi-clock")?.parentElement?.textContent.trim() || "",
        }));

        // Track active category for filtering
        let activeCategory = null;

        const debounce = (fn, delay = 300) => {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => fn(...args), delay);
            };
        };

        // render filtered items in batches
        function renderItems(items) {
            reportGrid.innerHTML = "";
            const fragment = document.createDocumentFragment();
            const batchSize = 10;
            let i = 0;

            // items in batches
            function renderBatch() {
                for (let j = 0; j < batchSize && i < items.length; j++, i++) {
                    fragment.appendChild(items[i].element);
                }
                reportGrid.appendChild(fragment);
                if (i < items.length) requestAnimationFrame(renderBatch);
            }
            requestAnimationFrame(renderBatch);

            // Update report title based on filtered results
            if (items.length === allItems.length && !activeCategory) {
                reportTitle.textContent = "Recent Reports";
            } else {
                reportTitle.textContent = `Results (${items.length} item${items.length !== 1 ? "s" : ""})`;
            }
        }

        // update category counts based on filtered items
        function updateCategoryCounts(items) {
            categoryElements.forEach(catEl => {
                const catName = catEl.querySelector("h3").textContent.toLowerCase();
                const count = items.filter(item => item.category.includes(catName)).length;
                catEl.querySelector(".count").textContent = `${count} item${count !== 1 ? "s" : ""}`;
            });
        }

        // search and filter
        function applyFilters() {
            const query = searchInput.value.trim().toLowerCase();
            const [timeFilter, locationFilter, statusFilter] = Array.from(filters).map(f =>
                f.value.toLowerCase()
            );

            // Filter based on query, location, status, and active category
            let filtered = allItems.filter(item => {
                const matchQuery =
                    item.name.includes(query) ||
                    item.category.includes(query) ||
                    item.location.includes(query);

                const normalizedLocation = item.location.replace(/_/g, " ");
                const matchLocation =
                    locationFilter === "location" || normalizedLocation.includes(locationFilter);
                const matchStatus = statusFilter === "status" || item.reportType === statusFilter;
                const matchCategory = !activeCategory || item.category.includes(activeCategory);

                return matchQuery && matchLocation && matchStatus && matchCategory;
            });

            // Sort by time
            if (timeFilter === "oldest") filtered = [...filtered].reverse();

            updateCategoryCounts(filtered);
            renderItems(filtered);
        }

        // search input
        searchInput.addEventListener("input", debounce(applyFilters, 300));

        // filter selects
        filters.forEach(filter => filter.addEventListener("change", applyFilters));

        // category filtering
        const categories = document.querySelectorAll(".category");
        categories.forEach(cat => {
            cat.addEventListener("click", () => {
                const categoryName = cat.querySelector("h3").textContent.toLowerCase();
                const isActive = cat.classList.contains("active");

                if (isActive) {
                    cat.classList.remove("active");
                    activeCategory = null;
                    applyFilters();
                    reportTitle.textContent = "Recent Reports";
                    return;
                }

                categories.forEach(c => c.classList.remove("active"));
                cat.classList.add("active");
                activeCategory = categoryName;

                // filters with active category
                applyFilters();
                const filtered = allItems.filter(item => item.category.includes(categoryName));
                reportTitle.textContent = `${categoryName.charAt(0).toUpperCase() + categoryName.slice(1)} (${filtered.length} item${filtered.length !== 1 ? "s" : ""})`;

                document.querySelector(".reports").scrollIntoView({ behavior: "smooth" });
            });
        });

        applyFilters();
    });

    // notifications and alerts
    document.addEventListener("DOMContentLoaded", () => {
        const notifIcon = document.getElementById("notifIcon");
        const alertIcon = document.getElementById("alertIcon");
        const notifMenu = document.getElementById("notifMenu");
        const alertMenu = document.getElementById("alertMenu");
        const notifList = document.getElementById("notifList");
        const alertList = document.getElementById("alertList");

        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        // notification menu
        notifIcon.addEventListener("click", () => {
            notifMenu.classList.toggle("active");
            alertMenu.classList.remove("active");
            loadNotifications();
        });

        // alert menu
        alertIcon.addEventListener("click", () => {
            alertMenu.classList.toggle("active");
            notifMenu.classList.remove("active");
            loadAlerts();
        });

        // fetch and display notifications
        window.loadNotifications = async function() {
            const res = await fetch("/notifications");
            const data = await res.json();
            notifList.innerHTML = data.length
                ? data.map(n => `
                    <li data-id="${n.id}" data-type="notification" class="notif-item">
                    <div class="notif-header">
                        <i class="bi bi-bell-fill notif-icon"></i>
                        <span class="notif-title">${n.title}</span>
                        ${n.status ? `<span class="badge status ${n.status}">${n.status}</span>` : ''}
                        ${n.label ? `<span class="badge label ${n.label}">${n.label}</span>` : ''}
                    </div>
                    <small class="notif-message">${n.message}</small>
                    </li>
                `).join("")
                : "<li>No notifications</li>";
        };

        // fetch and display alerts
        async function loadAlerts() {
            const res = await fetch("/alerts");
            const data = await res.json();
            alertList.innerHTML = data.length
                ? data.map(a => `
                    <li data-id="${a.id}" data-type="alert" data-related-id="${a.related_id}" class="alert-item">
                    <div class="alert-header">
                        <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
                        <span class="alert-title">${a.title}</span>
                        <span class="badge status ${a.status}">${a.status}</span>
                        <span class="badge label ${a.label}">${a.label}</span>
                    </div>
                    <small class="alert-message">${a.message}</small>
                    </li>
                `).join("")
                : "<li>No alerts</li>";
        }

        // Mark notification or alert as read on click
        document.body.addEventListener("click", async e => {
            if (e.target.closest("li[data-id]")) {
                const li = e.target.closest("li");
                const id = li.dataset.id;
                const type = li.dataset.type;
                const relatedId = li.dataset.relatedId;

                // If it's a match_found alert, open the item overlay
                if (type === 'alert' && li.querySelector('.alert-title')?.textContent === 'Potential Match Found') {
                    try {
                        const itemRes = await fetch(`/items/${relatedId}/details`);
                        const item = await itemRes.json();
                        // Open the overlay (ensure item_overlay.js is loaded)
                        if (window.showItemOverlay) {
                            window.showItemOverlay(item);
                        }
                    } catch (error) {
                        console.error('Error opening overlay for match:', error);
                    }
                }

                // Mark as read
                const endpoint = type === 'alert' ? `/alerts/mark-read/${id}` : `/mark-read/${id}`;
                await fetch(endpoint, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrf,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ type })
                });

                li.style.opacity = "0.5";
            }
        });
    });

    // sidebar navigation
    document.addEventListener("DOMContentLoaded", () => {
        const sidebarLinks = document.querySelectorAll(".sidebar__menu a");
        const categoriesSection = document.querySelector(".categories-section");
        const reportsSection = document.querySelector(".reports");
        const analyticsSection = document.querySelector(".analytics-content");
        const manageSection = document.querySelector(".manage-content");
        const mainHeader = document.querySelector(".main > .header");
        const headerTitle = mainHeader.querySelector(".header__text h3");
        const headerSubtitle = mainHeader.querySelector(".header__text h4");
        const dashboardFilters = mainHeader.querySelector(".dashboard-filters");
        const manageFilters = mainHeader.querySelector(".manage-filters");

        // click listeners view switching
        sidebarLinks.forEach(link => {
            link.addEventListener("click", e => {
                e.preventDefault();

                sidebarLinks.forEach(l => l.classList.remove("active"));
                link.classList.add("active");

                const view = link.dataset.view;

                // Switch content
                if (view === "dashboard") {
                    headerTitle.textContent = "Find Lost & Found Items";
                    headerSubtitle.textContent = "Search through reported items and browse by category";
                    dashboardFilters.style.display = "flex";
                    manageFilters.style.display = "none";
                    mainHeader.style.display = "block";
                    categoriesSection.style.display = "block";
                    reportsSection.style.display = "block";
                    analyticsSection.style.display = "none";
                    if (manageSection) manageSection.style.display = "none";
                } else if (view === "analytics") {
                    mainHeader.style.display = "none";
                    categoriesSection.style.display = "none";
                    reportsSection.style.display = "none";
                    analyticsSection.style.display = "block";
                    if (manageSection) manageSection.style.display = "none";
                } else if (view === "manage") {
                    headerTitle.textContent = "Manage Reports & Claims";
                    headerSubtitle.textContent = "Search and filter reports and claims";
                    dashboardFilters.style.display = "none";
                    manageFilters.style.display = "flex";
                    mainHeader.style.display = "block";
                    categoriesSection.style.display = "none";
                    reportsSection.style.display = "none";
                    analyticsSection.style.display = "none";
                    if (manageSection) manageSection.style.display = "block";
                }
            });
        });
    });


    function applyFilters() {
    const query = searchInput.value.trim().toLowerCase();
    const [timeFilter, locationFilter, statusFilter] = Array.from(filters).map(f => f.value.toLowerCase());

    let filtered = allItems.filter(item => {
        const matchQuery =
            item.name.includes(query) ||
            item.category.includes(query) ||
            item.location.includes(query);

        const normalizedLocation = item.location.replace(/_/g, " ");
        const matchLocation = locationFilter === "location" || normalizedLocation.includes(locationFilter);
        const matchStatus = statusFilter === "status" || item.reportType === statusFilter;
        const matchCategory = !activeCategory || item.category.includes(activeCategory);

        return matchQuery && matchLocation && matchStatus && matchCategory;
    });

    if (timeFilter === "oldest") filtered = [...filtered].reverse();

    updateCategoryCounts(filtered);
    renderItems(filtered);
}
