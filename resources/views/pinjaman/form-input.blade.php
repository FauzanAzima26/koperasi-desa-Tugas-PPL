<!-- Modal -->
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
                            <label for="nameAnimation" class="form-label">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" class="form-control" />
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col mb-0">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select name="jenis" id="jenis" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="col mb-0">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori" class="form-select" required>
                                <option value="">-- Pilih kategori --</option>
                                <option value="simpanan">Simpanan</option>
                                <option value="pinjaman">Pinjaman</option>
                                <option value="angsuran">Angsuran</option>
                                <option value="operasional">Operasional</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col mb-0">
                            <label for="jumlah" class="form-label">Nominal</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text">Rp</span>
                                <input type="number" id="jumlah" name="jumlah" step="0.01" class="form-control rupiah"
                                    placeholder="Masukan nominal" />
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col mb-0">
                            <label for="dobAnimation" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="5"></textarea>
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
