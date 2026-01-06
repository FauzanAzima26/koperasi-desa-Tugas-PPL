<div class="modal fade animate__animated animate__jackInTheBox" id="animationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="formInput" enctype="multipart/form-data" data-store="{{ route('transaksi.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modalTitle" id="exampleModalLabel5"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="id" id="hidden_id">

                    <div class="row">
                        <div class="col mb-4">
                            <label for="kategori" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="lunas">Lunas</option>
                                <option value="belum_lunas">Belum Lunas</option>
                            </select>
                        </div>
                        <div class="col mb-4">
                            <label for="nameAnimation" class="form-label">Tenor Bulan</label>
                            <input type="number" id="tenor_bulan" name="tenor_bulan" class="form-control" />
                            <p id="formError" class="text-danger d-none mt-2"></p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--/ Animation -->
