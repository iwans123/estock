@extends('layouts.main_adminkit')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-secondary fs-3 fw-bold">List Item</div>

                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="">
                            <a href="{{ route('item.create') }}" class="btn btn-primary">Tambah Item</a>
                            <a href="{{ route('category.index') }}" class="btn btn-info">Kategori</a>
                        </div>
                        <div class="">
                            {!! Form::open(['route' => 'item.index', 'method' => 'GET']) !!}
                            <div class="input-group">
                                {!! Form::text('search', request('search'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Cari...',
                                    'autofocus' => true,
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
                                        <th scope="col">Harga</th>
                                        {{-- <th scope="col">Harga 2</th> --}}
                                        {{-- <th scope="col">Deskripsi</th> --}}
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
                                            <td>
                                                <div>
                                                    <div class="text-primary fw-bold">
                                                        {{ formatRupiah($item->price_first, true) }}</div>
                                                    <div>L - {{ $item->price_code }}</div>
                                                </div>
                                                <span></span>
                                                <span></span>
                                            </td>
                                            <td>
                                                <a href="{{ route('item.generateBarcode', $item->id) }}"
                                                    class="btn btn-success">Print</a>
                                                @include('item_detail')

                                                <a href="{{ route('item.edit', $item->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                {{-- <form action="{{ route('item.destroy', $item->id) }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Anda yakin ingin menghapus item ini?')">Hapus</button>
                                                </form> --}}
                                                <button class="btn btn-danger"
                                                    onclick="deletePost({{ $item->id }})">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletePost(postId) {
            Swal.fire({
                title: 'Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan "Ya, hapus", arahkan ke rute delete
                    window.location = '/item/delete/' + postId;
                }
            });
        }
    </script>
@endsection
