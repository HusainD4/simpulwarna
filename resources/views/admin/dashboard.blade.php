<x-layouts.app :title="'Dashboard'">

@section('content')
    <h3 class="mb-4">Admin Dashboard</h3>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="card-text fs-3 fw-bold">{{ $productCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-secondary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Kategori</h5>
                    <p class="card-text fs-3 fw-bold">{{ $categoryCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Produk Tersinkron</h5>
                    <p class="card-text fs-3 fw-bold">{{ $syncedProducts }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h5 class="card-title">Kategori Tersinkron</h5>
                    <p class="card-text fs-3 fw-bold">{{ $syncedCategories }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>