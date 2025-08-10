function setBannerDarknessOnScroll() {
    const topBannerImage = document.querySelector('.banner-topo-image');
    const topBannerContainer = document.querySelector('.banner-topo');
    if (!topBannerImage) return;

    const bannerRect = topBannerImage.getBoundingClientRect();
    const bannerHeight = topBannerImage.offsetHeight;

    function updateDarkness() {
        const rect = topBannerImage.getBoundingClientRect();
        // Calculate how much of the banner is visible
        const visible = Math.max(0, Math.min(rect.bottom, window.innerHeight) - Math.max(rect.top, 0));
        // Darkness: 0 when fully visible, 1 when not visible
        const darkness = 1 - (visible / bannerHeight);
        // Clamp between 0 and 1, then map to 0.4-1 range
        const normalizedDarkness = Math.max(0, Math.min(darkness, 1));
        const clampedDarkness = 0.4 + (normalizedDarkness * 0.6); // Maps 0-1 to 0.4-1
        // Apply darkness using a pseudo-element or overlay
        topBannerImage.style.position = 'relative';
        topBannerImage.style.setProperty('--banner-darkness', clampedDarkness);

        // Ensure banner is above navbar and not hidden
        const header = document.querySelector('.header'); // Adjust selector as needed
        if (header) {
            const headerHeight = header.offsetHeight;
            topBannerContainer.style.marginTop = `${headerHeight}px`;
        }

        // Add overlay if not present
        if (!topBannerImage.querySelector('.banner-dark-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'banner-dark-overlay';
            overlay.style.position = 'absolute';
            overlay.style.top = 0;
            overlay.style.left = 0;
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.pointerEvents = 'none';
            overlay.style.transition = 'background 0s';
            topBannerImage.appendChild(overlay);
        }
        const overlay = topBannerImage.querySelector('.banner-dark-overlay');
        overlay.style.background = `rgba(0,0,0,${clampedDarkness})`; // 0.7 is max darkness
    }

    window.addEventListener('scroll', updateDarkness);
    window.addEventListener('resize', updateDarkness);
    updateDarkness();
}

document.addEventListener('DOMContentLoaded', setBannerDarknessOnScroll);