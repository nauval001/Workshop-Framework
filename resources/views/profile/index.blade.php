@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Profil Pengguna </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title mb-4">Ubah Foto Profil</h4>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <div class="mb-4">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="img-lg rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="Profile" class="img-lg rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @endif
                    <h5>{{ Auth::user()->name }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                </div>

                <form action="{{ route('profile.updatePhoto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="profile_photo" class="form-control" accept="image/*" required>
                        @error('profile_photo')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-gradient-primary">Upload Foto Baru</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection