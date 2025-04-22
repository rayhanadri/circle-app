@include('...\body_header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Submission Detail</h5>
                        <img src="{{ asset($submission->file) }}" alt="Artwork Image" class="img-thumbnail"
                            style="max-width: 500px; max-height: 500px; cursor: pointer; display: block; margin: 0 auto;"
                            data-bs-toggle="modal" data-bs-target="#imageModal{{ $submission->id }}">

                        <!-- Modal -->
                        <div class="modal fade" id="imageModal{{ $submission->id }}" tabindex="-1"
                            aria-labelledby="imageModalLabel{{ $submission->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel{{ $submission->id }}">Artwork Image
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset($submission->file) }}" alt="Artwork Image" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Submission ID</td>
                                    <td>{{ $submission->id }}</td>
                                </tr>
                                <tr>
                                    <td>Submission Type</td>
                                    <td>{{ $submission->type }}</td>
                                </tr>
                                <tr>
                                    <td>Creator</td>
                                    <td>{{ $submission->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Title</td>
                                    <td>{{ $submission->title }}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{{ $submission->description }}</td>
                                </tr>
                                <tr>
                                    <td>Project</td>
                                    <td>{{ $submission->project->name }}</td>
                                </tr>
                                <tr>
                                    <td>Project Fandom</td>
                                    <td>{{ $submission->project->fandom }}</td>
                                </tr>
                                <tr>
                                    <td>Created At</td>
                                    <td>{{ $submission->created_at->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ $submission->status }}</td>
                                </tr>
                                <tr>
                                    <td>Download</td>
                                    <td><a href="{{ asset($submission->file) }}" download="{{ $submission->file }}"
                                            class="btn btn-info btn-sm">Download</a></td>
                                    <td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.title = "Dashboard";
</script>

@include('...\body_footer')
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet"
    integrity="sha384-2vMryTPZxTZDZ3GnMBDVQV8OtmoutdrfJxnDTg0bVam9mZhi7Zr3J1+lkVFRr71f" crossorigin="anonymous">
<script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"
    integrity="sha384-2Ul6oqy3mEjM7dBJzKOck1Qb/mzlO+k/0BQv3D3C7u+Ri9+7OBINGa24AeOv5rgu" crossorigin="anonymous">
</script>
