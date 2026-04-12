@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Data Customer </h3>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Customer Terdaftar</h4>
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Alamat Lengkap</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $key => $c)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($c->foto_blob)
                                        <img src="{{ $c->foto_blob }}" alt="Foto {{ $c->nama }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                    @else
                                        <span class="text-muted"><i>Tanpa Foto</i></span>
                                    @endif
                                </td>
                                <td><strong>{{ $c->nama }}</strong></td>
                                <td>{{ $c->alamat }}, {{ $c->kecamatan }}, {{ $c->kota }}, {{ $c->provinsi }} - {{ $c->kodepos }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data customer.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection