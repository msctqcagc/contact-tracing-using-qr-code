@extends('layouts.app')

@section('css-plugins')
    <script src='{{ asset('template/js/mapbox-gl.js') }}'></script>
    <link href='{{ asset('template/css/mapbox-gl.css') }}' rel='stylesheet' />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="breadcrumb-main">
            <h4 class="text-capitalize breadcrumb-title">Requests</h4>
            <div class="breadcrumb-action justify-content-center flex-wrap">
                <button class="btn btn-icon btn-squared btn-outline-light btn-shadow-white" id="btnRefresh" style="margin-right: 8px" data-toggle="tooltip" data-placement="left" title="Refresh">
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
                Request List
            </div>
            <div class="card-body">
                <table id="tableResidents" class="stripe" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Status</th>
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

<div class="modal-info-delete modal fade show" id="modalReview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Review Resident</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-4 mb-25">
                            <div class="form-group">
                                <label for="fieldFirstName" class=" color-dark fs-14 fw-500 align-center">First Name</label>
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light" id="fieldFirstName" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-25">
                            <div class="form-group">
                                <label for="fieldMiddleName" class=" color-dark fs-14 fw-500 align-center">Middle Name</label>
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light" id="fieldMiddleName" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-25">
                            <div class="form-group">
                                <label for="fieldLastName" class=" color-dark fs-14 fw-500 align-center">Last Name</label>
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light" id="fieldLastName" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-25">
                            <div class="form-group">
                                <label for="fieldGender" class=" color-dark fs-14 fw-500 align-center">Gender</label>
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light" id="fieldGender" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-25">
                            <div class="form-group">
                                <label for="fieldDateOfBirth" class=" color-dark fs-14 fw-500 align-center">Date of Birth</label>
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light" id="fieldDateOfBirth" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 mb-25">
                            <div class="form-group">
                                <label for="fieldContactNumber" class=" color-dark fs-14 fw-500 align-center">Contact Number</label>
                                <input type="text" class="form-control ih-medium ip-gray radius-xs b-light" id="fieldContactNumber" readonly>
                            </div>
                        </div>
                        <div class="col-md-12 mb-25">
                            <div class="form-group">
                                <label for="fieldAddress" class=" color-dark fs-14 fw-500 align-center">Address</label>
                                <textarea style="height: 60px" class="form-control ih-medium ip-gray radius-xs b-light" id="fieldAddress" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="margin-bottom: 0px">
                                <label class=" color-dark fs-14 fw-500 align-center">Documents</label>
                                <a id="fieldPSADocument" href="https://www.visajourney.com/static/images/uploads/monthly_2018_08/large.NSOMarriageCertificate.jpg.dff63d10ab3b91db062b234b13c4eaa8.jpg" target="_blank">PSA</a>
                                <br>
                                <a id="fieldValidIDDocument" href="https://www.visajourney.com/static/images/uploads/monthly_2018_08/large.NSOMarriageCertificate.jpg.dff63d10ab3b91db062b234b13c4eaa8.jpg" target="_blank">Valid ID</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-outlined btn-sm" id="btnDecline">DECLINE</button>
                <button type="button" class="btn btn-success btn-outlined btn-sm" id="btnApprove">APPROVE</button>
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

<div class="modal-info-delete modal fade show" id="modalDecline" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-info" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-info-body d-flex">
                    <div class="modal-info-icon warning">
                        <span data-feather="info"></span>
                    </div>
                    <div class="modal-info-text">
                        <h6>Decline Request</h6>
                        <p>Are you sure you want to decline this request?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-outlined btn-sm" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success btn-outlined btn-sm" id="btnDeclineRequest">Yes</button>
            </div>
        </div>
    </div>
</div>
<!-- ends: .modal-info-Decline -->

<div class="modal-info-delete modal fade show" id="modalApprove" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-info" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-info-body d-flex">
                    <div class="modal-info-icon warning">
                        <span data-feather="info"></span>
                    </div>
                    <div class="modal-info-text">
                        <h6>Approve Request</h6>
                        <p>Are you sure you want to approve this request?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-outlined btn-sm" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-success btn-outlined btn-sm" id="btnApproveRequest">Yes</button>
            </div>
        </div>
    </div>
