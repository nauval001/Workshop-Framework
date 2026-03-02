@extends('layouts.master')

@section('content')
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span> Dashboard
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul>
  </nav>
</div>

<div class="row mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <h4 class="card-title mb-1">Cetak Dokumen PDF</h4>
          <p class="text-muted mb-0">Generate dan unduh dokumen hasil studi kasus ke dalam format PDF.</p>
        </div>
        <div>
          <a href="{{ route('pdf.sertifikat') }}" target="_blank" class="btn btn-gradient-info btn-icon-text me-2">
            <i class="mdi mdi-printer btn-icon-prepend"></i> Sertifikat
          </a>
          <a href="{{ route('pdf.undangan') }}" target="_blank" class="btn btn-gradient-success btn-icon-text">
            <i class="mdi mdi-printer btn-icon-prepend"></i> Undangan
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-danger card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Pendapatan Mingguan <i class="mdi mdi-chart-line mdi-24px float-end"></i>
        </h4>
        <h2 class="mb-5">Rp. 1,000,000,000,000</h2>
        <h6 class="card-text">Naik hingga 60%</h6>
      </div>
    </div>
  </div>
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Pesanan Mingguan <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
        </h4>
        <h2 class="mb-5">100,000</h2>
        <h6 class="card-text">Berkurang hingga 10%</h6>
      </div>
    </div>
  </div>
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3">Visitors Online <i class="mdi mdi-diamond mdi-24px float-end"></i>
        </h4>
        <h2 class="mb-5">1,000,000</h2>
        <h6 class="card-text">Naik hingga 5%</h6>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush