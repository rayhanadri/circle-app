@include('projects.projects_template_top')
<script>
    document.getElementById("linkDesign").classList.add("active");
</script>
<div class="card-body">
    <div class="mb-3 mb-sm-0">
        <h5 class="card-title fw-semibold">Design Submission</h5>
    </div>

    <div class="mb-3">
        @if (($project->userJoinedProject($user->id) == 'Yes' || $user->role == 'Admin') && $project->status == 'Open')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newDesignModal">
                <i class="ti ti-plus"></i> New Design
            </button>
        @endif

        <!-- New Design Modal -->
        <div class="modal fade" id="newDesignModal" tabindex="-1" aria-labelledby="newDesignModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newDesignModalLabel">New Design Submission
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('designs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="project" class="form-label">Project: {{ $project->name }}</label>
                                <input type="hidden" id="project" name="project" value="{{ $project->id }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="related" class="form-label">Related Artwork</label>
                                <select class="js-example-basic-multiple myselect2" name="related[]" multiple="multiple"
                                    style="width: 100%;">
                                    @foreach ($related as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->id }} | {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table id="projectsTable" class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Project</th>
                <th>Creator</th>
                <th>Status</th>
                <th>Artwork</th>
                <th>Created At</th>
                <th>Download</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($submissions as $submission)
                <tr>
                    <td><a href="{{ route('submission.view') }}?id={{ $submission->id }}">{{ $submission->title }}</a>
                    </td>
                    <td>{{ $submission->type }}</td>
                    <td>{{ $submission->project->name }}</td>
                    <td>{{ $submission->user->name }}</td>
                    <td><b>
                            <span
                                style="color:
                        {{ $submission->status == 'Pending' ? 'grey' : ($submission->status == 'Approved' ? 'green' : 'red') }}">
                                {{ $submission->status }}
                            </span>
                        </b>
                    </td>
                    <td>
                        @foreach ($submission->related_submissions as $related)
                            <div>
                                <a
                                    href="{{ route('submission.view') }}?id={{ $related->id }}">{{ $related->title }}</a>
                            </div>
                        @endforeach
                    </td>
                    <td>{{ $submission->created_at->format('d-m-Y H:i:s') }}</td>
                    <td><a href="{{ asset($submission->file) }}" download="{{ $submission->file }}"
                            class="btn btn-info btn-sm">Download</a></td>
                    <td>
                        <a href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#imageModal{{ $submission->id }}">
                            <img src="{{ asset($submission->file) }}" alt="Artwork Image" class="img-thumbnail"
                                style="max-width: 100px; max-height: 100px;">
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="imageModal{{ $submission->id }}" tabindex="-1"
                            aria-labelledby="imageModalLabel{{ $submission->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel{{ $submission->id }}">
                                            Artwork Image
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset($submission->file) }}" alt="Artwork Image"
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if (
                            $submission->user->id == $user->id &&
                                $submission->status == 'Pending' &&
                                !(
                                    $submission->project->userProjectRole($user->id) == 'Manager' ||
                                    $submission->project->userProjectRole($user->id) == 'Art Director'
                                ))
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $submission->id }}">
                                Edit
                            </button>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $submission->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $submission->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $submission->id }}">
                                                Edit
                                                Submission</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('designs.update', ['id' => $submission->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title{{ $submission->id }}"
                                                        class="form-label">Title</label>
                                                    <input type="text" class="form-control"
                                                        id="title{{ $submission->id }}" name="title"
                                                        value="{{ $submission->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description{{ $submission->id }}"
                                                        class="form-label">Description</label>
                                                    <input type="text" class="form-control"
                                                        id="description{{ $submission->id }}" name="description"
                                                        value="{{ $submission->description }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="project{{ $submission->id }}"
                                                        class="form-label">Project</label>
                                                    <select class="form-control myselect2"
                                                        id="project{{ $submission->id }}" name="project" required
                                                        style="width: 100%;">
                                                        @foreach ($submission->user->projects as $project)
                                                            <option value="{{ $project->id }}"
                                                                {{ $project->id == $submission->project_id ? ' selected' : '' }}>
                                                                {{ $project->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file{{ $submission->id }}"
                                                        class="form-label">Reupload
                                                        File</label>
                                                    <input type="file" class="form-control"
                                                        id="file{{ $submission->id }}" name="file">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save
                                                    Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (
                            $submission->project->userProjectRole($user->id) == 'Manager' ||
                                $submission->project->userProjectRole($user->id) == 'Art Director')
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $submission->id }}">
                                Edit
                            </button>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $submission->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $submission->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $submission->id }}">
                                                Edit
                                                Submission</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('designs.update', ['id' => $submission->id]) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="title{{ $submission->id }}"
                                                        class="form-label">Title</label>
                                                    <input type="text" class="form-control"
                                                        id="title{{ $submission->id }}" name="title"
                                                        value="{{ $submission->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description{{ $submission->id }}"
                                                        class="form-label">Description</label>
                                                    <input type="text" class="form-control"
                                                        id="description{{ $submission->id }}" name="description"
                                                        value="{{ $submission->description }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="project{{ $submission->id }}"
                                                        class="form-label">Project</label>
                                                    <select class="form-control myselect2"
                                                        id="project{{ $submission->id }}" name="project" required
                                                        style="width: 100%;">
                                                        @foreach ($submission->user->projects as $project)
                                                            <option value="{{ $project->id }}"
                                                                {{ $project->id == $submission->project_id ? ' selected' : '' }}>
                                                                {{ $project->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status{{ $submission->id }}"
                                                        class="form-label">Status</label>
                                                    <select class="form-select" id="status{{ $submission->id }}"
                                                        name="status" required>
                                                        <option value="Pending"
                                                            {{ $submission->status == 'Pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option value="Approved"
                                                            {{ $submission->status == 'Approved' ? 'selected' : '' }}>
                                                            Approved</option>
                                                        <option value="Rejected"
                                                            {{ $submission->status == 'Rejected' ? 'selected' : '' }}>
                                                            Rejected</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file{{ $submission->id }}"
                                                        class="form-label">Reupload
                                                        File</label>
                                                    <input type="file" class="form-control"
                                                        id="file{{ $submission->id }}" name="file">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save
                                                    Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('submission.approve', ['id' => $submission->id]) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success btn-sm"
                                    onclick="return confirm('Are you sure?')">Approve</button>
                            </form>
                            <form action="{{ route('submission.reject', ['id' => $submission->id]) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Reject</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet"
    integrity="sha384-2vMryTPZxTZDZ3GnMBDVQV8OtmoutdrfJxnDTg0bVam9mZhi7Zr3J1+lkVFRr71f" crossorigin="anonymous">
<script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"
    integrity="sha384-2Ul6oqy3mEjM7dBJzKOck1Qb/mzlO+k/0BQv3D3C7u+Ri9+7OBINGa24AeOv5rgu" crossorigin="anonymous">
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#projectsTable').DataTable({
            searching: true
        });
    });
    $(document).ready(function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $(document).on('shown.bs.modal', function(e) {
            $('.myselect2').select2({
                dropdownParent: $(e.target)
            });
        });
        $('.js-example-basic-single').select2();
    });
</script>
@include('projects.projects_template_btm')
