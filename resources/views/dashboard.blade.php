@include('body_header')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Dashboard</h5>
                    </div>
                    <p>
                        Hello {{ $user->name }}, welcome to your Circle dashboard.
                        <br />Your current member status is {{ $user->member_status }}.
                        <br />Your current role is {{ $user->role }}.
                    </p>
                    Your latest project list:
                    @if ($user->projects->isNotEmpty())
                        <ul>
                            @foreach ($user->projects as $project)
                                <li>{{ $project->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>You currently have no projects.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-9 fw-semibold">Member Status</h5>
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="d-flex align-items-center mb-3">
                                        @if ($user->member_status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-9 fw-semibold">Projects</h5>
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="d-flex align-items-center mb-3">
                                        {{ $user->projects->count() }}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div
                                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-currency-dollar fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-9 fw-semibold">Submissions</h5>
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="d-flex align-items-center mb-3">
                                        {{ $user->submissions->count() }}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div
                                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-currency-dollar fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.title = "Dashboard";
</script>
@include('body_footer')
