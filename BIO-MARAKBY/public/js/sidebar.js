document.addEventListener('DOMContentLoaded', () => {
  // Loop through all sidebars
  document.querySelectorAll('[id$="-sidebar"]').forEach(sidebar => {
    const prefix = sidebar.id.split('-')[0];
    const openBtn = document.getElementById(`${prefix}-sidebar-open`);
    const closeBtn = document.getElementById(`${prefix}-sidebar-close`);
    const overlay = document.getElementById(`${prefix}-sidebar-overlay`);
    const videoIframe = document.querySelector('iframe[src*="youtube.com"]');
    // Enhanced media query to consider mobile devices more accurately
    const mq = window.matchMedia('(min-width: 768px) and (orientation: portrait), (min-width: 1024px)');

    function setSidebar(open) {
      if (mq.matches) {
        // Desktop or tablet in portrait: sidebar is always visible, overlay hidden
        sidebar.classList.remove('translate-x-full');
        sidebar.style.zIndex = '20'; // Ensure sidebar is above video
        overlay.classList.add('hidden');
        if (videoIframe) {
          videoIframe.style.zIndex = '0'; // Video below sidebar
        }
      } else {
        // Mobile (including landscape): handle open/close states
        if (open) {
          sidebar.classList.remove('translate-x-full');
          sidebar.style.zIndex = '30'; // Sidebar above video and overlay
          overlay.classList.remove('hidden');
          overlay.style.zIndex = '20'; // Overlay below sidebar but above video
          if (videoIframe) {
            videoIframe.style.zIndex = '10'; // Video below overlay
          }
        } else {
          sidebar.classList.add('translate-x-full');
          sidebar.style.zIndex = '0'; // Sidebar below video when closed
          overlay.classList.add('hidden');
          if (videoIframe) {
            videoIframe.style.zIndex = '10'; // Video remains visible
          }
        }
      }
    }

    openBtn?.addEventListener('click', () => setSidebar(true));
    closeBtn?.addEventListener('click', () => setSidebar(false));
    overlay?.addEventListener('click', () => setSidebar(false));

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') setSidebar(false);
    });

    if (mq.addEventListener) {
      mq.addEventListener('change', () => setSidebar(false));
    } else if (mq.addListener) {
      mq.addListener(() => setSidebar(false));
    }

    // Initial state
    setSidebar(false);
  });
});
