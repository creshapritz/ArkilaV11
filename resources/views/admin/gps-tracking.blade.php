@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'Sf Pro Display', sans-serif;
            background-color: #f4f4f4;
        }

        .gps-container {
            max-width: 1000px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .gps-header {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .gps-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        #map {
            height: 400px;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }

        .client-card.active {
            background-color: #d6f5d6;
            border: 1px solid #F07324;
        }
    </style>
    <div class="gps-container" style="display: flex; gap: 20px;">
        <div style="width: 35%; max-height: 450px; overflow-y: auto; border-right: 1px solid #ddd; padding-right: 10px;">
            <h2 style="font-size: 18px; margin-bottom: 10px;">Clients</h2>
            @foreach(\App\Models\Booking::with('car', 'client')->latest()->get() as $b)
                <div class="client-card" data-car-id="{{ $b->car->id }}" data-client-id="{{ $b->client->id }}"
                    style="cursor: pointer; padding: 10px; margin-bottom: 10px; background: #f8f8f8; border-radius: 10px;">
                    <strong>{{ $b->client->first_name }} {{ $b->client->last_name }}</strong><br>
                    <small>Car: {{ $b->car->name }} {{ $b->car->platenum }}</small>
                </div>
            @endforeach
        </div>
        <div style="width: 65%;">
            <div class="gps-header">
                <h1>GPS Tracking</h1>
            </div>
            <div id="map"></div>
            <div id="last-updated" style="margin-top: 10px; font-size: 14px; color: #555;">
                Last updated: <span id="updated-time">Not yet updated</span>
                <span id="gps-warning" style="color: red; font-weight: bold; margin-left: 10px;"></span>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let map = null;
            let marker = null;
            let path = [];
            let polyline = null;
            let intervalId = null;
            let lastLatLng = null;

            function initMap(lat, lng) {
                map = L.map('map').setView([lat, lng], 17);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const carIcon = L.icon({
                    iconUrl: '/assets/img/car.png',
                    iconSize: [40, 40],
                    iconAnchor: [15, 15]
                });

                marker = L.marker([lat, lng], { icon: carIcon }).addTo(map)
                    .bindPopup("<b>Client's Location</b>").openPopup();

                lastLatLng = L.latLng(lat, lng);
            }

            function moveMarker(lat, lng) {
                const newLatLng = L.latLng(lat, lng);

                if (!lastLatLng || newLatLng.equals(lastLatLng)) return;

                const steps = 20;
                const delay = 30; 
                let step = 0;
                const deltaLat = (newLatLng.lat - lastLatLng.lat) / steps;
                const deltaLng = (newLatLng.lng - lastLatLng.lng) / steps;

                const animate = setInterval(() => {
                    if (step >= steps) {
                        clearInterval(animate);
                        lastLatLng = newLatLng; 
                        return;
                    }

                    const intermediateLat = lastLatLng.lat + deltaLat * step;
                    const intermediateLng = lastLatLng.lng + deltaLng * step;
                    const intermediateLatLng = L.latLng(intermediateLat, intermediateLng);

                    marker.setLatLng(intermediateLatLng);
                    map.panTo(intermediateLatLng, { animate: true });

                    step++;
                }, delay);

            
                
                path.push(newLatLng);
                if (path.length > 20) {
                    path.shift();
                }

                if (polyline) {
                    polyline.setLatLngs(path);
                } else {
                    polyline = L.polyline(path, { color: 'orange' }).addTo(map);
                }
            }



            function fetchAndUpdateMap(carId, clientId) {
                fetch(`/admin/gps/${carId}/${clientId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.latitude && data.longitude) {
                            const lat = parseFloat(data.latitude);
                            const lng = parseFloat(data.longitude);

                            if (!map) {
                                initMap(lat, lng);
                            } else if (!marker) {
                                initMap(lat, lng);
                            } else {
                                moveMarker(lat, lng);
                            }

                            document.getElementById('updated-time').textContent = new Date().toLocaleTimeString();
                            document.getElementById('gps-warning').textContent = "";
                        } else {
                            document.getElementById('gps-warning').textContent = "No GPS data yet.";
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching GPS:", error);
                        document.getElementById('gps-warning').textContent = "Error fetching location.";
                    });
            }

            function startTracking(carId, clientId) {
                if (intervalId) {
                    clearInterval(intervalId);
                }

                map?.remove(); 
                map = null;
                marker = null;
                path = [];
                polyline = null;
                lastLatLng = null;

                fetchAndUpdateMap(carId, clientId); 
                intervalId = setInterval(() => {
                    fetchAndUpdateMap(carId, clientId);
                }, 3000); 
            }

            const clientCards = document.querySelectorAll('.client-card');
            clientCards.forEach(card => {
                card.addEventListener('click', function () {
                    clientCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    const carId = this.getAttribute('data-car-id');
                    const clientId = this.getAttribute('data-client-id');

                    startTracking(carId, clientId);
                });
            });
        });
    </script>




@endsection