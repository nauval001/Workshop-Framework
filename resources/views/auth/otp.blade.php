<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verifikasi OTP - Koleksi Buku</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-center p-5">
                <div class="brand-logo mb-4">
                  <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                </div>
                <h4>Verifikasi OTP</h4>
                <h6 class="font-weight-light mb-4">Masukkan 6 digit kode OTP yang telah dikirimkan ke email Anda.</h6>
                
                @if(session('error'))
                    <div class="alert alert-danger text-start">
                        {{ session('error') }}
                    </div>
                @endif

                <form class="pt-3" method="POST" action="{{ route('otp.verify') }}">
                  @csrf
                  
                  <div class="form-group">
                    <input type="text" name="otp" class="form-control form-control-lg text-center fw-bold" 
                           placeholder="X X X X X X" maxlength="6" style="letter-spacing: 8px; font-size: 24px;" 
                           required autofocus autocomplete="off">
                           
                    @error('otp')
                        <span class="text-danger small mt-2 d-block text-start">{{ $message }}</span>
                    @enderror
                  </div>
                  
                  <div class="mt-4 d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">VERIFIKASI KODE</button>
                  </div>
                  
                  <div class="text-center mt-4 font-weight-light">
                    <a href="{{ route('login') }}" class="text-primary">Kembali ke halaman Login</a>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
  </body>
</html>