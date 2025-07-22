<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Simpul Warna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Simpul Warna</a>
        <div class="ms-auto">
            <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm">Kembali ke Website</a>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <main class="container py-4">
        <h3 class="mb-4">Admin Dashboard</h3>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Produk</h5>
                        <p class="card-text fs-4">{{ $productCount }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-secondary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Kategori</h5>
                        <p class="card-text fs-4">{{ $categoryCount }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Produk Tersinkron</h5>
                        <p class="card-text fs-4">{{ $syncedProducts }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Kategori Tersinkron</h5>
                        <p class="card-text fs-4">{{ $syncedCategories }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
