@extends('layouts.app')

@section('css-plugins')
    <script src='{{ asset('template/js/mapbox-gl.js') }}'></script>
    <link href='{{ asset('template/css/mapbox-gl.css') }}' rel='stylesheet' />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="breadcrumb-main">
            <h4 class="text-capitalize breadcrumb-title">Residents</h4>
            <div class="breadcrumb-action justify-content-center flex-wrap">
                <button class="btn btn-icon btn-squared btn-outline-light btn-shadow-white" id="btnRefresh" style="margin-right: 8px" data-toggle="tooltip" data-placement="left" title="Refresh">
                    <span data-feather="refresh-cw" class="nav-icon"></span>
                </button>
                {{-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAdd"><i class="la la-plus"></i> Add New</a></button> --}}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-header color-dark fw-500">
                Resident List
            </div>
            <div class="card-body">
                <table id="tableResidents" class="stripe" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Number</th>
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

@section('custom-js')
<script>
    $(function() {
        $('#tableResidents').dataTable({
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

        fetchResidents();
        $('#btnRefresh').on('click', function() {
            fetchResidents();
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

    function fetchResidents() {
        $("#tableResidents").DataTable().rows().clear().draw();

        axios.get('/api/residents')
        .then(function (response) {
            let residents = response.data.residents;
            if (residents.length === 0) {
                return;
            }

            for(let i = 0; i < residents.length; i++) {
                const resident = residents[i];

                let firstName = ''
                if (resident.hasOwnProperty('first_name')) {
                    firstName = resident.first_name;
                }

                let lastName = ''
                if (resident.hasOwnProperty('last_name')) {
                    lastName = resident.last_name;
                }

                let contactNumber = 'N/A'
                if (resident.hasOwnProperty('contact_number')) {
                    contactNumber = resident.contact_number;
                }

                let is_active = `
                <div class="d-inline-block">
                    <span class="media-badge color-white bg-warning">No</span>
                </div>`;

                if (resident.is_active) {
                    is_active = `
                    <div class="d-inline-block">
                        <span class="media-badge color-white bg-success">Yes</span>
                    </div>`;
                }

                const actions = `
                <div class="atbd-button-list d-flex flex-wrap" style="float:right">
                    <button class="btn btn-icon btn-squared btn-outline-warning btn-update" data-toggle="tooltip" data-placement="left" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit nav-icon"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>
                    <button class="btn btn-icon btn-squared btn-outline-danger btn-delete" data-user_id="` + resident.id + `" data-toggle="modal" data-target="#modalDelete" data-toggle="tooltip" data-placement="left" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash nav-icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    </button>
                </div>`;

                let created_at = resident.created_at;
                if (created_at === '0 seconds ago') {
                    created_at = 'Just Now';
                }

                let updated_at = resident.updated_at;
                if (updated_at === '0 seconds ago') {
                    updated_at = 'Just Now';
                }

                $('#tableResidents').dataTable().fnAddData([
                    firstName + " " + lastName,
                    contactNumber,
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
                fetchResidents();
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
            fetchResidents();
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
            fetchResidents();
            $('#modalDelete').modal('hide');
        })
        .catch(function (error) {
            console.log(error.response);
        });
    }
</script>
@endsection
