<!-- Button detail modal -->
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
    Detail
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row fw-bold">
                <div class="col-md-6 border-end">
                    <table class="table table-borderless">
                        <tr>
                            <td class="m-5">Nama Barang</td>
                            <td>: {{ $item->name }} </td>
                        </tr>
                        <tr>
                            <td>Kode</td>
                            <td>: {{ $item->code }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Part</td>
                            <td>: {{ $item->part_number }}</td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>: {{ $item->category->name }}</td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>: {{ $item->description }}</td>
                        </tr>
                        {{-- <h5>Nama Barang : {{ $item->name }}</h5>
                        <h5>Kode : {{ $item->name }}</h5> --}}
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td>List</td>
                            <td>: {{ $item->price_code }}</td>
                        </tr>
                        <tr>
                            <td>Harga 1</td>
                            <td>: {{ formatRupiah($item->price_first, true) }}</td>
                        </tr>
                        <tr>
                            <td>Harga 2</td>
                            <td>: {{ formatRupiah($item->price_second, true) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save
                    changes</button>
            </div> --}}
        </div>
    </div>
</div>
