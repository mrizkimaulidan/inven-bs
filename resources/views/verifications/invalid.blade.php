<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Tidak Valid</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .verification-card { margin-top: 50px; }
        .verification-header-error { background-color: #dc3545; color: white; }
        .verification-header-error i { font-size: 3rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card verification-card shadow">
                    <div class="card-header text-center verification-header-error p-4">
                        <i class="fas fa-times-circle mb-2"></i>
                        <h4 class="mb-0">QR Code Tidak Valid</h4>
                    </div>
                    <div class="card-body p-4 text-center">
                        <p class="lead">Maaf, QR Code yang Anda pindai tidak valid atau rusak.</p>
                        <p class="text-muted">Pastikan Anda memindai QR Code yang benar dan belum diubah.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
