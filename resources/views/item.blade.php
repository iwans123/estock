@extends('layouts.main_adminkit')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Daftar Item</div>

                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="">
                            <a href="{{ route('item.create') }}" class="btn btn-primary">Tambah Item</a>
                        </div>
                        <div class="">
                            {!! Form::open(['route' => 'item.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                {!! Form::text('search', request('search'), ['class' => 'form-control', 'placeholder' => 'Cari...']) !!}
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nomor Part</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Harga 1</th>
                                    <th scope="col">Harga 2</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach ($items as $item)
                                    <tr>
                                        <th scope="row">{{ $counter++ }}</th>
                                        <td>{!! DNS1D::getbarcodeHTML("$item->code", 'C39') !!}
                                            p - {{ $item->code }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->part_number }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td class="text-primary fw-bold">{{ formatRupiah($item->price_first, true) }}</td>
                                        <td>{{ formatRupiah($item->price_second, true) }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <a href="{{ route('item.edit', $item->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('item.destroy', $item->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Anda yakin ingin menghapus item ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
