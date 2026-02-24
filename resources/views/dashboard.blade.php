@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Selamat Datang!</h4>
    <p>Halo, kamu berhasil login sebagai <strong>{{ Auth::user()->email }}</strong>.</p>
    <hr>
    <p class="mb-0">Ini adalah contoh implementasi Layouting menggunakan Laravel Blade.</p>
</div>
@endsection