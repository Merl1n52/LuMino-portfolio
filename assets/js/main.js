/**
 * LUMINO DESIGN STUDIO — CORE JAVASCRIPT (DARK EDITION)
 * Features:
 * 1. Interactive Halftone / Dot Matrix Canvas (matching shy-walrus-733223.framer.app)
 * 2. Live Studio Clock in Bottom Dock
 * 3. Smooth Navigation & Scroll
 * 4. Adaptive Cards ratio handler
 */

document.addEventListener('DOMContentLoaded', () => {
    initDotMatrixCanvas();
    initLiveClock();
    initAdaptiveCards();
    initSmoothScroll();
    initDrawerMenu();
});

/**
 * Interactive Dot Matrix Canvas
 * Recreates the Framer Interactive_Grid algorithm:
 * Grid of squares that dynamically expand and illuminate as the cursor moves over them.
 */
function initDotMatrixCanvas() {
    const canvas = document.getElementById('lumino-interactive-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height;
    let mouse = { x: -1000, y: -1000, active: false };
    let time = 0;

    // Config matching donor aesthetic
    const dotSize = 2.5;         // Base dot/square size in px
    const maxDotSize = 8.5;      // Max size when cursor is near
    const dotSpacing = 16;       // Spacing between dots
    const distanceThreshold = 140; // Proximity threshold

    function resize() {
        const rect = canvas.parentElement.getBoundingClientRect();
        const dpr = window.devicePixelRatio || 1;
        width = rect.width;
        height = rect.height;

        canvas.width = width * dpr;
        canvas.height = height * dpr;
        ctx.scale(dpr, dpr);
    }

    window.addEventListener('resize', resize);
    resize();

    // Mouse Tracking
    const parent = canvas.parentElement;
    parent.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
        mouse.active = true;
    });

    parent.addEventListener('mouseleave', () => {
        mouse.active = false;
    });

    // Touch Tracking for mobile devices
    parent.addEventListener('touchmove', (e) => {
        if (e.touches.length > 0) {
            const rect = canvas.getBoundingClientRect();
            mouse.x = e.touches[0].clientX - rect.left;
            mouse.y = e.touches[0].clientY - rect.top;
            mouse.active = true;
        }
    }, { passive: true });

    parent.addEventListener('touchend', () => {
        mouse.active = false;
    });

    // Animation Loop
    function render() {
        time += 0.02;
        ctx.clearRect(0, 0, width, height);

        const cols = Math.floor(width / dotSpacing);
        const rows = Math.floor(height / dotSpacing);
        const startX = (width - cols * dotSpacing) / 2 + dotSpacing / 2;
        const startY = (height - rows * dotSpacing) / 2 + dotSpacing / 2;

        for (let r = 0; r <= rows; r++) {
            for (let c = 0; c <= cols; c++) {
                const x = startX + c * dotSpacing;
                const y = startY + r * dotSpacing;

                let factor = 0;

                if (mouse.active) {
                    const dist = Math.hypot(mouse.x - x, mouse.y - y);
                    factor = Math.exp(-dist / distanceThreshold);
                } else {
                    // Subtle ambient wave ripple when idle
                    const waveX = Math.sin(c * 0.15 + time) * 0.5 + 0.5;
                    const waveY = Math.cos(r * 0.15 + time) * 0.5 + 0.5;
                    factor = waveX * waveY * 0.35;
                }

                const currentSize = dotSize + (maxDotSize - dotSize) * factor;
                const opacity = 0.12 + 0.88 * factor;

                ctx.fillStyle = `rgba(255, 255, 255, ${opacity.toFixed(3)})`;
                ctx.fillRect(x - currentSize / 2, y - currentSize / 2, currentSize, currentSize);
            }
        }

        requestAnimationFrame(render);
    }

    requestAnimationFrame(render);
}

/**
 * Live Real-Time Studio Clock in Bottom Dock
 */
function initLiveClock() {
    const clockElement = document.getElementById('lumino-live-clock');
    if (!clockElement) return;

    const timeZone = clockElement.getAttribute('data-timezone') || undefined;

    function updateTime() {
        try {
            const now = new Date();
            const options = {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true,
                ...(timeZone ? { timeZone } : {})
            };
            const timeFormatter = new Intl.DateTimeFormat('en-US', options);
            clockElement.textContent = timeFormatter.format(now);
        } catch (e) {
            const now = new Date();
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12;
            clockElement.textContent = `${hours}:${minutes} ${ampm}`;
        }
    }

    updateTime();
    setInterval(updateTime, 1000);
}

/**
 * Adaptive Cards Helper:
 * Ensures custom-ratio images adapt smoothly without distortion.
 */
function initAdaptiveCards() {
    const cards = document.querySelectorAll('.lumino-dark-card');
    cards.forEach(card => {
        const frame = card.querySelector('.lumino-dark-card__frame');
        const img = card.querySelector('.lumino-dark-card__img');
        if (!frame || !img) return;

        const handleLoad = () => {
            if (img.naturalWidth && img.naturalHeight) {
                if (frame.classList.contains('lumino-dark-card__frame--adaptive')) {
                    frame.style.aspectRatio = `${img.naturalWidth} / ${img.naturalHeight}`;
                }
            }
        };

        if (img.complete && img.naturalWidth) {
            handleLoad();
        } else {
            img.addEventListener('load', handleLoad);
        }
    });
}

/**
 * Smooth Navigation Scroll
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            const targetEl = document.querySelector(targetId);
            if (targetEl) {
                e.preventDefault();
                targetEl.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
}

/**
 * Split-Screen / Side Drawer Menu (Donor Style)
 */
function initDrawerMenu() {
    const toggleBtn = document.getElementById('lumino-top-toggle');
    const drawer = document.getElementById('lumino-drawer-menu');
    const backdrop = document.getElementById('lumino-menu-backdrop');
    const closeBtn = document.getElementById('lumino-drawer-close');
    const emailBtn = document.getElementById('lumino-copy-email');

    if (!drawer) return;

    function openDrawer() {
        drawer.classList.add('is-open');
        if (backdrop) backdrop.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeDrawer() {
        drawer.classList.remove('is-open');
        if (backdrop) backdrop.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            openDrawer();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            closeDrawer();
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', () => {
            closeDrawer();
        });
    }

    // ESC key closes drawer
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && drawer.classList.contains('is-open')) {
            closeDrawer();
        }
    });

    // Close drawer when any internal navigation link is clicked
    drawer.querySelectorAll('.lumino-drawer__link').forEach(link => {
        link.addEventListener('click', () => {
            closeDrawer();
        });
    });

    // Copy email helper
    if (emailBtn) {
        const textSpan = emailBtn.querySelector('.lumino-email-text');
        const originalText = textSpan ? textSpan.textContent : '';
        const email = emailBtn.getAttribute('data-email') || originalText;

        emailBtn.addEventListener('click', (e) => {
            if (navigator.clipboard && email) {
                navigator.clipboard.writeText(email).then(() => {
                    if (textSpan) {
                        textSpan.textContent = 'Copied to clipboard!';
                        setTimeout(() => {
                            textSpan.textContent = originalText;
                        }, 2000);
                    }
                }).catch(() => {
                    // Fallback to mailto
                    window.location.href = `mailto:${email}`;
                });
            }
        });
    }
}

