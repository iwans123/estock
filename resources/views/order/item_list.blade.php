<div class="card">

    <div class="card-header">Daftar Item</div>

    <div class="card-body">
        <div class="mb-3 d-flex justify-content-between">
            <div class="">
                {!! Form::open(['route' => 'order.index', 'method' => 'GET']) !!}
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
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 1;
                @endphp
                @foreach ($data as $stock)
                    <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{ $stock->item->code }}</td>
                        <td>{{ $stock->item->name }}</td>
                        <td>
                            {!! Form::open(['route' => 'order.index', 'method' => 'GET']) !!}

                            <div class="form-group">
                                {!! Form::text('search_item', $stock->item->code, [
                                    'hidden' => true,
                                ]) !!}
                            </div>
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
