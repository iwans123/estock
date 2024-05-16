<div class="card">
    @include('flash::message')
    <div class="card-header">Order</div>

    <div class="card-body">
        <div class="mb-3 row">
            <div class="col-md-4">
                {!! Form::open(['route' => 'order.index', 'method' => 'GET']) !!}

                <div class="form-group">
                    {!! Form::label('search_item', 'code / part number', ['class' => 'mr-2']) !!}
                    {!! Form::text('search_item', request('search_item'), [
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan code / part number',
                        'autofocus' => true,
                        'onfocus' => 'this.select()',
                    ]) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-8">
                {!! Form::open(['route' => 'order.store', 'class' => 'row']) !!}
                @if (request('search_item') != '')
                    {!! Form::text('id', $stock->id, [
                        'class' => 'form-control',
                        'hidden' => true,
                    ]) !!}
                    <div class="form-group col">
                        {!! Form::label('nama_barang', 'Nama Barang:', ['class' => 'mr-2']) !!}
                        {!! Form::text('nama_barang', $stock->item->name, [
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) !!}
                    </div>
                    <div class="form-group col">
                        {!! Form::label('harga', 'Harga:', ['class' => 'mr-2']) !!}
                        {!! Form::text('harga', formatRupiah($stock->item->price_first, true), [
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) !!}
                    </div>
                @elseif(request('search_item') == '')
                    <div class="form-group col">
                        {!! Form::label('nama_barang', 'Nama Barang:', ['class' => 'mr-2']) !!}
                        {!! Form::text('nama_barang', null, [
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) !!}
                    </div>
                    <div class="form-group col">
                        {!! Form::label('harga', 'Harga:', ['class' => 'mr-2']) !!}
                        {!! Form::text('harga', null, [
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) !!}
                    </div>
                @endif
                <div class="form-group col">
                    {!! Form::label('quantity', 'qty:', ['class' => 'mr-2']) !!}
                    {!! Form::text('quantity', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan quantity',
                        'required' => 'required',
                    ]) !!}
                </div>
                {!! Form::submit('Submit', ['class' => 'btn btn-success col-md-2']) !!}
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
<div class="card">
    <div class="card-header">
        Daftar Order
    </div>
    <div class="card-body">
        <div class="mb-3 d-flex">
            {!! Form::open(['route' => 'order.index', 'method' => 'GET']) !!}
            <div class="input-group">
                {!! Form::text('search_order', request('search_order'), ['class' => 'form-control', 'placeholder' => 'Cari...']) !!}
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nomor Part</th>
                    <th scope="col">Harga</th>
                    <th scope="col">QTY</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $order->stock->item->code }}</td>
                        <td>{{ $order->stock->item->name }}</td>
                        <td>{{ $order->stock->item->part_number }}</td>
                        <td>{{ formatRupiah($order->stock->item->price_first, true) }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ formatRupiah($order->total_price, true) }}</td>
                        <td>
                            <form action="{{ route('order.destroy', $order->id) }}" method="POST"
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
</div>
