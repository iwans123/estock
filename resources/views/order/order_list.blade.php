<div class="card">
    @include('flash::message')
    <div class="card-header text-secondary fs-3 fw-bold">Order</div>

    <div class="card-body">
        <div class="mb-3 row">
            <div class="col-md-3">
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
            <div class="col-md-9">
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
                        {!! Form::label('stock', 'Stock Barang:', ['class' => 'mr-2']) !!}
                        {!! Form::text('stock', $stock->stock, [
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
                        {!! Form::label('stock', 'Stock Barang:', ['class' => 'mr-2']) !!}
                        {!! Form::text('stock', null, [
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) !!}
                    </div>
                    <div class="form-group col">
                        {!! Form::label('harga', 'Harga Barang:', ['class' => 'mr-2']) !!}
                        {!! Form::text('harga', null, [
                            'class' => 'form-control',
                            'disabled' => true,
                        ]) !!}
                    </div>
                @endif
                <div class="form-group col">
                    {!! Form::label('quantity', 'Quantity Barang:', ['class' => 'mr-2']) !!}
                    {!! Form::text('quantity', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan quantity',
                        'required' => 'required',
                    ]) !!}
                </div>
                {!! Form::submit('Submit', ['class' => 'btn btn-success col-md-2 m-2']) !!}
                {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>
<div class="card">
    <div class="card-header ">
        <div class="text-secondary fs-3 fw-bold">
            List Order
        </div>
        <div class="text-muted">
            {{ \Carbon\Carbon::now()->format('jS F Y') }}
        </div>
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
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Nama Barang</th>
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
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('H:i:s') }}</td>
                            <td>{{ $order->stock->item->name }}</td>
                            <td>{{ formatRupiah($order->stock->item->price_first, true) }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ formatRupiah($order->total_price, true) }}</td>
                            <td>
                                {{-- <form action="{{ route('order.destroy', $order->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Anda yakin ingin menghapus item ini?')">Hapus</button>
                                </form> --}}
                                <button class="btn btn-danger" onclick="deletePost({{ $order->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            {{ $orders->links() }}
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
                    window.location = '/order/delete/' + postId;
                }
            });
        }
    </script>
</div>
