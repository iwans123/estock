<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#receiving{{ $stock->id }}">
    Masuk
</button>

<!-- Modal -->
<div class="modal fade" id="receiving{{ $stock->id }}" tabindex="-1" role="dialog" aria-labelledby="receivingLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receivingLabel">Barang masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model($stock, ['route' => ['first-shop.update', $stock->id], 'method' => 'PUT']) !!}
                <div class="form-group mb-2">
                    {!! Form::label('name', 'Barang') !!}
                    {!! Form::text('item_id', $stock->item->name, [
                        'class' => 'form-control',
                        'placeholder' => 'Enter Name',
                        'disabled' => 'disabled',
                    ]) !!}
                </div>
                {{-- <div class="form-group mb-2">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', ['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif'], null, [
                        'class' => 'form-control',
                        'placeholder' => 'Pilih status',
                        'required',
                    ]) !!}
                </div> --}}
                <div class="form-group mb-2">
                    {!! Form::label('quantity', 'quantity') !!}
                    {!! Form::number('stock', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan quantity',
                    ]) !!}
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
