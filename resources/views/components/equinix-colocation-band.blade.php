@props(['homepage', 'statistics'])

@php
    $sectionVideo = asset('Video/d3-sec.mp4');
    $posterUrl = $homepage->infrastructure_image
        ? Storage::url($homepage->infrastructure_image)
        : asset('images/data-centre-facility.jpg');

    $heading = $homepage->infrastructure_heading ?? 'Your business located everywhere your data is.';
    $emphasis = $homepage->infrastructure_heading_emphasis ?? 'everywhere';
    $headingHtml = e($heading);
    if ($emphasis && str_contains($heading, $emphasis)) {
        $headingHtml = str_replace(e($emphasis), '<span class="eq-gradient-text">'.e($emphasis).'</span>', e($heading));
    }

    $description = strip_tags($homepage->infrastructure_description ?? '')
        ?: 'Deploy workloads in carrier-neutral Global facilities with Tier III+ design, direct cloud on-ramps, and 24/7 NOC coverage—so your teams stay connected without compromise.';

    $ctaText = $homepage->infrastructure_cta_text ?? 'Explore D³ colocation';
    $ctaUrl = $homepage->infrastructure_cta_url ?? route('data-centre.index');
    if ($ctaUrl && ! str_starts_with($ctaUrl, 'http') && ! str_starts_with($ctaUrl, '/')) {
        $ctaUrl = '/'.$ctaUrl;
    }

    $stats = $statistics->take(3);
@endphp

<section class="eq-colocation-band" data-eq-reveal aria-labelledby="colocation-band-heading">
    <div class="eq-colocation-band__grid-bg" aria-hidden="true"></div>

    <div class="relative max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div class="eq-colocation-band__media order-2 lg:order-1">
                <video
                    class="eq-colocation-band__video"
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="metadata"
                    poster="{{ $posterUrl }}"
                    aria-label="Data centre infrastructure"
                >
                    <source src="{{ $sectionVideo }}" type="video/mp4">
                </video>
            </div>

            <div class="order-1 lg:order-2">
                <h2 id="colocation-band-heading" class="eq-colocation-band__heading">
                    {!! $headingHtml !!}
                </h2>
                <p class="eq-colocation-band__lead">
                    {{ $description }}
                </p>
                @if($ctaText)
                    <a href="{{ $ctaUrl }}" class="eq-colocation-band__link">
                        {{ $ctaText }}
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </div>

        @if($stats->isNotEmpty())
            <div class="eq-colocation-band__stats">
                @foreach($stats as $stat)
                    <div class="eq-colocation-band__stat">
                        <p class="eq-colocation-band__stat-number" data-stat-counter>{{ $stat->number }}</p>
                        <p class="eq-colocation-band__stat-label">{{ $stat->label }}</p>
                        @if($stat->description)
                            <p class="eq-colocation-band__stat-desc">{{ $stat->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
