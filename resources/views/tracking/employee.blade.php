<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>Location Sharing</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f0f4f8; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: #fff; border-radius: 20px; padding: 32px 24px; max-width: 360px; width: 100%; box-shadow: 0 8px 32px rgba(0,0,0,.10); text-align: center; }
        .logo { width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg,#0f4c81,#1a6eb5); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .logo svg { width: 32px; height: 32px; stroke: #fff; fill: none; }
        h1 { font-size: 18px; font-weight: 800; color: #111827; margin-bottom: 4px; }
        .sub { font-size: 13px; color: #6b7280; margin-bottom: 28px; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 6px; vertical-align: middle; }
        .status-dot.green { background: #10b981; animation: pulse 2s infinite; }
        .status-dot.grey  { background: #d1d5db; }
        .status-bar { background: #f9fafb; border-radius: 10px; padding: 12px 16px; font-size: 13px; color: #374151; margin-bottom: 24px; min-height: 44px; display: flex; align-items: center; justify-content: center; gap: 4px; }
        .btn { width: 100%; padding: 14px; border-radius: 12px; border: none; font-size: 15px; font-weight: 700; cursor: pointer; transition: all .15s; }
        .btn-start { background: #0f4c81; color: #fff; }
        .btn-start:hover { background: #0d4070; }
        .btn-stop  { background: #fee2e2; color: #ef4444; }
        .btn-stop:hover  { background: #fecaca; }
        .btn:disabled { opacity: .5; cursor: not-allowed; }
        .accuracy { font-size: 11px; color: #9ca3af; margin-top: 14px; }
        .ping-count { font-size: 11px; color: #6b7280; margin-top: 8px; }
        @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <svg viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>

        <h1>{{ $employee->full_name }}</h1>
        <p class="sub">Share your location with the company</p>

        <div class="status-bar" id="status-bar">
            <span class="status-dot grey" id="status-dot"></span>
            <span id="status-text">Location sharing is off</span>
        </div>

        <button class="btn btn-start" id="btn-start" onclick="startSharing()">
            Start Sharing Location
        </button>
        <button class="btn btn-stop" id="btn-stop" onclick="stopSharing()" style="display:none;">
            Stop Sharing
        </button>

        <p class="accuracy" id="accuracy-text"></p>
        <p class="ping-count" id="ping-count"></p>
    </div>

    <script>
    const TOKEN   = '{{ $token }}';
    const PING_URL = '{{ route("location.ping") }}';

    let watchId    = null;
    let pingTimer  = null;
    let lastCoords = null;
    let pingsSent  = 0;

    function updateStatus(active, msg) {
        document.getElementById('status-dot').className = 'status-dot ' + (active ? 'green' : 'grey');
        document.getElementById('status-text').textContent = msg;
    }

    function sendPing(coords) {
        lastCoords = coords;
        fetch(PING_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({
                token:     TOKEN,
                latitude:  coords.latitude,
                longitude: coords.longitude,
                accuracy:  coords.accuracy,
            }),
        })
        .then(r => r.json())
        .then(() => {
            pingsSent++;
            document.getElementById('ping-count').textContent = pingsSent + ' update' + (pingsSent !== 1 ? 's' : '') + ' sent';
        })
        .catch(() => {});
    }

    function startSharing() {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by this browser.');
            return;
        }

        document.getElementById('btn-start').disabled = true;
        updateStatus(false, 'Getting location…');

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                sendPing(pos.coords);
                document.getElementById('accuracy-text').textContent =
                    'Accuracy: ±' + Math.round(pos.coords.accuracy) + ' m';

                // Watch for movement
                watchId = navigator.geolocation.watchPosition(
                    function(p) {
                        document.getElementById('accuracy-text').textContent =
                            'Accuracy: ±' + Math.round(p.coords.accuracy) + ' m';
                        lastCoords = p.coords;
                    },
                    null,
                    { enableHighAccuracy: true, maximumAge: 30000 }
                );

                // Ping every 60 seconds
                pingTimer = setInterval(function() {
                    if (lastCoords) sendPing(lastCoords);
                }, 60000);

                updateStatus(true, 'Sharing location…');
                document.getElementById('btn-start').style.display = 'none';
                document.getElementById('btn-stop').style.display  = 'block';
                document.getElementById('btn-start').disabled = false;
            },
            function(err) {
                document.getElementById('btn-start').disabled = false;
                updateStatus(false, 'Permission denied');
                alert('Please allow location access to share your location.');
            },
            { enableHighAccuracy: true, timeout: 15000 }
        );
    }

    function stopSharing() {
        if (watchId !== null) { navigator.geolocation.clearWatch(watchId); watchId = null; }
        if (pingTimer !== null) { clearInterval(pingTimer); pingTimer = null; }
        lastCoords = null;
        updateStatus(false, 'Location sharing stopped');
        document.getElementById('btn-stop').style.display  = 'none';
        document.getElementById('btn-start').style.display = 'block';
        document.getElementById('accuracy-text').textContent = '';
    }
    </script>
</body>
</html>
