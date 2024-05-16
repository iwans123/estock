<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#transfer{{ $stock->id }}">
    Transfer
</button>

<!-- Modal -->
<div class="modal fade" id="transfer{{ $stock->id }}" tabindex="-1" role="dialog" aria-labelledby="transferLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transferLabel">Transfer Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model($stock, ['route' => ['second-shop.update', $stock->id], 'method' => 'PUT']) !!}
                <div class="form-group mb-2">
                    {!! Form::label('name', 'Barang') !!}
                    {!! Form::text('item_id', $stock->item->name, [
                        'class' => 'form-control',
                        'placeholder' => 'Enter Name',
                        'disabled' => 'disabled',
                    ]) !!}
                </div>
                <div class="form-group mb-2">
                    {!! Form::label('position', 'Tujuan Transfer') !!}
                    {!! Form::select('position', ['TOKO_1' => 'TOKO_1', 'TOKO_2' => 'TOKO_2'], null, [
                        'class' => 'form-control',
                        'placeholder' => 'Pilih Tujuan',
                        'required',
                    ]) !!}
                </div>
                <div class="form-group mb-2">
                    {!! Form::label('quantity', 'quantity') !!}
                    {!! Form::number('quantity', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan quantity',
                        'required',
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
