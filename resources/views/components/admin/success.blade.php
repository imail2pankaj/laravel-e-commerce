@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif


