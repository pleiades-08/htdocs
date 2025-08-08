const sidebar = document.getElementById("sidebar");

    // Load sidebar state on page load
    document.addEventListener("DOMContentLoaded", () => {
        const state = localStorage.getItem("sidebarState");

        if (state === "expanded") {
            sidebar.classList.add("sidebar-expanded");
            sidebar.classList.remove("sidebar-collapsed");
            updateLabels(true);
        } else {
            sidebar.classList.add("sidebar-collapsed");
            sidebar.classList.remove("sidebar-expanded");
            updateLabels(false);
        }
    });

    function toggleSidebar() {
        const isExpanded = sidebar.classList.contains("sidebar-expanded");

        sidebar.classList.toggle("sidebar-expanded");
        sidebar.classList.toggle("sidebar-collapsed");

        // Save the state
        localStorage.setItem("sidebarState", isExpanded ? "collapsed" : "expanded");

        updateLabels(!isExpanded);
    }

    function updateLabels(visible) {
        document.querySelectorAll(".label").forEach(label => {
            label.classList.toggle("label-visible", visible);
            label.classList.toggle("label-hidden", !visible);
        });
    }