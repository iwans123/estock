@extends('layouts.main_adminkit')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-secondary fs-3 fw-bold">List Kategori</div>

                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="">
                            @include('category.create_modal')
                            {{-- <a href="{{ route('item.create') }}" class="btn btn-primary">Tambah Kategori</a> --}}
                        </div>
                        {{-- <div class="">
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
                        </div> --}}
                    </div>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Kode Kategori</th>
                                        {{-- <th scope="col">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach ($categories as $category)
                                        <tr>
                                            <th scope="row">{{ $counter++ }}</th>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->code_category }}</td>
                                            <td>
                                                {{-- <a href="{{ route('item.edit', $item->id) }}"
                                                    class="btn btn-primary">Edit</a> --}}
                                                {{-- @include('category.edit_modal') --}}
                                                {{-- <button class="btn btn-danger"
                                                    onclick="deletePost({{ $category->id }})">Hapus</button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- <div>
                        {{ $items->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletePost(categoryId) {
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
                    window.location = '/category/delete/' + categoryId;
                }
            });
        }
    </script>
@endsection
