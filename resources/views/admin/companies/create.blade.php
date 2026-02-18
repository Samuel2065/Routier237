@extends('admin.layout')

@section('active_nav', 'companies.create')

@section('title', 'Create Company')
@section('page_title', 'Create Company')
@section('page_subtitle', 'Dynamic form with existing or new director assignment')

@section('page_actions')
    <a href="{{ route('super_admin.companies') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="content-card">
        <form method="POST" action="{{ route('super_admin.companies.store') }}">
            @csrf
            <h5 class="mb-3">Company Information</h5>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Name *</label><input class="form-control" name="name" value="{{ old('name') }}" required></div>
                <div class="col-md-2"><label class="form-label">Acronym</label><input class="form-control" name="acronym" value="{{ old('acronym') }}"></div>
                <div class="col-md-4"><label class="form-label">Taxpayer Number *</label><input class="form-control" name="taxpayer_number" value="{{ old('taxpayer_number') }}" required></div>
                <div class="col-md-6"><label class="form-label">Email *</label><input type="email" class="form-control" name="email" value="{{ old('email') }}" required></div>
                <div class="col-md-6"><label class="form-label">Phone *</label><input class="form-control" name="phone" value="{{ old('phone') }}" required></div>
                <div class="col-12"><label class="form-label">Headquarters Address *</label><textarea class="form-control" name="headquarters_address" rows="2" required>{{ old('headquarters_address') }}</textarea></div>
                <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea></div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3">Director Assignment</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Option *</label>
                    <select id="director_option" name="director_option" class="form-select" required>
                        <option value="existing" {{ old('director_option', 'existing') === 'existing' ? 'selected' : '' }}>Assign Existing Director</option>
                        <option value="new" {{ old('director_option') === 'new' ? 'selected' : '' }}>Create New Director Account</option>
                    </select>
                </div>
            </div>

            <div id="existing_director_block" class="row g-3 mt-1">
                <div class="col-md-8">
                    <label class="form-label">Select Director *</label>
                    <select name="director_id" class="form-select">
                        <option value="">Choose director</option>
                        @foreach($availableDirectors as $director)
                            <option value="{{ $director->id }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                {{ $director->full_name }} - {{ $director->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="new_director_block" class="row g-3 mt-1 d-none">
                <div class="col-md-6"><label class="form-label">Director Name *</label><input class="form-control" name="director_name" value="{{ old('director_name') }}"></div>
                <div class="col-md-6"><label class="form-label">Director Email *</label><input type="email" class="form-control" name="director_email" value="{{ old('director_email') }}"></div>
                <div class="col-md-6"><label class="form-label">Director Phone *</label><input class="form-control" name="director_phone" value="{{ old('director_phone') }}"></div>
                <div class="col-md-6"><label class="form-label">Temporary Password *</label><input type="password" class="form-control" name="director_password"></div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Create Company</button>
                <a href="{{ route('super_admin.companies') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@section('page_js')
    <script>
        (function () {
            var optionInput = document.getElementById('director_option');
            var existingBlock = document.getElementById('existing_director_block');
            var newBlock = document.getElementById('new_director_block');

            function toggleBlocks() {
                var isNew = optionInput.value === 'new';
                newBlock.classList.toggle('d-none', !isNew);
                existingBlock.classList.toggle('d-none', isNew);
            }

            optionInput.addEventListener('change', toggleBlocks);
            toggleBlocks();
        })();
    </script>
@endsection
