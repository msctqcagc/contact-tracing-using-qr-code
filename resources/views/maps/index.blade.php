@extends('layouts.app')

@section('css-plugins')
    <script src='{{ asset('template/js/mapbox-gl.js') }}'></script>
    <link href='{{ asset('template/css/mapbox-gl.css') }}' rel='stylesheet' />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main">
                <h4 class="text-capitalize breadcrumb-title">Realtime Map & Scanned Residents</h4>
                <div class="breadcrumb-action justify-content-center flex-wrap">
                    <button class="btn btn-icon btn-squared btn-outline-light btn-shadow-white" id="btnRefresh"
                        style="margin-right: 8px" data-toggle="tooltip" data-placement="left" title="Refresh">
                        <span data-feather="refresh-cw" class="nav-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500">
                    Realtime Map
                </div>
                <div class="card-body">
                    <div id='map' style='width: 100%; height: 440px;'></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500">
                    Scanned Residents
                </div>
                <div class="card-body">
                    <table id="tableScannedResidents" class="stripe" style="width:100%">
                        <thead>
                            <tr>
                                <th>Resident</th>
                                <th>Scanner</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Date Scanned</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js-plugins')
    <script src='https://unpkg.com/mapbox@1.0.0-beta9/dist/mapbox-sdk.min.js'></script>
@endsection

