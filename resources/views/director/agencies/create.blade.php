@extends('director.layout')

@section('active_nav', 'agencies.create')
@section('title', 'Create Agency')
@section('page_title', 'Create New Agency')
@section('page_subtitle', 'Complete agency data and assign an agency manager')

@section('page_actions')
<a href="{{ route('director.agencies') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Agencies</a>
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="content-card">
    <form method="POST" action="{{ route('director.agencies.store') }}">
        @csrf
        <h5 class="mb-3">Agency Information</h5>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Agency Name *</label><input type="text" class="form-control" name="name" value="{{ old('name') }}" required></div>
            <div class="col-md-3"><label class="form-label">City *</label><select class="form-select" name="city_id" required><option value="">Select city</option>@foreach(($cities ?? collect()) as $city)<option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }} ({{ $city->region }})</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">District</label><input type="text" class="form-control" name="district" value="{{ old('district') }}"></div>
            <div class="col-md-12"><label class="form-label">Full Address *</label><textarea class="form-control" rows="2" name="full_address" required>{{ old('full_address') }}</textarea></div>
            <div class="col-md-4"><label class="form-label">Phone *</label><input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required></div>
            <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="{{ old('email') }}"></div>
            <div class="col-md-4"><label class="form-label">Agency Type *</label><select name="type" class="form-select" required><option value="">Select type</option><option value="main" {{ old('type') === 'main' ? 'selected' : '' }}>Main</option><option value="secondary" {{ old('type') === 'secondary' ? 'selected' : '' }}>Secondary</option></select></div>
        </div>

        <hr class="my-4">
        <h5 class="mb-3">Agency Manager Assignment</h5>
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Manager Option *</label><select id="manager_option" name="manager_option" class="form-select" required><option value="existing" {{ old('manager_option', 'existing') === 'existing' ? 'selected' : '' }}>Assign Existing Manager</option><option value="new" {{ old('manager_option') === 'new' ? 'selected' : '' }}>Create New Manager Account</option></select></div>
        </div>

        <div id="existing_manager_block" class="row g-3 mt-1"><div class="col-md-8"><label class="form-label">Select Existing Manager *</label><select name="manager_id" class="form-select"><option value="">Choose manager</option>@foreach(($availableManagers ?? collect()) as $manager)<option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>{{ $manager->full_name }} - {{ $manager->email }}</option>@endforeach</select></div></div>

        <div id="new_manager_block" class="row g-3 mt-1 d-none">
            <div class="col-md-6"><label class="form-label">Manager Full Name *</label><input type="text" class="form-control" name="manager_full_name" value="{{ old('manager_full_name') }}"></div>
            <div class="col-md-6"><label class="form-label">Manager Email *</label><input type="email" class="form-control" name="manager_email" value="{{ old('manager_email') }}"></div>
            <div class="col-md-6"><label class="form-label">Manager Phone *</label><input type="text" class="form-control" name="manager_phone" value="{{ old('manager_phone') }}"></div>
            <div class="col-md-6"><label class="form-label">Temporary Password *</label><input type="password" class="form-control" name="manager_password"></div>
        </div>

        <div class="mt-4 d-flex gap-2"><button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Create Agency</button><a href="{{ route('director.agencies') }}" class="btn btn-outline-secondary">Cancel</a></div>
    </form>
</div>
@endsection

@section('page_js')
<script>
(function () {
    var optionInput = document.getElementById('manager_option');
    var existingBlock = document.getElementById('existing_manager_block');
    var newBlock = document.getElementById('new_manager_block');
    function toggleManagerBlocks() {
        var isNew = optionInput.value === 'new';
        newBlock.classList.toggle('d-none', !isNew);
        existingBlock.classList.toggle('d-none', isNew);
    }
    optionInput.addEventListener('change', toggleManagerBlocks);
    toggleManagerBlocks();
})();
</script>
@endsection
