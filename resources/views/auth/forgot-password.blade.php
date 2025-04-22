<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modernize Free</title>
    <link rel="shortcut icon" type="image/png" href="resources/images/logos/favicon.png" />
    <link rel="stylesheet" href="resources/css/styles.min.css" />
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
                                @if (session('status'))
                                    <p>{{ session('status') }}</p>
                                @endif
                                <a href="{{ url('/') }}"
                                    class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="resources/images/logos/erudesu_logo.png" width="180" alt="">
                                </a>
                                <p class="text-center">Circle Network</p>
                                <form method="POST" action="{{ route('password.email') }}" class="mt-4">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            aria-describedby="emailHelp" value="{{ old('email') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Send
                                        Reset Link</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="resources/libs/jquery/dist/jquery.min.js"></script>
    <script src="resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
