<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold">Daftar Kuis IslamIQ</h2>

        <div class="row g-4 justify-content-center">
            <!-- Kuis Rukun Islam -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="https://via.placeholder.com/600x300?text=Rukun+Islam" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Rukun Islam</h5>
                        <p class="card-text">15 soal • Durasi 20 menit</p>
                        <button onclick="window.location.href='{{ route('rukun-islam') }}'" class="btn btn-primary w-100">
                            Mulai
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kuis Sejarah Nabi -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="https://via.placeholder.com/600x300?text=Sejarah+Nabi" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Sejarah Nabi</h5>
                        <p class="card-text">15 soal • Durasi 20 menit</p>
                        <button onclick="window.location.href='{{ route('sejarah-nabi') }}'" class="btn btn-primary w-100">
                            Mulai
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kuis Akhlak & Etika -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <img src="https://via.placeholder.com/600x300?text=Akhlak+dan+Etika" class="card-img-top" alt="">
                    <div class="card-body">
                        <h5 class="card-title">Akhlak & Etika</h5>
                        <p class="card-text">15 soal • Durasi 20 menit</p>
                        <button onclick="window.location.href='{{ route('akhlak-etika') }}'" class="btn btn-primary w-100">
                            Mulai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>