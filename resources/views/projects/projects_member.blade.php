@include('projects.projects_template_top')
<script>
    document.getElementById("linkMember").classList.add("active");
</script>
<div class="card-body">
    <div class="mb-3 mb-sm-0">
        <h5 class="card-title fw-semibold">Member List</h5>
    </div>

    <div class="mb-3">
        @if (
            ($user->role == 'Admin' ||
                $project->userProjectRole($user->id) == 'Manager' ||
                $project->userProjectRole($user->id) == 'Art Director') &&
                $project->status == 'Open')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMemberModal">
                <i class="ti ti-plus"></i> New Member
            </button>
        @endif

        <!-- New Design Modal -->
        <div class="modal fade" id="newMemberModal" tabindex="-1" aria-labelledby="newMemberModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newMemberModalLabel">New Member
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select class="form-control myselect2" id="user_id" name="user_id" required
                                    style="width: 100%;">
                                    @foreach ($users_not_member as $user_not_member)
                                        <option value="{{ $user_not_member->id }}">
                                            {{ $user_not_member->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="user_role" class="form-label">User Role</label>
                                <select class="form-control" id="user_role" name="user_role" required
                                    style="width: 100%;">
                                    {{-- <option value="Manager">Manager</option> --}}
                                    <option value="Art Director">Art Director</option>
                                    <option value="Illustrator">Illustrator</option>
                                    <option value="Designer">Designer</option>
                                    <option value="Staff">Staff</option>
                                </select>
                                <input type="hidden" id="project_id" name="project_id" value={{ $project->id }}
                                    required>
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
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user_project)
                <tr>
                    <td>{{ $user_project->id }}</td>
                    <td>{{ $user_project->name }}</td>
                    <td>{{ $user_project->email }}</td>
                    {{-- <td>{{ $project->userProjectRole($user->id) }}</td> --}}
                    <td>{{ $user_project->user_role }}</td>
                    <td>
                        @if ($user_project->user_role == 'Manager')
                            <span class="badge bg-primary">Manager</span>
                        @else
                            @if (
                                $user->role == 'Admin' ||
                                    $project->userProjectRole($user->id) == 'Manager' ||
                                    $project->userProjectRole($user->id) == 'Art Director')
                                <form action="{{ route('user.delete', ['id' => $user_project->id_user_project]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Remove</button>
                                </form>
                            @endif
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
