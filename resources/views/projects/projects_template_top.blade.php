@include('...\body_header')
<script>
    document.getElementById("sidebarProjects").classList.add("active");
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="mb-3 mb-sm-0">
                        <h3 class="card-title fw-semibold">Project: {{ $project->name }}</h3>
                        <nav>
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" id="linkDetail"
                                        href="{{ route('projects.detail') }}?id={{ $project->id }}">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="linkArtwork"
                                        href="{{ route('projects.artwork') }}?id={{ $project->id }}">Artworks</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"  id="linkDesign"
                                        href="{{ route('projects.design') }}?id={{ $project->id }}">Design</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"  id="linkMember"
                                        href="{{ route('projects.member') }}?id={{ $project->id }}">Member</a>
                                </li>
                            </ul>
                        </nav>
