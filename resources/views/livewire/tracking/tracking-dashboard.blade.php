<div style="padding:24px 28px;height:calc(100vh - 64px);display:flex;flex-direction:column;gap:16px;overflow:hidden;">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    {{-- ── Header ───────────────────────────────────────────────── --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-shrink:0;flex-wrap:wrap;gap:10px;">
        <div>
            <h1 style="font-size:20px;font-weight:800;color:#111827;margin:0 0 2px;">Location Tracking</h1>
            <p style="font-size:13px;color:#6b7280;margin:0;">Live positions &amp; 7-day movement history</p>
        </div>

        {{-- Mode tabs --}}
        <div style="display:flex;border-radius:10px;overflow:hidden;border:1px solid #e5e7eb;flex-shrink:0;">
            <button wire:click="$set('mode','live')"
                    style="padding:8px 18px;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:all .15s;
                           {{ $mode==='live' ? 'background:#0f4c81;color:#fff;' : 'background:#fff;color:#6b7280;' }}">
                Live
            </button>
            <button wire:click="$set('mode','history')"
                    style="padding:8px 18px;font-size:13px;font-weight:700;border:none;cursor:pointer;border-left:1px solid #e5e7eb;transition:all .15s;
                           {{ $mode==='history' ? 'background:#0f4c81;color:#fff;' : 'background:#fff;color:#6b7280;' }}">
                History
            </button>
        </div>
    </div>

    {{-- ── Controls ─────────────────────────────────────────────── --}}
    @if($mode === 'history')
        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;flex-wrap:wrap;">
            <select wire:model.live="historyEmpId"
                    style="padding:8px 14px;font-size:13px;background:#fff;border:1.5px solid #e5e7eb;border-radius:10px;color:#111827;outline:none;cursor:pointer;min-width:200px;">
                <option value="">— Select Employee —</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->full_name }}</option>
                @endforeach
            </select>
            <input wire:model.live="historyDate" type="date"
                   max="{{ today()->toDateString() }}"
                   min="{{ today()->subDays(6)->toDateString() }}"
                   style="padding:8px 14px;font-size:13px;background:#fff;border:1.5px solid #e5e7eb;border-radius:10px;color:#111827;outline:none;cursor:pointer;"/>
            @if($historyEmployee)
                <span style="font-size:12px;color:#6b7280;">
                    {{ count($historyData) }} point{{ count($historyData) !== 1 ? 's' : '' }} recorded
                </span>
            @endif
        </div>
    @else
        <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;" wire:poll.30s>
            <div style="display:flex;align-items:center;gap:6px;">
                <span style="width:8px;height:8px;border-radius:50%;background:#10b981;display:inline-block;animation:pulse-dot 2s infinite;"></span>
                <span style="font-size:12px;font-weight:600;color:#6b7280;">Auto-refreshes every 30s</span>
            </div>
            <span style="font-size:12px;color:#9ca3af;">{{ count($liveData) }} active employee{{ count($liveData) !== 1 ? 's' : '' }} (last 60 min)</span>
        </div>
    @endif

    {{-- ── Main: map + sidebar ──────────────────────────────────── --}}
    <div style="flex:1;display:flex;gap:14px;min-height:0;">

        {{-- Map --}}
        <div style="flex:1;border-radius:16px;overflow:hidden;border:1px solid #e5e7eb;position:relative;min-height:0;">
            <div id="tracking-map" style="width:100%;height:100%;"></div>

            @if(($mode==='live' && count($liveData)===0) || ($mode==='history' && count($historyData)===0))
                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(249,250,251,.92);z-index:500;pointer-events:none;">
                    <svg width="40" height="40" fill="none" stroke="#d1d5db" viewBox="0 0 24 24" style="margin-bottom:10px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p style="font-size:13px;font-weight:600;color:#9ca3af;margin:0;">
                        @if($mode==='live')
                            No employees tracked in the last 60 minutes
                        @else
                            No location data for the selected date
                        @endif
                    </p>
                </div>
            @endif
        </div>

        {{-- Sidebar list --}}
        <div style="width:260px;flex-shrink:0;display:flex;flex-direction:column;gap:8px;overflow-y:auto;">

            @if($mode === 'live')
                @if(count($liveData) > 0)
                    @foreach($liveData as $loc)
                        <div onclick="focusEmployee({{ $loc['lat'] }}, {{ $loc['lng'] }}, '{{ addslashes($loc['name']) }}')"
                             style="background:#fff;border:1px solid #f1f5f9;border-radius:12px;padding:12px;cursor:pointer;transition:all .15s;"
                             onmouseover="this.style.borderColor='#0f4c81';this.style.boxShadow='0 2px 8px rgba(15,76,129,.1)';"
                             onmouseout="this.style.borderColor='#f1f5f9';this.style.boxShadow='none';">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#0f4c81,#1a6eb5);display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:800;flex-shrink:0;">
                                    {{ $loc['initials'] }}
                                </div>
                                <div style="min-width:0;">
                                    <p style="font-size:12px;font-weight:700;color:#111827;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $loc['name'] }}</p>
                                    @if($loc['dept'])
                                        <p style="font-size:10px;color:#9ca3af;margin:1px 0 0;">{{ $loc['dept'] }}</p>
                                    @endif
                                    <p style="font-size:10px;color:#10b981;margin:2px 0 0;font-weight:600;">{{ $loc['time'] }}</p>
                                </div>
                                <div style="margin-left:auto;flex-shrink:0;">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#10b981;display:block;"></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="background:#fff;border:1px solid #f1f5f9;border-radius:12px;padding:20px;text-align:center;">
                        <p style="font-size:12px;color:#9ca3af;margin:0;">No employees online</p>
                        <p style="font-size:11px;color:#d1d5db;margin:6px 0 0;">Employees must open their tracking link on their device.</p>
                    </div>
                @endif

            @else
                {{-- History: show tracking links for all employees --}}
                <p style="font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:.06em;margin:0 0 4px;">Tracking Links</p>
                @foreach($employees as $emp)
                    @php $token = \App\Models\Employee::find($emp->id)?->location_token; @endphp
                    @if($token)
                        <div style="background:#fff;border:1px solid #f1f5f9;border-radius:12px;padding:10px 12px;">
                            <p style="font-size:12px;font-weight:700;color:#111827;margin:0 0 4px;">{{ $emp->full_name }}</p>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <input readonly value="{{ url('/track/'.$token) }}"
                                       style="flex:1;font-size:10px;color:#6b7280;background:#f9fafb;border:1px solid #f1f5f9;border-radius:6px;padding:4px 7px;outline:none;min-width:0;"/>
                                <button onclick="navigator.clipboard.writeText('{{ url('/track/'.$token) }}').then(()=>{this.textContent='✓';setTimeout(()=>this.textContent='Copy',2000)})"
                                        style="font-size:10px;font-weight:700;padding:4px 8px;border-radius:6px;border:1px solid #e5e7eb;background:#fff;cursor:pointer;white-space:nowrap;flex-shrink:0;">
                                    Copy
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    {{-- Leaflet JS + map init --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        @keyframes pulse-dot { 0%,100%{opacity:1;} 50%{opacity:.4;} }
        .emp-marker-icon { width:32px;height:32px;border-radius:50%;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.25);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;color:#fff;background:linear-gradient(135deg,#0f4c81,#1a6eb5); }
    </style>

    <script>
    (function() {
        let map = null;
        let markers = [];
        let polyline = null;
        let routeMarkers = [];

        const liveData    = @json($liveData);
        const historyData = @json($historyData);
        const mode        = @json($mode);

        function initMap() {
            if (map) { map.remove(); map = null; }
            const el = document.getElementById('tracking-map');
            if (!el) return;

            map = L.map('tracking-map', { zoomControl: true });
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);
        }

        function makeEmpIcon(initials) {
            return L.divIcon({
                className: '',
                html: `<div class="emp-marker-icon">${initials}</div>`,
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -18],
            });
        }

        function renderLive() {
            initMap();
            markers = [];
            if (!liveData.length) {
                map.setView([30.3753, 69.3451], 5); // Pakistan default
                return;
            }
            const bounds = [];
            liveData.forEach(loc => {
                const icon   = makeEmpIcon(loc.initials);
                const marker = L.marker([loc.lat, loc.lng], { icon })
                    .addTo(map)
                    .bindPopup(`<b>${loc.name}</b><br>${loc.dept ? loc.dept + '<br>' : ''}<span style="color:#10b981;font-size:11px;">${loc.time}</span>`);
                markers.push(marker);
                bounds.push([loc.lat, loc.lng]);
            });
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 15 });
        }

        function renderHistory() {
            initMap();
            if (!historyData.length) {
                map.setView([30.3753, 69.3451], 5);
                return;
            }
            const latlngs = historyData.map(p => [p.lat, p.lng]);

            // Draw route line
            polyline = L.polyline(latlngs, {
                color: '#0f4c81', weight: 3, opacity: .7, dashArray: '6,4'
            }).addTo(map);

            // Start marker (green)
            L.circleMarker(latlngs[0], { radius: 8, color: '#10b981', fillColor: '#10b981', fillOpacity: 1, weight: 2 })
                .addTo(map)
                .bindPopup(`<b>Start</b><br>${historyData[0].time}`);

            // End marker (red)
            if (latlngs.length > 1) {
                const last = latlngs[latlngs.length - 1];
                L.circleMarker(last, { radius: 8, color: '#ef4444', fillColor: '#ef4444', fillOpacity: 1, weight: 2 })
                    .addTo(map)
                    .bindPopup(`<b>Last point</b><br>${historyData[historyData.length - 1].time}`);
            }

            // Intermediate dots
            historyData.slice(1, -1).forEach((p, i) => {
                L.circleMarker([p.lat, p.lng], { radius: 4, color: '#0f4c81', fillColor: '#fff', fillOpacity: 1, weight: 2 })
                    .addTo(map)
                    .bindPopup(p.time);
            });

            map.fitBounds(polyline.getBounds(), { padding: [40, 40] });
        }

        // Focus on an employee pin (called from sidebar click)
        window.focusEmployee = function(lat, lng, name) {
            if (map) map.setView([lat, lng], 16);
        };

        // Init on load
        document.addEventListener('DOMContentLoaded', function() {
            if (mode === 'live') renderLive();
            else renderHistory();
        });

        // Re-init when Livewire updates the DOM
        document.addEventListener('livewire:navigated', function() {
            if (mode === 'live') renderLive();
            else renderHistory();
        });

        // Handle Livewire morphing — re-render map after each update
        Livewire.hook('commit', ({ component, succeed }) => {
            succeed(() => {
                setTimeout(() => {
                    if (mode === 'live') renderLive();
                    else renderHistory();
                }, 100);
            });
        });
    })();
    </script>
</div>
