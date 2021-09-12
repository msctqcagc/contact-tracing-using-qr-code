<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'app-name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">

    <!-- inject:css-->

    <link rel="stylesheet" href="{{ asset('template/css/plugin.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/style.css') }}">

    <style>
        .signUP-admin-left__content {
            padding-right: 10px;
        }

        .signUP-admin-left__content h1 {
            font-size: 26px;
        }        
    </style>
    <!-- endinject -->

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/img/favicon.png') }}">
</head>

<body>
    <main class="main-content">
        <div class="signUP-admin">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-5 p-0">
                        <div class="signUP-admin-left signIn-admin-left position-relative">
                            <div class="signUP-admin-left__content">
                                <h1>Monitoring System for Contact Tracing using Qr Code with Auto-Generated Clearance</h1>
                            </div><!-- End: .signUP-admin-left__content  -->
                            <div class="signUP-admin-left__img">
                                <img class="img-fluid svg" src="{{ asset('template/img/svg/signupIllustration.svg') }}" alt="img" />
                            </div><!-- End: .signUP-admin-left__img  -->
                        </div><!-- End: .signUP-admin-left  -->
                    </div><!-- End: .col-xl-4  -->
                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-8">
                        <div class="signUp-admin-right signIn-admin-right  p-md-40 p-10">
                            <div class="row justify-content-center">
                                <div class="col-xl-7 col-lg-8 col-md-12">
                                    <div class="edit-profile mt-md-25 mt-0">
                                        @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                            <div class="alert-big alert alert-danger  alert-dismissible fade show " role="alert">
                                                <div class="alert-content">
                                                    <h6 class="alert-heading">Error</h6>
                                                    <p>{{ $error }}</p>
                                                    <button type="button" class="close text-capitalize" data-dismiss="alert" aria-label="Close">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                    </button>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif

                                        <div class="card border-0">
                                            <div class="card-header border-0  pb-md-15 pb-10 pt-md-20 pt-10 ">
                                                <div class="edit-profile__title">
                                                    <h6>Sign up to <span class="color-primary">Admin</span></h6>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form method="POST" action="{{ route('login') }}">
                                                    @csrf

                                                    <div class="edit-profile__body">
                                                        <div class="form-group mb-20">
                                                            <label for="username">Username</label>
                                                            <input type="text" class="form-control" id="username" name="username" :value="old('email')" placeholder="Username" required autofocus autocomplete="off">
                                                        </div>
                                                        <div class="form-group mb-15">
                                                            <label for="password">password</label>
                                                            <div class="position-relative">
                                                                <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                                                                <div class="fa fa-fw fa-eye-slash text-light fs-16 field-icon toggle-password"></div>
                                                            </div>
                                                        </div>
                                                        <div class="button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                            <button type="submit" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize lh-normal px-50 py-15 signIn-createBtn ">
                                                                sign in
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div><!-- End: .card-body -->
                                        </div><!-- End: .card -->
                                    </div><!-- End: .edit-profile -->
                                </div><!-- End: .col-xl-5 -->
                            </div>
                        </div><!-- End: .signUp-admin-right  -->
                    </div><!-- End: .col-xl-8  -->
                </div>
            </div>
        </div><!-- End: .signUP-admin  -->
    </main>
    <div id="overlayer">
        <span class="loader-overlay">
            <div class="atbd-spin-dots spin-lg">
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
            </div>
        </span>
    </div>
    
    <!-- inject:js-->
    <script src="{{ asset('template/js/plugins.min.js') }}"></script>
    <script src="{{ asset('template/js/script.min.js') }}"></script>
    <script>
        $(function() {
            $('.toggle-password').on('click', function() {
                $('#password').attr('type', 'password');
                if ($(this).hasClass('fa-eye')) {
                    $('#password').attr('type', 'text');
                }
            });
        });
    </script>
    <!-- endinject-->
</body>

</html>