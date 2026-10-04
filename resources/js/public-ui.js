import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

function reducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

export function initPublicUi() {
    const root = document.querySelector('[data-public-ui]') ?? document.querySelector('main.site-main');
    if (!root) {
        return;
    }

    if (reducedMotion()) {
        root.querySelectorAll('[data-eq-reveal]').forEach((el) => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        return;
    }

    const hero = root.querySelector('[data-eq-hero]');
    if (hero) {
        const lines = hero.querySelectorAll('[data-eq-hero-line]');
        const ctas = hero.querySelectorAll('[data-eq-hero-cta]');
        const media = hero.querySelector('[data-eq-hero-media]');
        gsap.timeline({ defaults: { ease: 'power4.out' } })
            .from(lines, { y: 72, autoAlpha: 0, duration: 1.05, stagger: 0.12 })
            .from(ctas, { y: 24, autoAlpha: 0, duration: 0.75, stagger: 0.08 }, '-=0.55');
        if (media) {
            gsap.fromTo(media, { scale: 1.08 }, { scale: 1, duration: 2.4, ease: 'power2.out' });
        }
    }

    gsap.set(root.querySelectorAll('[data-eq-reveal]'), { autoAlpha: 0, y: 32 });
    root.querySelectorAll('[data-eq-reveal]').forEach((el) => {
        gsap.to(el, {
            autoAlpha: 1,
            y: 0,
            duration: 0.95,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 88%',
                once: true,
            },
        });
    });

    root.querySelectorAll('[data-eq-parallax]').forEach((el) => {
        gsap.to(el, {
            yPercent: 12,
            ease: 'none',
            scrollTrigger: {
                trigger: el.closest('section') ?? el,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.6,
            },
        });
    });

    ScrollTrigger.refresh();
}