</div>
<!-- ends: .modal-info-Approve -->

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
                { width: "15%" },
                { width: "15%" },
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

        $(document).on('click', '.btn-review', function() {
            id = $(this).data('resident_id');
            $('#fieldPSADocument').hide();
            $('#fieldValidIDDocument').hide();

            fetchResident(id);
        });

        $(document).on('click', '.btn-delete', function() {
            id = $(this).data('id');
        });

        $('#btnDecline').on('click', function() {
            $('#modalDecline').modal('show');
        });

        $('#btnDeclineRequest').on('click', function() {
            declineRequest(id);
        });

        $('#btnApprove').on('click', function() {
            $('#modalApprove').modal('show');
        });

        $('#btnApproveRequest').on('click', function() {
            approveRequest(id);
        });

        $('#btnDelete').on('click', function() {
            deleteScanner(id);
        });
    });

    function fetchResidents() {
        $("#tableResidents").DataTable().rows().clear().draw();

        axios.get('/api/requests')
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

                let actions = '';

                let status = `
                <div class="d-inline-block">
                    <span class="media-badge color-white bg-danger">Unknown Status</span>
                </div>`;

                if (resident.status === 'FOR_REVIEW') {
                    status = `
                    <div class="d-inline-block">
                        <span class="media-badge color-white bg-warning">For Review</span>
                    </div>`;

                    actions = `
                    <div class="atbd-button-list d-flex flex-wrap" style="float:right">
                        <button class="btn btn-default btn-squared btn-outline-info btn-review" data-resident_id="` + resident.id + `">Review</button>
                    </div>`;
                } else if (resident.status === 'DECLINED') {
                    status = `
                    <div class="d-inline-block">
                        <span class="media-badge color-white bg-danger">Declined</span>
                    </div>`;

                    actions = ``;
                }

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
                    status,
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

    function fetchResident(id) {
        axios.get('/api/residents/' + id)
        .then(function (response) {
            const resident = response.data.resident;

            $('#fieldFirstName').val('');
            if (resident.hasOwnProperty('first_name')) {
                $('#fieldFirstName').val(resident.first_name.toUpperCase());
            }

            $('#fieldMiddleName').val('');
            if (resident.hasOwnProperty('middle_name')) {
                $('#fieldMiddleName').val(resident.middle_name.toUpperCase());
            }

            $('#fieldLastName').val('');
            if (resident.hasOwnProperty('last_name')) {
                $('#fieldLastName').val(resident.last_name.toUpperCase());
            }

            $('#fieldGender').val('');
            if (resident.hasOwnProperty('gender')) {
                if (resident.gender == 1) {
                    $('#fieldGender').val("MALE");
                } else if (resident.gender == 2) {
                    $('#fieldGender').val("FEMALE");
                }
            }

            $('#fieldDateOfBirth').val('');
            if (resident.hasOwnProperty('birthday')) {
                $('#fieldDateOfBirth').val(resident.birthday.toUpperCase());
            }

            $('#fieldContactNumber').val('');
            if (resident.hasOwnProperty('contact_number')) {
                $('#fieldContactNumber').val(resident.contact_number);
            }

            $('#fieldAddress').val('');
            let completeAddress = '';
            if (resident.hasOwnProperty('barangay')) {
                completeAddress = resident.barangay;
            }
            if (resident.hasOwnProperty('address')) {
                if (completeAddress !== '') {
                    completeAddress = completeAddress + '\n' + resident.address;
                } else {
                    completeAddress = resident.address;
                }
            }

            $('#fieldAddress').val(completeAddress.toUpperCase());

            if (resident.hasOwnProperty('documents')) {
                const documents = resident.documents;
                for (i = 0; i < documents.length; i++) {
                    const document = documents[i];
                    if (document.type === "PSA") {
                        $('#fieldPSADocument').attr('href', document.file_path);
                        $('#fieldPSADocument').show();
                    }

                    if (document.type === "VALID_ID") {
                        $('#fieldValidIDDocument').attr('href', document.file_path);
                        $('#fieldValidIDDocument').show();
                    }
                }
            }

            $('#modalReview').modal('show');
        })
        .catch(function (error) {
            console.log(error.response);
        });
    }

    function declineRequest(id) {
        axios.get('/api/residents/' + id + '/requests/decline')
        .then(function (response) {
            fetchResidents();
            $('#modalReview').modal('hide');
            $('#modalDecline').modal('hide');
        })
        .catch(function (error) {
            console.log(error.response);
        });
    }

    function approveRequest(id) {
        axios.get('/api/residents/' + id + '/requests/approve')
        .then(function (response) {
            fetchResidents();
            $('#modalReview').modal('hide');
            $('#modalApprove').modal('hide');
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
