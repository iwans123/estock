@extends('layouts.main_adminkit')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-secondary fs-3 fw-bold">List Stok Toko 1</div>

                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        @hasrole('admin|toko-1')
                            <div class="">
                                <a href="{{ route('item.create') }}" class="btn btn-primary">Tambah Item</a>
                            </div>
                        @endhasrole
                        <div class="">
                            {!! Form::open(['route' => 'first-shop.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                {!! Form::text('search', request('search'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Cari...',
                                    'autofocus',
                                    'onfocus' => 'this.select()',
                                ]) !!}
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Nomor Part</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Harga 1</th>
                                        <th scope="col">Harga 2</th>
                                        <th scope="col">Deskripsi</th>
                                        @hasrole('admin|toko-1')
                                            <th scope="col">Aksi</th>
                                        @endhasrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach ($stocks as $stock)
                                        <tr>
                                            <th scope="row">{{ $counter++ }}</th>
                                            <td>{{ $stock->item->code }}</td>
                                            <td>{{ $stock->item->name }}</td>
                                            <td>{{ $stock->item->part_number }}</td>
                                            <td>{{ $stock->item->category->name }}</td>
                                            <td>{{ $stock->stock }}</td>
                                            <td><span
                                                    class="badge {{ $stock->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">{{ $stock->status }}</span>
                                            </td>
                                            <td class="text-primary fw-bold">{{ formatRupiah($stock->item->price_first, true) }}
                                            </td>
                                            <td>{{ formatRupiah($stock->item->price_second, true) }}</td>
                                            <td>{{ $stock->item->description }}</td>
                                            <td>
                                                @hasrole('admin|toko-1')
                                                    @include('first_shop.receiving_modal')
                                                    @include('first_shop.transfer_modal')
                                                @endhasrole
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- <div>
                        {{ $stocks->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
