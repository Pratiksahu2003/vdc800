@props([
    'locations' => [],
])

@php
    $markers = collect($locations)->filter(fn ($item) => filled($item['lat'] ?? null) && filled($item['lng'] ?? null))->values();
@endphp

@if($markers->isNotEmpty())
    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    @endpush

    <div class="eq-dc-map-wrap" data-eq-reveal>
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-8">
            <div class="max-w-2xl">
                <p class="text-brand-teal-600 text-xs font-bold tracking-widest uppercase mb-2">Network map</p>
                <h2 class="eq-headline-section text-brand-900 text-2xl sm:text-3xl">Our data centre locations</h2>
                <p class="text-brand-600 mt-3 leading-relaxed">Explore every D³ facility across Northern Europe. Select a pin or location card to view project details.</p>
            </div>
            <p class="text-sm font-semibold text-brand-500 shrink-0">{{ $markers->count() }} active sites</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 lg:gap-8">
            <div class="xl:col-span-8">
                <div
                    id="data-centres-map"
                    class="eq-dc-map"
                    data-markers='@json($markers)'
                    role="region"
                    aria-label="Map of data centre locations"
                ></div>
            </div>
            <ul class="xl:col-span-4 flex flex-col gap-3 max-h-[28rem] xl:max-h-[32rem] overflow-y-auto pr-1" id="data-centres-map-list">
                @foreach($markers as $index => $marker)
                    <li>
                        <button
                            type="button"
                            class="eq-dc-map-list-item w-full text-left group"
                            data-map-focus="{{ $index }}"
                        >
                            <span class="eq-dc-map-list-item__thumb">
                                <img src="{{ $marker['image'] }}" alt="" loading="lazy" class="w-full h-full object-cover">
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-xs font-bold uppercase tracking-widest text-brand-teal-600 mb-1">{{ $marker['location'] ?? 'Europe' }}</span>
                                <span class="block text-sm font-bold text-brand-900 group-hover:text-brand-teal-700 transition truncate">{{ $marker['name'] }}</span>
                            </span>
                            <i data-lucide="chevron-right" class="w-4 h-4 text-brand-400 shrink-0 group-hover:text-brand-teal-600 transition"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const el = document.getElementById('data-centres-map');
                if (!el || typeof L === 'undefined') return;

                let markers = [];
                try {
                    markers = JSON.parse(el.dataset.markers || '[]');
                } catch {
                    return;
                }
                if (!markers.length) return;

                const map = L.map(el, {
                    scrollWheelZoom: false,
                    zoomControl: true,
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                }).addTo(map);

                const dcMarkerHtml = `
                    <span class="eq-map-dc-icon">
                        <span class="eq-map-dc-icon__badge">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="4" y="2" width="16" height="20" rx="1"/>
                                <path d="M8 6h8M8 10h8M8 14h8M8 18h5"/>
                                <path d="M12 2v3M9 5h6"/>
                                <circle cx="17" cy="17" r="2" fill="currentColor" stroke="none"/>
                            </svg>
                        </span>
                        <span class="eq-map-dc-icon__point"></span>
                    </span>`;

                const pinIcon = L.divIcon({
                    className: 'eq-map-pin-wrap',
                    html: dcMarkerHtml,
                    iconSize: [40, 48],
                    iconAnchor: [20, 48],
                    popupAnchor: [0, -44],
                });

                const leafletMarkers = markers.map((item, index) => {
                    const marker = L.marker([item.lat, item.lng], { icon: pinIcon }).addTo(map);
                    const popupHtml = `
                        <div class="eq-map-popup">
                            <p class="eq-map-popup__eyebrow">${item.location ?? ''}</p>
                            <p class="eq-map-popup__title">${item.name}</p>
                            <a href="${item.url}" class="eq-map-popup__link">View project</a>
                        </div>`;
                    marker.bindPopup(popupHtml, { maxWidth: 260, className: 'eq-map-popup-shell' });
                    marker.on('click', () => highlightListItem(index));
                    return marker;
                });

                const bounds = L.latLngBounds(markers.map((m) => [m.lat, m.lng]));
                map.fitBounds(bounds.pad(0.22));

                if (markers.length === 1) {
                    map.setZoom(8);
                }

                el.addEventListener('wheel', (event) => {
                    if (event.ctrlKey || event.metaKey) {
                        map.scrollWheelZoom.enable();
                    } else {
                        map.scrollWheelZoom.disable();
                    }
                }, { passive: true });

                document.querySelectorAll('[data-map-focus]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const index = Number(btn.dataset.mapFocus);
                        const target = leafletMarkers[index];
                        if (!target) return;
                        map.setView(target.getLatLng(), Math.max(map.getZoom(), 7), { animate: true });
                        target.openPopup();
                        highlightListItem(index);
                    });
                });

                function highlightListItem(activeIndex) {
                    document.querySelectorAll('.eq-dc-map-list-item').forEach((node, i) => {
                        node.classList.toggle('eq-dc-map-list-item--active', i === activeIndex);
                    });
                }

                highlightListItem(0);
            });
        </script>
    @endpush
@endif
