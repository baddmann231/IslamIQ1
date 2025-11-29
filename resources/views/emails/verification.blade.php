<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Email - IslamIQ</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .verification-code {
            background: #ffffff;
            border: 2px dashed #667eea;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 10px;
            color: #667eea;
            margin: 20px 0;
            border-radius: 8px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎓 IslamIQ</h1>
        <p>Platform Belajar Islam Interaktif</p>
    </div>
    
    <div class="content">
        @if($userName)
        <h2>Halo, {{ $userName }}! 👋</h2>
        @else
        <h2>Halo! 👋</h2>
        @endif
        
        <p>Terima kasih telah mendaftar di <strong>IslamIQ</strong>. Untuk melengkapi proses pendaftaran, silakan verifikasi alamat email Anda dengan kode berikut:</p>
        
        <div class="verification-code">
            {{ $verificationCode }}
        </div>
        
        <p><strong>Petunjuk:</strong></p>
        <ol>
            <li>Salin kode verifikasi di atas</li>
            <li>Kembali ke halaman verifikasi IslamIQ</li>
            <li>Masukkan kode verifikasi</li>
            <li>Klik tombol "Verifikasi Email"</li>
        </ol>
        
        <p><strong>Perhatian:</strong></p>
        <ul>
            <li>Kode verifikasi hanya berlaku selama 1 jam</li>
            <li>Jangan bagikan kode ini kepada siapapun</li>
            <li>Jika Anda tidak merasa mendaftar, abaikan email ini</li>
        </ul>
        
        <p>Salam hangat,<br>
        <strong>Tim IslamIQ</strong></p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} IslamIQ. All rights reserved.</p>
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
    </div>
</body>
</html>