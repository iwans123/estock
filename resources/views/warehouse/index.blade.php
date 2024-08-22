@extends('layouts.main_adminkit')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-secondary fs-3 fw-bold">Gudang</div>

                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="">
                            {!! Form::open(['route' => 'warehouse.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                {!! Form::text('search-stock', request('search-stock'), [
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
                                            @hasrole('admin|toko-1')
                                                <td>
                                                    @include('warehouse.receiving_modal')
                                                    @include('warehouse.transfer_modal')
                                                </td>
                                            @endhasrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        {{ $stocks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
