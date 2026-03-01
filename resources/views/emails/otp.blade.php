<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Anda</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #b66dff; text-align: center;">Koleksi Buku - Verifikasi Login</h2>
        <p style="font-size: 16px; color: #333;">Halo,</p>
        <p style="font-size: 16px; color: #333;">Berikut adalah kode OTP Anda untuk melanjutkan proses login. Kode ini bersifat rahasia, jangan bagikan kepada siapapun.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 10px; color: #b66dff; background: #f2e7fe; padding: 15px 30px; border-radius: 5px;">
                {{ $otp }}
            </span>
        </div>

        <p style="font-size: 14px; color: #777; text-align: center;">Jika Anda tidak merasa melakukan login, abaikan email ini.</p>
    </div>
</body>
</html>