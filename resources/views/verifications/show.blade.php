<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Barang Berhasil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .verification-card { margin-top: 50px; }
        .verification-header { background-color: #28a745; color: white; }
        .verification-header i { font-size: 3rem; }
        .list-group-item span { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card verification-card shadow">
                    <div class="card-header text-center verification-header p-4">
                        <i class="fas fa-check-circle mb-2"></i>
                        <h4 class="mb-0">Verifikasi Barang Berhasil</h4>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-center text-muted">Data barang berikut telah berhasil diverifikasi dan terdaftar dalam sistem.</p>
                        <ul class="list-group list-group-flush mt-4">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Kode Barang:</span>
                                <small>{{ $commodity->item_code }}</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Nama Barang:</span>
                                <small>{{ $commodity->name }}</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Bahan:</span>
                                <small>{{ $commodity->material }}</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Merk:</span>
                                <small>{{ $commodity->brand }}</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Lokasi:</span>
                                <small>{{ $commodity->commodity_location->name ?? '-' }}</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tahun Pembelian:</span>
                                <small>{{ $commodity->year_of_purchase }}</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Asal Perolehan:</span>
                                <small>{{ $commodity->commodity_acquisition->name }}</small>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Kondisi:</span>
                                @if($commodity->condition === 1)
																<td>
																	<span class="badge badge-pill badge-success" title="Baik" style="display: flex;align-items: center;">
																		<i class="fas fa-fw fa-check-circle"></i>
																		Baik
																	</span>
																</td>
																@elseif($commodity->condition === 2)
																<td>
																	<span class="badge badge-pill badge-warning" title="Kurang Baik" style="display: flex;align-items: center;">
																		<i class="fa fa-fw fa-exclamation-circle"></i>
																		Kurang Baik
																	</span>
																</td>
																@else
																<td>
																	<span class="badge badge-pill badge-danger" title="Rusak Berat" style="display: flex;align-items: center;">
																		<i class="fa fa-fw fa-times-circle"></i>
																		Rusak Berat</span>
																</td>
																@endif
                            </li>
														<li class="list-group-item d-flex justify-content-between">
															<span>Harga:</span>
															<small>Rp. {{ number_format($commodity->price) }}</small>
														</li>
														<li class="list-group-item d-flex justify-content-between">
															<span>Keterangan:</span>
															<small>{{ $commodity->note }}</small>
														</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
