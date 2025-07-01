document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const sidebarOpen = document.getElementById('sidebar-open');
    const sidebarClose = document.getElementById('sidebar-close');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar?.classList.toggle('translate-x-full');
        sidebarOverlay?.classList.toggle('hidden');
    }

    sidebarOpen?.addEventListener('click', toggleSidebar);
    sidebarClose?.addEventListener('click', toggleSidebar);
    sidebarOverlay?.addEventListener('click', toggleSidebar);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar && !sidebar.classList.contains('translate-x-full')) {
            toggleSidebar();
        }
    });
});
