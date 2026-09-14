import './bootstrap';
import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { createIcons, icons } from 'lucide';
import { initScrollAnimations } from './scroll-animations';

window.Alpine = Alpine;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

gsap.registerPlugin(ScrollTrigger);

const uploadHelpers = {
    assignFileToInput(input, file) {
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        input.files = dataTransfer.files;
    },
    isAccepted(file, accept) {
        if (!accept) return true;
        const rules = accept.split(',').map((rule) => rule.trim()).filter(Boolean);
        return rules.some((rule) => {
            if (rule.endsWith('/*')) {
                return file.type.startsWith(rule.slice(0, -1));
            }
            if (rule.startsWith('.')) {
                return file.name.toLowerCase().endsWith(rule.toLowerCase());
            }
            return file.type === rule;
        });
    },
};

Alpine.data('imageUploader', (options = {}) => ({
    preview: null,
    fileName: null,
    isDragging: false,
    maxSize: options.maxSize ?? 5 * 1024 * 1024,
    init() {
        this.preview = this.$el.dataset.existing || null;
    },
    onDragOver() {
        this.isDragging = true;
    },
    onDragLeave() {
        this.isDragging = false;
    },
    onDrop(event) {
        this.isDragging = false;
        const file = event.dataTransfer?.files?.[0];
        if (file) {
            this.processFile(file);
        }
    },
    handleFileSelect(event) {
        const file = event.target.files?.[0];
        if (file) {
            this.processFile(file);
        }
    },
    processFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            this.clearInput();
            return;
        }
        if (file.size > this.maxSize) {
            alert(`Image must be smaller than ${Math.round(this.maxSize / (1024 * 1024))}MB.`);
            this.clearInput();
            return;
        }
        uploadHelpers.assignFileToInput(this.$refs.fileInput, file);
        this.fileName = file.name;
        const reader = new FileReader();
        reader.onload = (e) => { this.preview = e.target.result; };
        reader.readAsDataURL(file);
        if (this.$refs.removeField) {
            this.$refs.removeField.value = '0';
        }
    },
    clearInput() {
        if (this.$refs.fileInput) {
            this.$refs.fileInput.value = '';
        }
        this.fileName = null;
    },
    remove() {
        this.preview = null;
        this.clearInput();
        if (this.$refs.removeField) {
            this.$refs.removeField.value = '1';
        }
    },
}));

Alpine.data('fileUploader', (options = {}) => ({
    preview: null,
    fileName: null,
    isDragging: false,
    accept: options.accept ?? '',
    maxSize: options.maxSize ?? 10 * 1024 * 1024,
    mode: options.mode ?? 'file',
    init() {},
    onDragOver() {
        this.isDragging = true;
    },
    onDragLeave() {
        this.isDragging = false;
    },
    onDrop(event) {
        this.isDragging = false;
        const file = event.dataTransfer?.files?.[0];
        if (file) {
            this.processFile(file);
        }
    },
    handleFileSelect(event) {
        const file = event.target.files?.[0];
        if (file) {
            this.processFile(file);
        }
    },
    processFile(file) {
        if (!uploadHelpers.isAccepted(file, this.accept)) {
            alert('This file type is not allowed.');
            this.clearInput();
            return;
        }
        if (file.size > this.maxSize) {
            alert(`File must be smaller than ${Math.round(this.maxSize / (1024 * 1024))}MB.`);
            this.clearInput();
            return;
        }
        uploadHelpers.assignFileToInput(this.$refs.fileInput, file);
        this.fileName = file.name;
        if (this.mode === 'image' && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => { this.preview = e.target.result; };
            reader.readAsDataURL(file);
        } else {
            this.preview = null;
        }
    },
    clearInput() {
        if (this.$refs.fileInput) {
            this.$refs.fileInput.value = '';
        }
        this.fileName = null;
        this.preview = null;
    },
}));

Alpine.data('benefitsManager', (initial = []) => ({
    benefits: initial.length ? initial : [''],
    add() { this.benefits.push(''); },
    remove(index) {
        if (this.benefits.length > 1) this.benefits.splice(index, 1);
    },
}));

Alpine.data('toastManager', () => ({
    toasts: [],
    init() {
        window.addEventListener('toast', (e) => this.show(e.detail.type, e.detail.message));
        document.querySelectorAll('[data-flash]').forEach((el) => {
            this.show(el.dataset.flash, el.textContent.trim());
        });
    },
    show(type, message) {
        const id = Date.now();
        this.toasts.push({ id, type, message });
        setTimeout(() => this.dismiss(id), 5000);
    },
    dismiss(id) {
        this.toasts = this.toasts.filter((t) => t.id !== id);
    },
}));

