<!DOCTYPE html>
<html>
<head>
    <title>Live GPS Monitoring</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Leaflet CDN --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 100vh;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Live GPS Tracking</h2>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([14.5995, 120.9842], 10); // Center on Metro Manila

        // Add OpenStreetMap tile
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let markers = {}; // Store markers by car/client ID

        // Fetch GPS data from backend every 10 seconds
        setInterval(() => {
            fetch('/admin/gps-data') // <- this will be our API route
                .then(res => res.json())
            .then(data => {
                    data.forEach(entry => {
                        const key = `${entry.car_id}-${entry.client_id}`;
                        const latLng = [parseFloat(entry.latitude), parseFloat(entry.longitude)];

                        if (markers[key]) {
                            // If marker exists, update its position
                            markers[key].setLatLng(latLng);
                        } else {
                            // Create a new marker
                            markers[key] = L.marker(latLng)
                                .addTo(map)
                                .bindPopup(`Car ID: ${entry.car_id}<br>Client ID: ${entry.client_id}`);
                        }
                    });
                });
        }, 10000); // every 10 seconds
    </script>
</body>
</html>
