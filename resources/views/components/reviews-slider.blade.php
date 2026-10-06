@php
    $reviewsData = $testimonials->map(fn ($t) => [
        'name' => $t->name,
        'role' => $t->role,
        'company' => $t->company,
        'location' => $t->location,
        'quote' => $t->quote,
        'rating' => (int) ($t->rating ?: 5),
        'initials' => collect(explode(' ', $t->name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->join(''),
    ])->values();
@endphp

<section
    class="eq-reviews py-20 lg:py-28"
    data-eq-reveal
    x-data="reviewsSlider(@js($reviewsData))"
    @mouseenter="stopAutoplay()"
    @mouseleave="maxIndex > 0 && startAutoplay()"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10 lg:mb-14">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-brand-teal-600 mb-3">Customer stories</p>
                <h2 class="eq-headline-section text-brand-900">What teams say about working with D³</h2>
            </div>
            <p class="text-sm sm:text-base text-brand-600 leading-relaxed max-w-md lg:text-right lg:pb-1">
                Reviews from operators who run trading, healthcare, commerce, and cloud platforms on our facilities.
            </p>
        </div>

        <template x-if="reviews.length">
            <div>
                <div class="eq-reviews__viewport -mx-3">
                    <div class="eq-reviews__track" :style="trackStyle">
                        <template x-for="(review, index) in reviews" :key="'review-' + index">
                            <div class="eq-reviews__slide" :style="`flex-basis: ${100 / perView}%`">
                                <article class="eq-reviews__card">
                                    <div class="flex items-center justify-between gap-4 mb-5">
                                        <div class="flex gap-0.5" :aria-label="(review.rating || 5) + ' out of 5 stars'">
                                            <template x-for="star in 5" :key="'star-' + index + '-' + star">
                                                <svg viewBox="0 0 20 20" class="w-4 h-4" :class="star <= (review.rating || 5) ? 'text-amber-400' : 'text-brand-200'" fill="currentColor" aria-hidden="true">
                                                    <path d="M10 1.6l2.35 4.76 5.25.76-3.8 3.7.9 5.23L10 13.7l-4.7 2.35.9-5.23-3.8-3.7 5.25-.76L10 1.6z"/>
                                                </svg>
                                            </template>
                                        </div>
                                        <span class="text-[11px] font-bold uppercase tracking-[0.16em] text-brand-teal-600" x-text="'0' + (index + 1)"></span>
                                    </div>

                                    <blockquote class="eq-reviews__quote">
                                        <span x-text="review.quote"></span>
                                    </blockquote>

                                    <div class="mt-8 pt-6 border-t border-brand-200 flex items-center gap-3.5">
                                        <div class="eq-reviews__avatar" x-text="review.initials"></div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-brand-900 truncate" x-text="review.name"></p>
                                            <p class="text-sm text-brand-600 truncate" x-text="review.role"></p>
                                            <p class="text-xs text-brand-teal-700 mt-0.5 truncate">
                                                <span x-text="review.company"></span>
                                                <template x-if="review.location">
                                                    <span> · <span x-text="review.location"></span></span>
                                                </template>
                                            </p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-4 mt-8 lg:mt-10" x-show="maxIndex > 0">
                    <button
                        type="button"
                        @click="prev()"
                        class="eq-reviews__nav"
                        aria-label="Previous reviews"
                    >
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </button>

                    <div class="flex items-center gap-2" role="tablist" aria-label="Review pages">
                        <template x-for="index in pages" :key="'dot-' + index">
                            <button
                                type="button"
                                @click="goTo(index)"
                                class="eq-reviews__dot"
                                :class="active === index && 'is-active'"
                                :aria-label="'Show reviews starting at ' + (index + 1)"
                                :aria-current="active === index ? 'true' : 'false'"
                            ></button>
                        </template>
                    </div>

                    <button
                        type="button"
                        @click="next()"
                        class="eq-reviews__nav"
                        aria-label="Next reviews"
                    >
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </template>
    </div>
</section>
