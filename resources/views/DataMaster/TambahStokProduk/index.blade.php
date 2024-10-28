@extends('layout.master')
@section('title', 'Produk')
@section('page-title', 'Tambah Stok Produk')

@section('content')
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 font-weight-bold">Tambah Stok</h5>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mx-3 mt-3">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th>Nama Kategori</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th>Stok Sebelumnya</th>
                                <th>Stok Saat Ini</th>
                                <th>Tambah Stok</th>
                                <th class="text-center" width="20%">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produk as $index => $p)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $p->nama_kategori }}</td>
                                    <td>{{ $p->nama_produk }}</td>
                                    <td>Rp {{ number_format($p->harga_beli, 0, ',', '.') }}</td>
                                    <td id="stok-sebelumnya-{{ $p->id }}">{{ $p->stok }}</td>
                                    <td id="stok-saat-ini-{{ $p->id }}">{{ $p->stok }}</td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="tambah-stok-{{ $p->id }}"
                                                min="1">
                                            <button class="btn btn-primary" onclick="updateStok({{ $p->id }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ date('d/m/Y H:i', strtotime($p->created_at)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateStok(id) {
            const tambahStok = document.getElementById(`tambah-stok-${id}`).value;

            if (!tambahStok || tambahStok < 1) {
                alert('Masukkan jumlah stok yang valid');
                return;
            }

            fetch(`/produk/update-stok/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tambah_stok: parseInt(tambahStok)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`stok-sebelumnya-${id}`).textContent = data.stok_sebelumnya;
                        document.getElementById(`stok-saat-ini-${id}`).textContent = data.stok_baru;
                        document.getElementById(`tambah-stok-${id}`).value = '';
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses permintaan');
                });
        }
    </script>
@endsection
