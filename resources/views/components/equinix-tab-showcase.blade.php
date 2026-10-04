@php
    $tabs = $benefits->take(4)->values();
    if ($tabs->isEmpty()) {
        $tabs = collect([
            (object) ['title' => 'AI demands distributed infrastructure', 'description' => 'Enterprise AI spans clouds, platforms and data. D³ connects them so workloads run faster, with governance built in.', 'icon' => 'cpu'],
            (object) ['title' => 'AI runs where data lives', 'description' => 'Our facilities unite connectivity and compute in one ecosystem—closer to the data and the performance your SLAs require.', 'icon' => 'database'],
            (object) ['title' => 'Sovereignty is non-negotiable', 'description' => 'Keep data where regulations demand while scaling across partners and markets from a unified platform.', 'icon' => 'shield'],
            (object) ['title' => 'Intelligence can\'t wait', 'description' => 'Global-grade proximity puts critical workloads within milliseconds of the compute they need to scale.', 'icon' => 'zap'],
        ]);
    }
    $image = asset('images/home-insights-panel.png');
@endphp

<section class="py-20 lg:py-28 bg-white" data-eq-reveal x-data="{ active: 0 }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-14 lg:mb-16">
            <h2 class="eq-headline-section text-brand-900 mb-4">
                Enterprise infrastructure is distributed.<br>
                <span class="eq-gradient-text-dark">That is why you need {{ settings('company.short_name') ?? 'D³' }}.</span>
            </h2>
            <p class="text-lg text-brand-600 leading-relaxed">
                The global platform that connects your strategy, your data centres, and your delivery—wherever you operate.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
            <div class="lg:col-span-5 relative overflow-hidden min-h-[280px] lg:min-h-[420px]" data-eq-parallax>
                <img src="{{ $image }}" alt="Data centre infrastructure" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-gradient-to-t from-brand-950/80 via-brand-950/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 lg:p-8">
                    @foreach($tabs as $index => $tab)
                        <div x-show="active === {{ $index }}" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0">
                            <p class="text-white/70 text-xs uppercase tracking-widest mb-2">0{{ $index + 1 }}</p>
                            <p class="text-white text-xl font-semibold leading-snug">{{ $tab->title }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-7 border border-brand-200 divide-y divide-brand-200">
                @foreach($tabs as $index => $tab)
                    <button
                        type="button"
                        class="eq-tab-btn"
                        :aria-selected="active === {{ $index }} ? 'true' : 'false'"
                        @click="active = {{ $index }}"
                    >
                        <span class="text-xs font-semibold uppercase tracking-widest text-brand-teal-600 mb-1 block">Insight {{ $index + 1 }}</span>
                        <span class="text-lg font-semibold text-brand-900 block mb-2">{{ $tab->title }}</span>
                        <span class="text-sm text-brand-600 leading-relaxed block" x-show="active === {{ $index }}" x-cloak>
                            {{ $tab->description }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>
