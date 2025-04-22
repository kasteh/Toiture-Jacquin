@extends('layout.app')

@section('meta')
    <title>{{ config('app.startup') }} | Nos Agences</title>
    <meta name="description" content="Découvrez nos agences partenaires à travers la France. Trouvez l'agence la plus proche de chez vous.">
@endsection

@push('style')
<style>
    .map-container {
        height: 70vh;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin: 2rem 0;
    }
    
    #map {
        height: 100%;
        width: 100%;
    }
    
    .agence-info-window {
        padding: 10px;
        min-width: 200px;
    }
    
    .agence-info-window h5 {
        color: #4361ee;
        margin-bottom: 5px;
    }
    
    .page-header {
        background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-radius: 12px;
    }
    
    @media (max-width: 768px) {
        .map-container {
            height: 50vh;
        }
        
        .page-header {
            padding: 2rem 0;
        }
    }
</style>
@endpush

@section('content')                    
<div class="container">
    <!-- En-tête de page -->
    <div class="page-header text-center">
        <h1 class="display-5 fw-bold">Nos Agences</h1>
        <p class="lead mb-0">Trouvez l'agence la plus proche de chez vous</p>
    </div>
    
    <!-- Conteneur de la carte -->
    <div class="row">
        <div class="col-12">
            <div class="map-container bg-white">
                <div id="map"></div>
            </div>
        </div>
    </div>
    
    <!-- Liste des agences -->
    <div class="row mt-4">
        @foreach($agences as $agence)
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $agence->agence_name }}</h5>
                    <p class="card-text text-muted">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        {{ $agence->agence_adress }}
                    </p>
                    <p class="card-text">
                        <i class="fas fa-phone text-primary me-2"></i>
                        {{ $agence->agence_owner_phone }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('script')
<script>
    var defaultLocation = { lat: 48.8833, lng: 2.5333 };
    var map;
    var markers = [];
    var infowindow = new google.maps.InfoWindow();

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 14,
            styles: [
                {
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{"color": "#444444"}]
                },
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [{"color": "#f2f2f2"}]
                },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [{"visibility": "off"}]
                },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [{"saturation": -100}, {"lightness": 45}]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [{"visibility": "simplified"}]
                },
                {
                    "featureType": "water",
                    "elementType": "all",
                    "stylers": [{"color": "#4361ee"}, {"visibility": "on"}]
                }
            ]
        });

        // Marqueur pour Gagny
        addMarker(defaultLocation, "Gagny", "Notre siège social");

        // Agences
        @if(isset($agences) && count($agences) > 0)
        var agences = @json($agences);
        var bounds = new google.maps.LatLngBounds();

        agences.forEach(function(agence) {
            if (agence.lat && agence.lng) {
                var position = new google.maps.LatLng(agence.lat, agence.lng);
                bounds.extend(position);

                addMarker(
                    position,
                    agence.agence_name,
                    `${agence.agence_adress}<br>Téléphone: ${agence.agence_owner_phone}`
                );
            }
        });

        if (agences.length > 0) {
            map.fitBounds(bounds);
        }
        @endif
    }

    function addMarker(position, title, content) {
        var marker = new google.maps.Marker({
            position: position,
            map: map,
            title: title,
            icon: {
                url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
            }
        });

        markers.push(marker);

        marker.addListener('click', function() {
            infowindow.setContent(`
                <div class="agence-info-window">
                    <h5>${title}</h5>
                    <p>${content}</p>
                </div>
            `);
            infowindow.open(map, marker);
        });

        return marker;
    }

    function gm_authFailure() {
        document.getElementById('map').innerHTML = `
            <div class="alert alert-danger text-center p-4">
                <h4>Impossible de charger Google Maps</h4>
                <p>Veuillez vérifier votre connexion internet</p>
            </div>
        `;
    }

    function loadGoogleMaps() {
        var script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBb7-6-UdCsb4aaxZpUywnJMJUpEnDBfT8&callback=initMap`;
        script.async = true;
        script.defer = true;
        script.onerror = gm_authFailure;
        document.body.appendChild(script);
    }

    window.addEventListener('load', loadGoogleMaps);
</script>
@endpush