Alpine.data('heroCarousel', (slidesJson = '[]') => ({
    slides: [],
    active: 0,
    progress: 0,
    timer: null,
    duration: 5000,
    init() {
        try {
            this.slides = typeof slidesJson === 'string' ? JSON.parse(slidesJson) : slidesJson;
        } catch {
            this.slides = [];
        }
        this.$nextTick(() => this.ensureMutedPlayback());
        if (this.slides.length > 1) {
            this.startAutoplay();
        }
    },
    ensureMutedPlayback() {
        const video = this.$refs.heroVideo;
        if (!video) {
            return;
        }
        video.muted = true;
        video.defaultMuted = true;
        video.volume = 0;
        const play = () => video.play().catch(() => {});
        play();
        video.addEventListener('canplay', play, { once: true });
    },
    destroy() {
        this.stopAutoplay();
    },
    current() {
        return this.slides[this.active] ?? {};
    },
    goTo(index) {
        if (index < 0 || index >= this.slides.length) return;
        this.active = index;
        this.resetAutoplay();
    },
    next() {
        this.active = (this.active + 1) % this.slides.length;
        this.resetAutoplay();
    },
    startAutoplay() {
        this.stopAutoplay();
        this.progress = 0;
        const tick = 50;
        this.timer = setInterval(() => {
            this.progress += (tick / this.duration) * 100;
            if (this.progress >= 100) {
                this.next();
            }
        }, tick);
    },
    stopAutoplay() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    },
    resetAutoplay() {
        this.progress = 0;
        if (this.slides.length > 1) {
            this.startAutoplay();
        }
    },
}));

Alpine.data('siteNav', () => ({
    open: false,
    servicesMenu: false,
    solutionsMenu: false,
    blogMenu: false,
    mobileServicesOpen: false,
    mobileSolutionsOpen: false,
    mobileBlogOpen: false,
    closeMenus() {
        this.servicesMenu = false;
        this.solutionsMenu = false;
        this.blogMenu = false;
    },
    openServicesMenu() {
        this.solutionsMenu = false;
        this.blogMenu = false;
        this.servicesMenu = true;
        this.positionDropdown(this.$refs.servicesPanel);
    },
    openSolutionsMenu() {
        this.servicesMenu = false;
        this.blogMenu = false;
        this.solutionsMenu = true;
        this.positionDropdown(this.$refs.solutionsPanel);
    },
    openBlogMenu() {
        this.servicesMenu = false;
        this.solutionsMenu = false;
        this.blogMenu = true;
        this.positionDropdown(this.$refs.blogPanel);
    },
    positionDropdown(panel) {
        if (!panel) {
            return;
        }

        this.$nextTick(() => {
            requestAnimationFrame(() => {
                const trigger = panel.closest('[data-nav-dropdown]');
                if (!trigger) {
                    return;
                }

                panel.style.left = '0px';
                panel.style.right = 'auto';
                panel.style.transform = '';

                const padding = 16;
                const viewportWidth = document.documentElement.clientWidth;
                const triggerRect = trigger.getBoundingClientRect();
                const panelWidth = panel.getBoundingClientRect().width;

                if (!panelWidth) {
                    return;
                }

                // Center the panel under its trigger, then clamp inside the viewport.
                let left = (triggerRect.width - panelWidth) / 2;
                let absoluteLeft = triggerRect.left + left;
                let absoluteRight = absoluteLeft + panelWidth;

                if (absoluteLeft < padding) {
                    left += padding - absoluteLeft;
                    absoluteLeft = triggerRect.left + left;
                    absoluteRight = absoluteLeft + panelWidth;
                }

                if (absoluteRight > viewportWidth - padding) {
                    left -= absoluteRight - (viewportWidth - padding);
                }

                panel.style.left = `${left}px`;
            });
        });
    },
}));

Alpine.data('reviewsSlider', (reviewsJson = '[]') => ({
    reviews: [],
    active: 0,
    timer: null,
    duration: 6000,
    init() {
        try {
            this.reviews = typeof reviewsJson === 'string' ? JSON.parse(reviewsJson) : reviewsJson;
        } catch {
            this.reviews = [];
        }
        if (this.reviews.length > 1) {
            this.startAutoplay();
        }
    },
    destroy() {
        this.stopAutoplay();
    },
    current() {
        return this.reviews[this.active] ?? {};
    },
    goTo(index) {
        if (index < 0 || index >= this.reviews.length) return;
        this.active = index;
        this.resetAutoplay();
    },
    next() {
        this.active = (this.active + 1) % this.reviews.length;
        this.resetAutoplay();
    },
    prev() {
        this.active = (this.active - 1 + this.reviews.length) % this.reviews.length;
        this.resetAutoplay();
    },
    startAutoplay() {
        this.stopAutoplay();
        this.timer = setInterval(() => this.next(), this.duration);
    },
    stopAutoplay() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    },
    resetAutoplay() {
        if (this.reviews.length > 1) {
            this.startAutoplay();
        }
    },
}));

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
    initScrollAnimations();

    document.querySelectorAll('.cms-content table').forEach((table) => {
        if (table.closest('.cms-table-wrap')) {
            return;
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'cms-table-wrap';
        table.parentNode?.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });
});

document.addEventListener('alpine:initialized', () => {
    createIcons({ icons });
});
