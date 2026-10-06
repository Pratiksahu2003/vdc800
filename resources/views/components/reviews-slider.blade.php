@php
    $reviewsData = $testimonials->map(fn ($t) => [
        'name' => $t->name,
        'role' => $t->role,
        'company' => $t->company,
        'location' => $t->location,
        'quote' => $t->quote,
        'rating' => $t->rating,
        'initials' => collect(explode(' ', $t->name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->join(''),
    ])->values();
@endphp

<section class="py-20 lg:py-28 bg-brand-100 border-y border-brand-200" x-data="reviewsSlider(@js($reviewsData))" @mouseenter="stopAutoplay()" @mouseleave="reviews.length > 1 && startAutoplay()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-brand-teal-600 text-sm font-medium tracking-widest uppercase mb-2">Client Stories</p>
            <h2 class="font-display text-4xl text-brand-900 mb-3">Trusted Across India &amp; Europe</h2>
            <p class="text-brand-600">What technology leaders say about partnering with VDC800 for sustainable Nordic infrastructure.</p>
        </div>

        <template x-if="reviews.length">
            <div class="relative max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl border border-brand-200 shadow-lg p-8 lg:p-12 min-h-[280px] flex flex-col justify-center">
                    <div class="flex gap-1 mb-6">
                        <template x-for="star in 5" :key="'star-' + star">
                            <i
                                data-lucide="star"
                                class="w-5 h-5"
                                :class="star <= (current().rating || 5) ? 'text-amber-400 fill-amber-400' : 'text-brand-200'"
                            ></i>
                        </template>
                    </div>

                    <blockquote class="text-lg lg:text-xl text-brand-800 leading-relaxed mb-8">
                        &ldquo;<span x-text="current().quote"></span>&rdquo;
                    </blockquote>

                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 rounded-full bg-brand-teal-600 text-white font-semibold flex items-center justify-center text-lg shrink-0"
                            x-text="current().initials"
                        ></div>
                        <div>
                            <p class="font-semibold text-brand-900 text-lg" x-text="current().name"></p>
                            <p class="text-sm text-brand-600">
                                <span x-text="current().role"></span>
                                <template x-if="current().company">
                                    <span> · </span><span x-text="current().company"></span>
                                </template>
                            </p>
                            <p class="text-xs text-brand-teal-600 mt-0.5" x-show="current().location" x-text="current().location"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-4 mt-8">
                    <button
                        type="button"
                        @click="prev()"
                        class="p-2.5 rounded-full border border-brand-200 bg-white text-brand-600 hover:bg-brand-teal-50 hover:text-brand-teal-700 hover:border-brand-teal-200 transition"
                        aria-label="Previous review"
                    >
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </button>

                    <div class="flex items-center gap-2">
                        <template x-for="(review, index) in reviews" :key="'dot-' + index">
                            <button
                                type="button"
                                @click="goTo(index)"
                                class="h-2 rounded-full transition-all duration-300"
                                :class="active === index ? 'w-8 bg-brand-teal-600' : 'w-2 bg-brand-300 hover:bg-brand-teal-400'"
                                :aria-label="'Review ' + (index + 1)"
                            ></button>
                        </template>
                    </div>

                    <button
                        type="button"
                        @click="next()"
                        class="p-2.5 rounded-full border border-brand-200 bg-white text-brand-600 hover:bg-brand-teal-50 hover:text-brand-teal-700 hover:border-brand-teal-200 transition"
                        aria-label="Next review"
                    >
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </template>
    </div>
</section>
