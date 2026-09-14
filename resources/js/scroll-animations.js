import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

const APPLE_EASE = 'power3.out';
const APPLE_EASE_IN_OUT = 'power2.inOut';

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function revealFadeUp(elements, options = {}) {
    const targets = gsap.utils.toArray(elements);

    if (!targets.length) {
        return;
    }

    gsap.fromTo(
        targets,
        { autoAlpha: 0, y: options.distance ?? 52 },
        {
            autoAlpha: 1,
            y: 0,
            duration: options.duration ?? 1,
            ease: APPLE_EASE,
            stagger: options.stagger ?? 0,
            scrollTrigger: {
                trigger: options.trigger ?? targets[0],
                start: options.start ?? 'top 88%',
                toggleActions: 'play none none none',
                once: true,
            },
        },
    );
}

function revealScale(elements, options = {}) {
    const targets = gsap.utils.toArray(elements);

    if (!targets.length) {
        return;
    }

    gsap.fromTo(
        targets,
        { autoAlpha: 0, scale: options.fromScale ?? 0.94 },
        {
            autoAlpha: 1,
            scale: 1,
            duration: options.duration ?? 1.1,
            ease: APPLE_EASE,
            scrollTrigger: {
                trigger: options.trigger ?? targets[0],
                start: options.start ?? 'top 88%',
                toggleActions: 'play none none none',
                once: true,
            },
        },
    );
}

function initNavbarScroll() {
    const nav = document.querySelector('[data-site-nav]');

    if (!nav) {
        return;
    }

    const updateNav = () => {
        nav.classList.toggle('nav-scrolled', window.scrollY > 12);
    };

    updateNav();
    window.addEventListener('scroll', updateNav, { passive: true });
}

function initHeroEntrances(root) {
    root.querySelectorAll('[data-page-hero-content]').forEach((hero) => {
        const items = gsap.utils.toArray(hero.children);

        if (!items.length) {
            return;
        }

        gsap.fromTo(
            items,
            { autoAlpha: 0, y: 36 },
            {
                autoAlpha: 1,
                y: 0,
                duration: 1.05,
                stagger: 0.1,
                ease: APPLE_EASE,
                delay: 0.12,
            },
        );
    });

    root.querySelectorAll('.page-hero-section').forEach((section) => {
        const image = section.querySelector('[data-hero-parallax]');

        if (!image) {
            return;
        }

        gsap.fromTo(
            image,
            { scale: 1.05 },
            {
                scale: 1.14,
                ease: 'none',
                scrollTrigger: {
                    trigger: section,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 0.8,
                },
            },
        );
    });
}

function initRevealElements(root) {
    root.querySelectorAll('[data-reveal="fade-up"]').forEach((el) => {
        revealFadeUp(el);
    });

    root.querySelectorAll('[data-reveal="scale"]').forEach((el) => {
        revealScale(el);
    });

    root.querySelectorAll('[data-reveal="stagger"]').forEach((container) => {
        const children = container.querySelectorAll('[data-reveal-child]');

        if (!children.length) {
            return;
        }

        revealFadeUp(children, {
            trigger: container,
            stagger: 0.09,
            distance: 40,
            duration: 0.92,
            start: 'top 86%',
        });
    });

    root.querySelectorAll('[data-reveal="split"]').forEach((section) => {
        const text = section.querySelector('[data-reveal-text]');
        const media = section.querySelector('[data-reveal-media]');

        if (text) {
            revealFadeUp(text, { trigger: section, distance: 44 });
        }

        if (media) {
            revealScale(media, { trigger: section, fromScale: 0.96 });
        }
    });
}

function initAutoGridStaggers(root) {
    root.querySelectorAll('section .grid').forEach((grid) => {
        if (grid.dataset.reveal || grid.closest('[data-reveal="stagger"]')) {
            return;
        }

        if (grid.querySelector('[data-reveal-child]')) {
            return;
        }

        const items = [...grid.children].filter((child) => child.nodeType === 1);

        if (items.length < 2 || items.length > 12) {
            return;
        }

        items.forEach((item) => item.setAttribute('data-reveal-child', ''));
        grid.setAttribute('data-reveal', 'stagger');

        revealFadeUp(items, {
            trigger: grid,
            stagger: 0.08,
            distance: 36,
            duration: 0.88,
            start: 'top 87%',
        });
    });

    root.querySelectorAll('section > div > h2, section > div > div > h2').forEach((heading) => {
        if (heading.closest('[data-reveal]') || heading.hasAttribute('data-reveal')) {
            return;
        }

        const block = heading.closest('div');

        if (!block || block.querySelector('[data-reveal="stagger"]')) {
            return;
        }

        revealFadeUp(heading, {
            trigger: heading,
            distance: 32,
            duration: 0.85,
            start: 'top 90%',
        });
    });
}

function initParallax(root) {
    root.querySelectorAll('[data-parallax]').forEach((el) => {
        const strength = parseFloat(el.dataset.parallax) || 12;

        gsap.fromTo(
            el,
            { yPercent: -strength * 0.3 },
            {
                yPercent: strength * 0.3,
                ease: 'none',
                scrollTrigger: {
                    trigger: el.closest('[data-parallax-wrap]') ?? el.parentElement,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.55,
                },
            },
        );
    });
}

function initStatCounters(root) {
    root.querySelectorAll('[data-stat-counter]').forEach((el) => {
        const raw = el.textContent.trim();
        const match = raw.match(/^([\d,.]+)(.*)$/);

        if (!match) {
            return;
        }

        const target = parseFloat(match[1].replace(/,/g, ''));
        const suffix = match[2] ?? '';
        const decimals = (match[1].split('.')[1] ?? '').length;
        const state = { value: 0 };

        gsap.to(state, {
            value: target,
            duration: 1.5,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: el.closest('[data-reveal-child]') ?? el,
                start: 'top 90%',
                toggleActions: 'play none none none',
                once: true,
            },
            onUpdate: () => {
                el.textContent = `${state.value.toFixed(decimals)}${suffix}`;
            },
        });
    });
}

function initHoverLift(root) {
    root.querySelectorAll('[data-hover-lift]').forEach((card) => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card, {
                y: -6,
                scale: 1.01,
                duration: 0.35,
                ease: APPLE_EASE_IN_OUT,
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                y: 0,
                scale: 1,
                duration: 0.45,
                ease: APPLE_EASE_IN_OUT,
            });
        });
    });
}

function initFooterReveals() {
    const footer = document.querySelector('[data-site-footer]');

    if (!footer) {
        return;
    }

    const brandGrid = footer.querySelector('[data-footer-brand]');
    const linkGrid = footer.querySelector('[data-footer-links]');

    if (brandGrid) {
        revealFadeUp(brandGrid.children, {
            trigger: brandGrid,
            stagger: 0.12,
            distance: 40,
            start: 'top 92%',
        });
    }

    if (linkGrid) {
        revealFadeUp(linkGrid.children, {
            trigger: linkGrid,
            stagger: 0.08,
            distance: 28,
            start: 'top 92%',
        });
    }
}

export function initScrollAnimations() {
    if (prefersReducedMotion()) {
        return;
    }

    const root = document.querySelector('main.site-main');

    if (!root) {
        return;
    }

    initNavbarScroll();
    initHeroEntrances(root);
    initRevealElements(root);
    initAutoGridStaggers(root);
    initParallax(root);
    initStatCounters(root);
    initHoverLift(root);
    initFooterReveals();

    ScrollTrigger.refresh();
}
