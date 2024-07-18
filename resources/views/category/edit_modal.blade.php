<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#receiving{{ $category->id }}">
    Edit
</button>

<!-- Modal -->
<div class="modal fade" id="receiving{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="receivingLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receivingLabel">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                {!! Form::model($category, ['route' => ['category.update', $category->id], 'method' => 'PUT']) !!}
                <div class="form-group mb-2">
                    {!! Form::label('name', 'Kategori') !!}
                    {!! Form::text('name', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan Kategori',
                    ]) !!}
                </div>
                <div class="form-group mb-2">
                    {!! Form::label('code_category', 'Kategori') !!}
                    {!! Form::text('code_category', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan Kategori',
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
