<section class="py-20 lg:py-28 bg-white overflow-hidden" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-14">
            <div>
                <h2 class="eq-headline-section text-brand-900 mb-5">The ecosystem that connects everything.</h2>
                <p class="text-lg text-brand-600 leading-relaxed max-w-xl">
                    Tap into advisory, engineering, and delivery partners across data centre strategy, design, and execution—all connected through {{ settings('company.company_name') ?? 'D³ DataCenters' }}.
                </p>
            </div>
            <div class="relative aspect-square max-w-xl lg:max-w-none lg:ml-auto overflow-hidden rounded-2xl shadow-xl shadow-brand-900/10 ring-1 ring-brand-200/80 eq-case-study" data-eq-parallax>
                <img
                    src="{{ asset('images/home-ecosystem.jpg') }}"
                    alt="D³ DataCenters facilities — campus, power, cooling, and colocation halls"
                    class="absolute inset-0 w-full h-full object-cover"
                    loading="lazy"
                    decoding="async"
                >
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-eq-hscroll-parent>
            @forelse($services->take(3) as $service)
                <a href="{{ route('services.show', $service) }}" class="eq-tile-link eq-tile-link--lift group">
                    <h3>{{ $service->title }}</h3>
                    <p>{{ Str::limit($service->short_description, 140) }}</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-brand-teal-700">
                        Explore <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </a>
            @empty
                @foreach(['Strategy', 'Engineering', 'Delivery'] as $label)
                    <div class="eq-tile-link">
                        <h3>{{ $label }}</h3>
                        <p>End-to-end infrastructure advisory from feasibility through operations.</p>
                    </div>
                @endforeach
            @endforelse
        </div>

        <div class="mt-10 flex flex-wrap gap-4">
            <a href="{{ route('data-centre.index') }}" class="eq-btn-outline">Explore projects</a>
            <a href="{{ route('contact.index') }}" class="eq-btn-primary">Explore the marketplace</a>
        </div>
    </div>
</section>
