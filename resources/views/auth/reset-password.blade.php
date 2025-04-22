<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erudesu Reset Password</title>
    <link rel="shortcut icon" type="image/png" href="{{ url('resources/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ url('resources/css/styles.min.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <h2>Reset Password</h2>

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    {{-- <label>Email:</label> --}}
                                    <input type="hidden" class="form-control" name="email" value="{{ request()->get('email') }}" readonly required><br><br>

                                    <label>New Password:</label>
                                    <input type="password" class="form-control" name="password" required><br><br>

                                    <label>Confirm Password:</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        required><br><br>

                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Reset Password</button>
                                </form>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('resources/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
