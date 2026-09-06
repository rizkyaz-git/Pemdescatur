@props([
    'latitude' => -7.483312,
    'longitude' => 110.700145,
    'latInputId' => 'latitude',
    'lngInputId' => 'longitude',
    'mapId' => 'picker-map'
])

<div class="space-y-2">
    <div id="{{ $mapId }}" class="w-full h-80 rounded-xl border border-gray-300 shadow-inner z-10"></div>
    <div class="flex items-center justify-between text-[11px] text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
        <span>💡 Klik atau geser (drag) marker pada peta untuk menentukan titik presisi.</span>
        <span class="font-mono text-emerald-800 font-bold" id="{{ $mapId }}-coords-display">
            {{ number_format($latitude, 6) }}, {{ number_format($longitude, 6) }}
        </span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const latInput = document.getElementById('{{ $latInputId }}');
        const lngInput = document.getElementById('{{ $lngInputId }}');
        const coordsDisplay = document.getElementById('{{ $mapId }}-coords-display');

        let currentLat = parseFloat(latInput ? latInput.value : {{ $latitude }}) || {{ $latitude }};
        let currentLng = parseFloat(lngInput ? lngInput.value : {{ $longitude }}) || {{ $longitude }};

        const map = L.map('{{ $mapId }}').setView([currentLat, currentLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        let marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

        function updateCoords(lat, lng, updateInputs = true) {
            const formattedLat = parseFloat(lat).toFixed(8);
            const formattedLng = parseFloat(lng).toFixed(8);

            if (updateInputs && latInput && lngInput) {
                latInput.value = formattedLat;
                lngInput.value = formattedLng;
            }

            if (coordsDisplay) {
                coordsDisplay.textContent = formattedLat + ', ' + formattedLng;
            }
        }

        // Map Click Listener
        map.on('click', function (e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            marker.setLatLng([lat, lng]);
            updateCoords(lat, lng, true);
        });

        // Marker Dragend Listener
        marker.on('dragend', function (e) {
            const latlng = marker.getLatLng();
            updateCoords(latlng.lat, latlng.lng, true);
        });

        // 2-Way Sync: Manual Input Change Listeners
        if (latInput && lngInput) {
            function syncFromInputs() {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    marker.setLatLng([lat, lng]);
                    map.panTo([lat, lng]);
                    updateCoords(lat, lng, false);
                }
            }

            latInput.addEventListener('input', syncFromInputs);
            lngInput.addEventListener('input', syncFromInputs);
        }
    });
</script>
