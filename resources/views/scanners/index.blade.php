@extends('layouts.app')

@section('css-plugins')
    <script src='{{ asset('template/js/mapbox-gl.js') }}'></script>
    <link href='{{ asset('template/css/mapbox-gl.css') }}' rel='stylesheet' />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="breadcrumb-main">
            <h4 class="text-capitalize breadcrumb-title">Scanners</h4>
            <div class="breadcrumb-action justify-content-center flex-wrap">
                <button class="btn btn-icon btn-squared btn-outline-light btn-shadow-white" id="btnRefresh" style="margin-right: 8px" data-toggle="tooltip" data-placement="left" title="Refresh">
                    <span data-feather="refresh-cw" class="nav-icon"></span>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAdd"><i class="la la-plus"></i> Add New</a></button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-header color-dark fw-500">
                Scanner List
            </div>
            <div class="card-body">
                <table id="tableScanners" class="stripe" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Barangay</th>
                            <th>Active</th>
                            <th>Date Created</th>
                            <th>Date Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal-basic modal fade show" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-bg-white ">
            <div class="modal-header">
                <h6 class="modal-title">Add Scanner</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span data-feather="x"></span></button>
            </div>
            <form id="formAdd">
                <div class="modal-body">
                    <div class="horizontal-form">
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                                <label for="fieldUsername" class=" col-form-label color-dark fs-14 fw-500 align-center">Username</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light px-15" id="fieldUsername" name="username" autofocus required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                                <label for="fieldEmail" class=" col-form-label color-dark fs-14 fw-500 align-center">Email</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control ih-medium ip-gray radius-xs b-light px-15" id="fieldEmail" name="email" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                                <label for="fieldPassword" class=" col-form-label color-dark fs-14 fw-500 align-center">Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" class="form-control ih-medium ip-gray radius-xs b-light px-15" id="fieldPassword" name="password" required autocomplete="off">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                                <label for="fieldName" class=" col-form-label color-dark fs-14 fw-500 align-center">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light px-15" id="fieldName" name="name" placeholder="Ex. Robinson's North Tacloban" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                                <label for="fieldBarangay" class=" col-form-label color-dark fs-14 fw-500 align-center">Barangay</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="barangay_id" id="select-search" class="form-control ">
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                            </div>

                            <div class="col-sm-9">
                                <button type="button" class="btn btn-success btn-sm btn-squared btn-block btn-navigate">Navigate</button>
                            </div>
                        </div>
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                                <label for="fieldName" class=" col-form-label color-dark fs-14 fw-500 align-center">Location</label>
                            </div>
                            <div class="col-sm-9">
                                <div id='map' style='width: 400px; height: 300px;'></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ends: .modal-Basic -->

<div class="modal-basic modal fade show" id="modalUpdate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-bg-white ">
            <div class="modal-header">
                <h6 class="modal-title">Edit Scanners</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span data-feather="x"></span></button>
            </div>
            <form id="formUpdate">
                <div class="modal-body">
                    <div class="horizontal-form">
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                                <label for="fieldUpdateName" class=" col-form-label color-dark fs-14 fw-500 align-center">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light px-15" id="fieldUpdateName" name="name" autofocus required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row mb-25">
                            <div class="col-sm-3 d-flex aling-items-center">
                                <label for="fieldUpdateDescription" class=" col-form-label color-dark fs-14 fw-500 align-center">Description</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea class="form-control ih-medium ip-gray radius-xs b-light px-15" id="fieldUpdateDescription" name="description" style="height: 80px"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ends: .modal-Basic -->

<div class="modal-info-delete modal fade show" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-info" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-info-body d-flex">
                    <div class="modal-info-icon warning">
                        <span data-feather="info"></span>
                    </div>
                    <div class="modal-info-text">
                        <h6>Delete scanner</h6>
                        <p>Are you sure you want to delete this scanner?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-outlined btn-sm" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success btn-outlined btn-sm" id="btnDelete">Yes</button>
            </div>
        </div>
    </div>
</div>
<!-- ends: .modal-info-Delete -->

@endsection

@section('js-plugins')
    <script src='https://unpkg.com/mapbox@1.0.0-beta9/dist/mapbox-sdk.min.js'></script>
@endsection

@section('custom-js')
<script>
    $(function() {
        var coordinates = [124.99231498176192, 11.237945151953497];
        mapboxgl.accessToken = 'pk.eyJ1IjoiamVpY28iLCJhIjoiY2tldXQ0bnhiMDVsNDJ4cDVod2xiZ3EyMSJ9.5SOwboZZBkYxJPnII1DuzQ';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: coordinates,
            zoom: 13
        });

        $('.mapboxgl-ctrl-logo').remove();
        $('.mapboxgl-ctrl-attrib-button').remove();

        var marker = null
        map.on('click', function (e) {
            coordinates = [e.lngLat.lng, e.lngLat.lat];
            let a = coordinates.toString();
            console.log(a);

            if (marker !== null) {
                marker.remove();
            }

            marker = new mapboxgl.Marker()
                .setLngLat(coordinates)
                .addTo(map);
        });

        $('.btn-navigate').on('click', function() {
            if (marker !== null) {
                marker.remove();
            }

            let name = $('#fieldName').val();
            let barangay = $('#select2-select-search-container').attr('title');

            let client = new MapboxClient(mapboxgl.accessToken);
            var address = barangay + ' ' + name + ' Tacloban 6500';
            let geocode = client.geocodeForward(address, function (err, data, res) {
                coordinates = data.features[0].center;

                marker = new mapboxgl.Marker()
                    .setLngLat(coordinates)
                    .addTo(map);

                map.flyTo({
                    center: coordinates,
                    essential: true,
                    zoom: 16,
                    bearing: 0,
                    speed: 1,
                    curve: 1
                });
            });
        });

        $('#tableScanners').dataTable({
            aaSorting: [],
            columns: [
                { width: "30%" },
                { width: "20%" },
                { width: "10%" },
                { width: "10%" },
                { width: "10%" },
                { width: "18%" }
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
                    className: 'dt-head-left dt-body-center'
                },
                {
                    targets: 3,
                    className: 'dt-head-center dt-body-center'
                },
                {
                    targets: 4,
                    className: 'dt-head-center dt-body-center'
                },
                {
                    targets: 5,
                    className: 'dt-head-right dt-body-right'
                }
            ]
        });

        $('#fieldContactNumber').on('keydown', function(e) {
            let code = e.originalEvent.code;
            code = code.toLowerCase();
            if (code === 'arrowup' || code === 'arrowdown') {
                e.preventDefault();
            }
        });

        $('#modalAdd').on('shown.bs.modal', function(e) {
            $('#fieldUsername').focus();
        });

        $('#modalAdd').on('hidden.bs.modal', function () {
            $('#formAdd')[0].reset();
        });

        $('#modalUpdate').on('shown.bs.modal', function(e) {
            $('#fieldUpdateName').focus();
        });

        $('#modalUpdate').on('hidden.bs.modal', function () {
            $('#formUpdate')[0].reset();
        });

        var id = null;
        $('#modalDelete').on('hidden.bs.modal', function () {
            id = null;
        });

        fetchScanners();
        $('#btnRefresh').on('click', function() {
            fetchScanners();
        });

        $('#formAdd').submit(function(e) {
            e.preventDefault();

            let data = $(this).serialize();
            data = data + '&coordinates=' + coordinates;
            saveScanner(data);
        });

        $(document).on('click', '.btn-update', function() {
            id = $(this).data('id');

            let name = $(this).data('name');
            $('#fieldUpdateName').val(name);

            let description = $(this).data('description');
            $('#fieldUpdateDescription').val(description);

            $('#modalUpdate').modal('show');
        });

        $('#formUpdate').submit(function(e) {
            e.preventDefault();

            let data = $(this).serialize();
            updateScanners(id, data);
        });

        $(document).on('click', '.btn-delete', function() {
            id = $(this).data('id');
        });

        $('#btnDelete').on('click', function() {
            deleteScanner(id);
        });
    });

    function fetchScanners() {
        $("#tableScanners").DataTable().rows().clear().draw();

        axios.get('/api/scanners')
        .then(function (response) {
            let users = response.data.users;
            if (users.length === 0) {
                return;
            }

            for(let i = 0; i < users.length; i++) {
                const user = users[i];
                const scanner = user.scanner;

                let barangay = 'N/A'
                if (scanner.barangay.hasOwnProperty('name')) {
                    barangay = scanner.barangay.name;
                }

                let is_active = `
                <div class="d-inline-block">
                    <span class="media-badge color-white bg-warning">No</span>
                </div>`;

                if (user.is_active) {
                    is_active = `
                    <div class="d-inline-block">
                        <span class="media-badge color-white bg-success">Yes</span>
                    </div>`;
                }

                const actions = `
                <div class="atbd-button-list d-flex flex-wrap" style="float:right">
                    <button class="btn btn-icon btn-squared btn-outline-warning btn-update" data-toggle="tooltip" data-placement="left" title="Edit"
                        data-user_id="` + user.id + `"
                        data-name="` + scanner.name + `"
                        data-description="` + scanner.description + `">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit nav-icon"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>
                    <button class="btn btn-icon btn-squared btn-outline-danger btn-delete" data-user_id="` + user.id + `" data-toggle="modal" data-target="#modalDelete" data-toggle="tooltip" data-placement="left" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash nav-icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                </div>`;

                let created_at = user.created_at;
                if (created_at === '0 seconds ago') {
                    created_at = 'Just Now';
                }

                let updated_at = user.updated_at;
                if (updated_at === '0 seconds ago') {
                    updated_at = 'Just Now';
                }

                $('#tableScanners').dataTable().fnAddData([
                    scanner.name,
                    barangay,
                    is_active,
                    created_at,
                    updated_at,
                    actions
                ]);
            }
        })
        .catch(function (error) {
            console.log(error.response);
        });
    }

    function saveScanner(data) {
        console.log(data);

        axios.post('/api/scanners', data)
        .then(function (response) {
            let status = response.status;
            if (status === 201) {
                fetchScanners();
                $('#modalAdd').modal('hide');
                $('#formAdd')[0].reset();
            }
        })
        .catch(function (error) {
            console.log(error.response);
        });
    }

    function updateScanners(id, data) {
        axios.put('/api/scanners/' + id, data)
        .then(function (response) {
            fetchScanners();
            $('#modalUpdate').modal('hide');
            $('#formUpdate')[0].reset();
        })
        .catch(function (error) {
            console.log(error.response);
        });
    }

    function deleteScanner(id) {
        axios.delete('/api/scanners/' + id)
        .then(function (response) {
            fetchScanners();
            $('#modalDelete').modal('hide');
        })
        .catch(function (error) {
            console.log(error.response);
        });
    }
</script>
@endsection
