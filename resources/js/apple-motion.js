import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

/** Apple-like deceleration (matches common marketing-site easing). */
export const MOTION_EASE = 'power3.out';
export const MOTION_EASE_ENTER = 'power4.out';

const REVEAL_START = 'top 86%';

export function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function markRevealed(...elements) {
    elements.flat().forEach((el) => {
        if (el instanceof Element) {
            el.classList.add('eq-revealed');
        }
    });
}

function createRevealTween(targets, section, { stagger = 0.09, duration = 0.95 } = {}) {
    const list = gsap.utils.toArray(targets);
    if (!list.length) {
        return null;
    }

    return gsap.fromTo(
        list,
        { autoAlpha: 0, y: 28, scale: 0.985 },
        {
            autoAlpha: 1,
            y: 0,
            scale: 1,
            duration,
            stagger: list.length > 1 ? stagger : 0,
            ease: MOTION_EASE,
            immediateRender: false,
            scrollTrigger: {
                trigger: section,
                start: REVEAL_START,
                once: true,
                toggleActions: 'play none none none',
            },
            onComplete: () => markRevealed(list, section),
        },
    );
}

function collectSectionTargets(section) {
    const container =
        section.querySelector(':scope > div[class*="max-w"]') ??
        section.querySelector(':scope > div') ??
        section;

    const gridItems = container.querySelectorAll(':scope .grid > *');
    const targets = [];

    const intro =
        container.querySelector(':scope > .max-w-3xl') ??
        container.querySelector(':scope > h2.eq-headline-section') ??
        container.querySelector(':scope > h2') ??
        container.querySelector(':scope > header');

    if (intro && gridItems.length >= 2) {
        targets.push(intro);
        gridItems.forEach((el) => targets.push(el));
        return targets;
    }

    if (gridItems.length >= 2) {
        gridItems.forEach((el) => targets.push(el));
        return targets;
    }

    const flexRow = container.querySelector(':scope > .flex.flex-wrap');
    if (flexRow && gridItems.length >= 1) {
        targets.push(flexRow);
        gridItems.forEach((el) => targets.push(el));
        return targets;
    }

    const motionItems = section.querySelectorAll('[data-eq-motion-item]');
    if (motionItems.length) {
        return gsap.utils.toArray(motionItems);
    }

    const direct = gsap.utils.toArray(container.children).filter(
        (el) => el.tagName !== 'SCRIPT' && !el.hasAttribute('data-eq-parallax'),
    );

    if (direct.length >= 1 && direct.length <= 8) {
        return direct;
    }

    return [section];
}

function initScrollReveals(root) {
    gsap.utils.toArray(root.querySelectorAll('[data-eq-reveal]')).forEach((section) => {
        const targets = collectSectionTargets(section);
        const useSectionFallback = targets.length === 1 && targets[0] === section;

        if (useSectionFallback) {
            createRevealTween(section, section, { stagger: 0, duration: 0.95 });
            return;
        }

        section.classList.add('eq-reveal-host');
        createRevealTween(targets, section);
    });
}