@section('custom-js')
    <script>
        $(function() {
            $('#tableScannedResidents').dataTable({
                aaSorting: [],
                columns: [
                    { width: "20%" },
                    { width: "20%" },
                    { width: "20%" },
                    { width: "5%" },
                    { width: "20%" }
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'dt-head-left dt-body-left'
                    },
                    {
                        targets: 1,
                        className: 'dt-head-left dt-body-left'
                    },
                    {
                        targets: 2,
                        className: 'dt-head-center dt-body-center'
                    },
                    {
                        targets: 3,
                        className: 'dt-head-right dt-body-right'
                    },
                    {
                        targets: 4,
                        className: 'dt-head-right dt-body-right'
                    }
                ]
            });

            fetchScannedResidents();
            socket.on("resident_scanned", (arg) => {
                fetchScannedResidents();
            });

            var coordinates = [124.99231498176192, 11.237945151953497];
            mapboxgl.accessToken =
                'pk.eyJ1IjoiamVpY28iLCJhIjoiY2tldXQ0bnhiMDVsNDJ4cDVod2xiZ3EyMSJ9.5SOwboZZBkYxJPnII1DuzQ';
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: coordinates,
                zoom: 11.6
            });

            $('.mapboxgl-ctrl-logo').remove();
            $('.mapboxgl-ctrl-attrib-button').remove();
            $('.mapboxgl-ctrl-attrib-inner').remove();

            var marker = null
            map.on('click', function(e) {
                coordinates = [e.lngLat.lng, e.lngLat.lat];
                let a = coordinates.toString();
                console.log(a);
            });

            const size = 90;

            // This implements `StyleImageInterface`
            // to draw a pulsing dot icon on the map.
            const pulsingDot = {
                width: size,
                height: size,
                data: new Uint8Array(size * size * 4),

                // When the layer is added to the map,
                // get the rendering context for the map canvas.
                onAdd: function() {
                    const canvas = document.createElement('canvas');
                    canvas.width = this.width;
                    canvas.height = this.height;
                    this.context = canvas.getContext('2d');
                },

                // Call once before every frame where the icon will be used.
                render: function() {
                    const duration = 1000;
                    const t = (performance.now() % duration) / duration;

                    const radius = (size / 2) * 0.3;
                    const outerRadius = (size / 2) * 0.7 * t + radius;
                    const context = this.context;

                    // Draw the outer circle.
                    context.clearRect(0, 0, this.width, this.height);
                    context.beginPath();
                    context.arc(
                        this.width / 2,
                        this.height / 2,
                        outerRadius,
                        0,
                        Math.PI * 2
                    );
                    context.fillStyle = `rgba(255, 200, 200, ${1 - t})`;
                    context.fill();

                    // Draw the inner circle.
                    context.beginPath();
                    context.arc(
                        this.width / 2,
                        this.height / 2,
                        radius,
                        0,
                        Math.PI * 2
                    );
                    context.fillStyle = 'rgba(255, 100, 100, 1)';
                    context.strokeStyle = 'white';
                    context.lineWidth = 2 + 4 * (1 - t);
                    context.fill();
                    context.stroke();

                    // Update this image's data with data from the canvas.
                    this.data = context.getImageData(
                        0,
                        0,
                        this.width,
                        this.height
                    ).data;

                    // Continuously repaint the map, resulting
                    // in the smooth animation of the dot.
                    map.triggerRepaint();

                    // Return `true` to let the map know that the image was updated.
                    return true;
                }
            };

            map.on('load', () => {
                map.addImage('pulsing-dot', pulsingDot, {
                    pixelRatio: 2
                });

                map.addSource('dot-point', {
                    'type': 'geojson',
                    'data': {
                        'type': 'FeatureCollection',
                        'features': [{
                            'type': 'Feature',
                            'id': 1,
                            'geometry': {
                                'type': 'Point',
                                'coordinates': coordinates // icon position [lng, lat]
                            }
                        },
                        {
                            'type': 'Feature',
                            'id': 2,
                            'geometry': {
                                'type': 'Point',
                                'coordinates': [124.9807630459755,11.242388428497833] // icon position [lng, lat]
                            }
                        }]
                    }
                });
                map.addLayer({
                    'id': 'layer-with-pulsing-dot',
                    'type': 'symbol',
                    'source': 'dot-point',
                    'layout': {
                        'icon-image': 'pulsing-dot'
                    }
                });
            });

            map.on('mousemove', 'layer-with-pulsing-dot', ({ features }) => {
                map.getCanvas().style.cursor = 'pointer';
                console.log(features[0].id);
            });

            map.on('mouseleave', 'layer-with-pulsing-dot', () => {
                map.getCanvas().style.cursor = '';
            });
        });

        function fetchScannedResidents() {
            $("#tableScannedResidents").DataTable().rows().clear().draw();

            axios.get('/api/scanned-residents')
            .then(function (response) {
                let scanned_residents = response.data.scanned_residents;
                if (scanned_residents.length === 0) {
                    return;
                }

                for(let i = 0; i < scanned_residents.length; i++) {
                    const scanned_resident = scanned_residents[i];
                    console.log(scanned_resident);

                    let residentName = '';
                    if (scanned_resident.hasOwnProperty('resident')) {
                        let resident = scanned_resident.resident;
                        residentName = resident.first_name + ' ' + resident.last_name;
                    }

                    let scannerName = '';
                    let barangay = '';
                    if (scanned_resident.hasOwnProperty('scanner')) {
                        let scanner = scanned_resident.scanner;
                        scannerName = scanner.name;

                        if (scanner.hasOwnProperty('barangay')) {
                            barangay = scanner.barangay.name;
                        }
                    }

                    let status = `
                    <div class="d-inline-block">
                        <span class="media-badge color-white bg-light">Negative</span>
                    </div>`;

                    if (scanned_resident.is_active_case) {
                        status = `
                        <div class="d-inline-block">
                            <span class="media-badge color-white bg-danger">Positive</span>
                        </div>`;
                    }

                    // if (disease.is_active) {
                    //     is_active = `
                    //     <div class="d-inline-block">
                    //         <span class="media-badge color-white bg-success">Yes</span>
                    //     </div>`;
                    // }

                    // const actions = `
                    // <div class="atbd-button-list d-flex flex-wrap" style="float:right">
                    //     <button class="btn btn-icon btn-squared btn-outline-warning btn-update" data-toggle="tooltip" data-placement="left" title="Edit"
                    //         data-id="` + disease.id + `"
                    //         data-name="` + disease.name + `"
                    //         data-description="` + disease.description + `">
                    //         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit nav-icon"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    //     </button>
                    //     <button class="btn btn-icon btn-squared btn-outline-danger btn-delete" data-id="` + disease.id + `" data-toggle="modal" data-target="#modalDelete" data-toggle="tooltip" data-placement="left" title="Delete">
                    //         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash nav-icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    //     </button>
                    // </div>`;

                    // let description = disease.description;
                    // let maxLength = 20;
                    // if (description !== null && description.length >= maxLength) {
                    //     description = description.substring(0, maxLength) + '...'
                    // }

                    // let created_at = disease.created_at;
                    // if (created_at === '0 seconds ago') {
                    //     created_at = 'Just Now';
                    // }

                    let created_at = scanned_resident.created_at;

                    $('#tableScannedResidents').dataTable().fnAddData([
                        residentName,
                        scannerName,
                        barangay,
                        status,
                        created_at
                    ]);
                }
            })
            .catch(function (error) {
                console.log(error.response);
            });
        }

    </script>
@endsection
