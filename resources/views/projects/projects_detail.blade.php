@include('projects.projects_template_top')
<script>
    document.getElementById("linkDetail").classList.add("active");
</script>
{{-- {{ $project }} --}}
<div class="card w-100">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div class="mb-3 mb-sm-3" style="flex: 1; margin-right: 20px;">
                <img src="{{ asset($project->cover_bg) }}" alt="Artwork Image" class="img-thumbnail"
                    style="max-width: 500px; max-height: 500px; cursor: pointer; display: block; margin: 0 auto;"
                    data-bs-toggle="modal" data-bs-target="#imageModal{{ $project->id }}">
                <br />
                <!-- Modal -->
                <div class="modal fade" id="imageModal{{ $project->id }}" tabindex="-1"
                    aria-labelledby="imageModalLabel{{ $project->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel{{ $project->id }}">Artwork Image
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset($project->cover_bg) }}" alt="Artwork Image" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 mb-sm-3" style="flex: 1;">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Project ID</td>
                            <td>{{ $project->id }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ $project->name }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{{ $project->description }}</td>
                        </tr>
                        <tr>
                            <td>Fandom</td>
                            <td>{{ $project->fandom }}</td>
                        </tr>
                        <tr>
                            <td>Manager</td>
                            <td>{{ $project->getManager()->name }}</td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ $project->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td>Updated At</td>
                            <td>{{ $project->updated_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <span style="color: {{ $project->status === 'Open' ? 'green' : 'red' }}">
                                    {{ $project->status }}
                                </span>
                            </td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('projects.projects_template_btm')