function initPageHero(root) {
    root.querySelectorAll('[data-page-hero-content]').forEach((hero) => {
        const items = gsap.utils.toArray(hero.children);
        if (!items.length) {
            return;
        }
        gsap.fromTo(
            items,
            { autoAlpha: 0, y: 40, scale: 0.98 },
            {
                autoAlpha: 1,
                y: 0,
                scale: 1,
                duration: 1.1,
                stagger: 0.11,
                ease: MOTION_EASE_ENTER,
                delay: 0.15,
                onComplete: () => markRevealed(items),
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
            { scale: 1.08 },
            {
                scale: 1.18,
                ease: 'none',
                scrollTrigger: {
                    trigger: section,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 0.85,
                    invalidateOnRefresh: true,
                },
            },
        );
    });
}

function initHomeHero(root) {
    const hero = root.querySelector('[data-eq-hero]');
    if (!hero) {
        return;
    }

    const lines = hero.querySelectorAll('[data-eq-hero-line]');
    const ctas = hero.querySelectorAll('[data-eq-hero-cta]');
    const media = hero.querySelector('[data-eq-hero-media]');
    const stats = hero.querySelector('.eq-hero__stats');

    gsap
        .timeline({
            defaults: { ease: MOTION_EASE_ENTER },
            onComplete: () => markRevealed(hero),
        })
        .from(lines, { y: 44, autoAlpha: 0, duration: 1.05, stagger: 0.09 })
        .from(ctas, { y: 22, autoAlpha: 0, duration: 0.8, stagger: 0.06 }, '-=0.5')
        .from(stats?.children ?? [], { y: 16, autoAlpha: 0, duration: 0.75, stagger: 0.06 }, '-=0.35');

    if (media) {
        const video = media.querySelector('video');
        gsap.fromTo(media, { scale: 1.08 }, { scale: 1, duration: 2.6, ease: 'power2.out' });
        if (video) {
            gsap.fromTo(
                video,
                { scale: 1.14 },
                { scale: 1.02, duration: 3, ease: 'power2.out' },
            );
        }
    }
}

function initParallax(root) {
    root.querySelectorAll('[data-eq-parallax]').forEach((el) => {
        gsap.fromTo(
            el,
            { yPercent: 0 },
            {
                yPercent: 14,
                ease: 'none',
                scrollTrigger: {
                    trigger: el.closest('section') ?? el,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 0.65,
                    invalidateOnRefresh: true,
                },
            },
        );
    });
}

function initStatCounters(scope) {
    scope.querySelectorAll('[data-stat-counter]').forEach((el) => {
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
            duration: 1.65,
            ease: MOTION_EASE,
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

function initChromeEntrances() {
    const nav = document.querySelector('[data-site-nav]');
    if (nav) {
        gsap.from(nav, {
            y: -16,
            autoAlpha: 0,
            duration: 0.85,
            ease: MOTION_EASE_ENTER,
            delay: 0.05,
        });
    }

    const fab = document.querySelector('.eq-chat-fab');
    if (fab) {
        gsap.from(fab, {
            scale: 0.85,
            autoAlpha: 0,
            duration: 0.7,
            ease: MOTION_EASE,
            delay: 0.45,
        });
    }

    const footer = document.querySelector('[data-site-footer]');
    if (footer) {
        const blocks = gsap.utils.toArray(footer.querySelectorAll('[data-eq-footer-block]'));
        if (blocks.length) {
            gsap.fromTo(
                blocks,
                { autoAlpha: 0, y: 28, scale: 0.985 },
                {
                    autoAlpha: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.9,
                    stagger: 0.12,
                    ease: MOTION_EASE,
                    immediateRender: false,
                    scrollTrigger: {
                        trigger: footer,
                        start: REVEAL_START,
                        once: true,
                        toggleActions: 'play none none none',
                    },
                    onComplete: () => markRevealed(blocks),
                },
            );
        }
    }
}

function resetMotionHidden(root) {
    document.documentElement.classList.remove('eq-motion-js');
    root.querySelectorAll('[data-eq-reveal], [data-eq-footer-block]').forEach((el) => {
        el.classList.add('eq-revealed');
        el.style.opacity = '';
        el.style.transform = '';
    });
}

function syncScrollTriggers() {
    requestAnimationFrame(() => {
        ScrollTrigger.refresh(true);
    });
}

function bindScrollRefresh() {
    window.addEventListener('load', syncScrollTriggers, { once: true });
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            syncScrollTriggers();
        }
    });

    let resizeTimer = null;
    window.addEventListener(
        'resize',
        () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(syncScrollTriggers, 200);
        },
        { passive: true },
    );
}

let motionInitialized = false;

export function initAppleMotion() {
    if (motionInitialized) {
        syncScrollTriggers();
        return;
    }
    motionInitialized = true;

    const root = document.querySelector('[data-public-ui]') ?? document.querySelector('main.site-main');

    if (!root) {
        return;
    }

    if (prefersReducedMotion()) {
        resetMotionHidden(root);
        return;
    }

    document.documentElement.classList.add('eq-motion-js');
    bindScrollRefresh();

    initChromeEntrances();
    initHomeHero(root);
    initPageHero(root);
    initScrollReveals(root);
    initParallax(root);
    initStatCounters(document);

    syncScrollTriggers();
}
