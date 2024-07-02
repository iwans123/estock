@extends('layouts.main_adminkit')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
            <div class="card">
                <div class="card-header text-secondary fs-3 fw-bold">{{ isset($item) ? 'Edit Item' : 'Tambah Item' }}</div>

                <div class="card-body p-6">
                    @if (isset($item))
                        {!! Form::model($item, ['route' => ['item.update', $item->id], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::open(['route' => 'item.store']) !!}
                    @endif

                    <div class="form-group mb-2">
                        {!! Form::label('code', 'Kode Barang') !!}
                        <span class="text-danger">*</span>
                        {!! Form::text('code', null, [
                            'class' => 'form-control',
                            'required',
                            'autofocus',
                            'placeholder' => 'Masukkan kode barang',
                        ]) !!}
                        <span class="text-danger">{!! $errors->first('code') !!}</span>
                    </div>

                    <div class="form-group mb-2">
                        {!! Form::label('name', 'Nama Barang') !!}
                        <span class="text-danger">*</span>
                        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Masukkan nama barang']) !!}
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                    </div>

                    <div class="form-group mb-2">
                        {!! Form::label('part_number', 'Part Number') !!}
                        {!! Form::text('part_number', null, ['class' => 'form-control', 'placeholder' => 'Masukkan part number']) !!}
                        <span class="text-danger">{!! $errors->first('part_number') !!}</span>
                    </div>

                    <div class="form-group form-inline mb-2">
                        {!! Form::label('category_id', 'Kategori') !!}
                        <span class="text-danger">*</span>
                        <div class="input-group">
                            {!! Form::select('category_id', $categories->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                                'placeholder' => 'Pilih Kategori',
                                'required',
                            ]) !!}
                            <div class="input-group-append">
                                <a href="{{ route('category.index') }}" class="btn btn-info">Tambah Kategori</a>
                            </div>
                        </div>
                        <span>
                        </span>
                        <span class="text-danger">{!! $errors->first('category_id') !!}</span>
                    </div>

                    <div class="form-group mb-2">
                        {!! Form::label('price_code', 'List Harga') !!}
                        {!! Form::text('price_code', null, ['class' => 'form-control', 'placeholder' => 'Masukkan list harga']) !!}
                        <span class="text-danger">{!! $errors->first('price_code') !!}</span>
                    </div>

                    <div class="form-group mb-2">
                        {!! Form::label('price_first', 'Harga Jual') !!}
                        <span class="text-danger">*</span>
                        {!! Form::number('price_first', null, [
                            'class' => 'form-control',
                            'required',
                            'placeholder' => 'Masukkan harga jual',
                        ]) !!}
                        <span class="text-danger">{!! $errors->first('price_first') !!}</span>
                    </div>

                    <div class="form-group mb-2">
                        {!! Form::label('price_second', 'Harga Jual 2') !!}
                        {!! Form::number('price_second', null, ['class' => 'form-control', 'placeholder' => 'Masukkan harga potongan']) !!}
                        <span class="text-danger">{!! $errors->first('price_second') !!}</span>
                    </div>

                    <div class="form-group mb-2">
                        {!! Form::label('description', 'Deskripsi') !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'cols' => 50]) !!}
                        <span class="text-danger">{!! $errors->first('description') !!}</span>
                    </div>

                    {!! Form::submit(isset($item) ? 'Simpan Perubahan' : 'Tambah', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}

                    <div class="mt-3">
                        <span class="text-danger">*</span>
                        <span>wajib diisi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
