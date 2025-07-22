<x-layout>
    <x-slot name="title">Checkout</x-slot>

    <div class="container my-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <!-- Detail Penagihan -->
            <div class="col-md-7">
                <h4 class="mb-4">Detail Penagihan</h4>
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap</label>
                        <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Masukkan nama lengkap Anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="anda@contoh.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" name="address" class="form-control" id="address" placeholder="Jl. Contoh 1234" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Kota</label>
                        <input type="text" name="city" class="form-control" id="city" placeholder="Kota" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">Provinsi</label>
                            <input type="text" name="state" class="form-control" id="state" placeholder="Provinsi" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="zip" class="form-label">Kode Pos</label>
                            <input type="text" name="zip" class="form-control" id="zip" placeholder="Kode Pos" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Pembayaran</h5>
                    <div class="mb-3">
                        <label for="cardName" class="form-label">Nama di Kartu</label>
                        <input type="text" name="cardName" class="form-control" id="cardName" placeholder="Nama sesuai kartu" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Nomor Kartu Kredit</label>
                        <input type="text" name="cardNumber" class="form-control" id="cardNumber" placeholder="Nomor kartu" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cardExp" class="form-label">Masa Berlaku</label>
                            <input type="text" name="cardExp" class="form-control" id="cardExp" placeholder="MM/YY" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cardCvv" class="form-label">CVV</label>
                            <input type="text" name="cardCvv" class="form-control" id="cardCvv" placeholder="CVV" required>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-3" type="submit">Pesan Sekarang</button>
                </form>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            @foreach($cart->items as $item)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">{{ $item->itemable->name }}</h6>
                                        <small class="text-muted">{{ $item->itemable->description }}</small>
                                    </div>
                                    <span class="text-muted">Rp{{ number_format($item->itemable->price * $item->qty, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Ongkir</span>
                                <strong>Rp{{ number_format($ongkir, 0, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                            </li>
                        </ul>
                        <div class="alert alert-info mt-3" role="alert">
                            Gratis ongkir untuk pesanan di atas Rp50.000!
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layout>
