@extends('layout.master')
@section('title', 'Produk')
@section('page-title', 'Data Produk')

@section('content')
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0 font-weight-bold">List Produk</h5>
                    <a href="{{ route('produk.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fas fa-plus me-2"></i> Tambah Produk
                    </a>
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
                                <th>Harga Jual</th>
                                <th>Total Jual</th>
                                <th>Stok</th>
                                <th>Gambar</th>
                                <th class="text-center" width="20%">Tanggal</th>
                                <th class="text-center" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produk as $index => $p)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $p->nama_kategori }}</td>
                                    <td>{{ $p->nama_produk }}</td>
                                    <td>Rp {{ number_format($p->harga_beli, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                                    <td>{{ $p->total_jual }}</td>
                                    <td>{{ $p->stok }}</td>
                                    <td>
                                        @if ($p->gambar)
                                            <img src="{{ asset('images/' . $p->gambar) }}" alt="{{ $p->nama_produk }}"
                                                width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td class="text-center">{{ date('d/m/Y H:i', strtotime($p->created_at)) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('produk.edit', $p->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada produk ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
