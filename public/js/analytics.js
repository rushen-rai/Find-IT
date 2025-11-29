document.addEventListener("DOMContentLoaded", () => {
    const analyticsSection = document.querySelector(".analytics-content");
    const sidebarLinks = document.querySelectorAll(".sidebar__menu a");
    // chart
    let barChart, pieChart;
    // click listeners 
    sidebarLinks.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const view = link.dataset.view;
            if (view === "analytics") {
                loadAnalyticsData();
            }
        });
    });

    // fetch data
    async function loadAnalyticsData() {
        try {
            const res = await fetch("/api/analytics");
            const data = await res.json();
            // Update summary card values
            document.getElementById("lostCount").textContent = data.lostCount;
            document.getElementById("foundCount").textContent = data.foundCount;
            document.getElementById("totalReports").textContent = data.totalReports;
            document.getElementById("pendingReports").textContent = data.pendingReports;

            // Render bar chart for lost vs found by category
            const barCtx = document.getElementById("barChart").getContext("2d");
            if (barChart) barChart.destroy(); // avoid overlap
            barChart = new Chart(barCtx, {
                type: "bar",
                data: {
                    labels: data.chartData.map(d => d.category), // categories 
                    datasets: [
                        {
                            label: "Lost",
                            data: data.chartData.map(d => d.lost), // lost
                            backgroundColor: "rgba(231, 76, 60, 0.6)",
                        },
                        {
                            label: "Found",
                            data: data.chartData.map(d => d.found), // found
                            backgroundColor: "rgba(46, 204, 113, 0.6)",
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }, // starts at zero
                    },
                },
            });

            // pie chart for category
            const pieCtx = document.getElementById("pieChart").getContext("2d");
            if (pieChart) pieChart.destroy(); 
            pieChart = new Chart(pieCtx, {
                type: "pie",
                data: {
                    labels: data.categoryDistribution.map(d => d.category), // categories
                    datasets: [
                        {
                            data: data.categoryDistribution.map(d => d.count), // counts 
                            backgroundColor: [
                                "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40",
                            ],
                        },
                    ],
                },
                options: {
                    responsive: true,
                },
            });

            // top locations list
            const topLocationsList = document.getElementById("topLocationsList");
            topLocationsList.innerHTML = data.topLocations.length
                ? data.topLocations.map(loc => `<li>${loc.location} <span>${loc.count}</span></li>`).join("") // Generate list items
                : "<li>No data</li>";

            // recent activity list
            const recentActivityList = document.getElementById("recentActivityList");
            recentActivityList.innerHTML = data.recentActivity.length
                ? data.recentActivity.map(activity => `
                    <li>
                      <strong>${activity.item_name}</strong> (${activity.type} - ${activity.label})<br>
                      <small>By: ${activity.user} | ${activity.location} | ${activity.date}</small><br>
                      <small>${activity.description}</small>
                      <span class="status ${activity.status}">${activity.status}</span>
                    </li>
                  `).join("")
                : "<li>No recent activity</li>";
        } catch (error) {
            // default values
            document.getElementById("lostCount").textContent = "0";
            document.getElementById("foundCount").textContent = "0";
            document.getElementById("totalReports").textContent = "0";
            document.getElementById("pendingReports").textContent = "0";
            document.getElementById("topLocationsList").innerHTML = "<li>No data</li>";
            document.getElementById("recentActivityList").innerHTML = "<li>No recent activity</li>";
        }
    }
});



