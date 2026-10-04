import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

const APPLE_EASE = 'power3.out';

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
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
                trigger: el,
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

export function initScrollAnimations() {
    if (prefersReducedMotion()) {
        return;
    }

    const root = document.querySelector('main.site-main');

    if (!root) {
        return;
    }

    initHeroEntrances(root);
    initStatCounters(document);

    ScrollTrigger.refresh();
}
