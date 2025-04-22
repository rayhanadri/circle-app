@include('..\body_header')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Projects</h5>
                    </div>
                    <div class="mb-3">
                        @if ($user->role == 'Admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#newProjectModal">
                                <i class="ti ti-plus"></i> New Project
                            </button>
                        @endif


                        <!-- New Artwork Modal -->
                        <div class="modal fade" id="newProjectModal" tabindex="-1"
                            aria-labelledby="newProjectModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="newProjectModalLabel">New Project</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('projects.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fandom" class="form-label">Fandom</label>
                                                <input type="text" class="form-control" id="fandom" name="fandom"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="project_manager" class="form-label">Project Manager</label>
                                                <select class="form-control myselect2" id="project_manager"
                                                    name="project_manager" required>
                                                    <option value="" disabled selected>Select a Project Manager
                                                    </option>
                                                    @foreach ($users as $user_manager)
                                                        <option value="{{ $user_manager->id }}">
                                                            {{ $user_manager->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="file" class="form-label">Upload
                                                    File</label>
                                                <input type="file" class="form-control" id="file" name="file"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
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
                                <th>Project ID</th>
                                <th>Project Name</th>
                                <th>Joined</th>
                                <th>Role</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    @php
                                        $manager_name = $project->getManager() ? $project->getManager()->name : '-';
                                        $manager_id = $project->getManager() ? $project->getManager()->id : '-';
                                    @endphp
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->userJoinedProject($user->id) }}</td>
                                    <td>{{ $project->userProjectRole($user->id) }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td>{{ $project->created_at->format('d-m-Y') }}</td>
                                    <td><b>
                                            <span style="color: {{ $project->status === 'Open' ? 'green' : 'red' }}">
                                                {{ $project->status }}
                                            </span>
                                        </b>
                                    </td>
                                    <td>
                                        <a href="{{ route('projects.detail', ['id' => $project->id]) }}"
                                            class="btn btn-primary btn-sm">View</a>
                                        @if ($manager_id === $user->id)
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $project->id }}">
                                                Edit
                                            </button>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal{{ $project->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $project->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel{{ $project->id }}">
                                                                Edit
                                                                Project</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('projects.update', ['id' => $project->id]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="name{{ $project->id }}"
                                                                        class="form-label">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="name{{ $project->id }}" name="name"
                                                                        value="{{ $project->name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="description{{ $project->id }}"
                                                                        class="form-label">Description</label>
                                                                    <textarea class="form-control" id="description{{ $project->id }}" name="description" rows="3" required>{{ $project->description }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="fandom{{ $project->id }}"
                                                                        class="form-label">Fandom</label>
                                                                    <input type="text" class="form-control"
                                                                        id="fandom{{ $project->id }}" name="fandom"
                                                                        value="{{ $project->fandom }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status{{ $project->id }}"
                                                                        class="form-label">Status</label>
                                                                    <select class="form-control"
                                                                        id="status{{ $project->id }}" name="status"
                                                                        required>
                                                                        <option value="Open"
                                                                            {{ $project->status === 'Open' ? 'selected' : '' }}>
                                                                            Open</option>
                                                                        <option value="Closed"
                                                                            {{ $project->status === 'Closed' ? 'selected' : '' }}>
                                                                            Closed</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="manager{{ $project->id }}"
                                                                        class="form-label">Status</label>
                                                                    <select class="form-control myselect2"
                                                                        id="manager{{ $project->id }}"
                                                                        name="manager" required>
                                                                        <option value="" disabled selected>Select
                                                                            a
                                                                            Project Manager
                                                                        </option>

                                                                        @foreach ($project->users as $user_manager)
                                                                            <option value="{{ $user_manager->id }}"
                                                                                {{ $user_manager->id === $manager_id ? 'selected' : '' }}>
                                                                                {{ $user_manager->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="file{{ $project->id }}"
                                                                        class="form-label">Reupload
                                                                        Picture</label>
                                                                    <input type="file" class="form-control"
                                                                        id="file{{ $project->id }}" name="file">
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
                                        @if ($manager_id === $user->id)
                                            {{-- <a href="{{ route('projects', $project->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a> --}}
                                            <form action="{{ route('projects.close', ['id' => $project->id]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure?')">Close</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.title = "Dashboard";
</script>

@include('..\body_footer')
<link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet"
    integrity="sha384-2vMryTPZxTZDZ3GnMBDVQV8OtmoutdrfJxnDTg0bVam9mZhi7Zr3J1+lkVFRr71f" crossorigin="anonymous">
<script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"
    integrity="sha384-2Ul6oqy3mEjM7dBJzKOck1Qb/mzlO+k/0BQv3D3C7u+Ri9+7OBINGa24AeOv5rgu" crossorigin="anonymous">
</script>
