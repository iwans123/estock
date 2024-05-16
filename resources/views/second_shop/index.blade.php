@extends('layouts.main_adminkit')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @include('flash::message')
                <div class="card-header">Daftar Item</div>
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="">
                            {!! Form::open(['route' => 'second-shop.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                {!! Form::text('search', request('search'), ['class' => 'form-control', 'placeholder' => 'Cari...']) !!}
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nomor Part</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Status</th>
                                <th scope="col">Harga Pertama</th>
                                <th scope="col">Harga Kedua</th>
                                <th scope="col">Deskripsi</th>
                                @hasrole('admin|toko-2')
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
                                    @hasrole('admin|toko-2')
                                        <td>
                                            @include('second_shop.receiving_modal')
                                            @include('second_shop.transfer_modal')
                                        </td>
                                    @endhasrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $stocks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
