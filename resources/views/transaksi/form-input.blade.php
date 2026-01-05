<!-- Modal -->
<div class="modal fade animate__animated animate__jackInTheBox" id="animationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form id="formInput" enctype="multipart/form-data" data-store="{{ route('anggota.store') }}">
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
                            <label for="nameAnimation" class="form-label">NIK</label>
                            <input type="text" id="nik" name="nik" class="form-control"
                                placeholder="Masukan NIK" />
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col mb-0">
                            <label for="emailAnimation" class="form-label">Nama</label>
                            <input type="text" id="nama" name="nama" class="form-control"
                                placeholder="Masukan nama" />
                        </div>
                        <div class="col mb-0">
                            <label for="dobAnimation" class="form-label">Usia</label>
                            <input type="number" id="usia" name="usia" class="form-control"
                                placeholder="Masukan usia" />
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col mb-0">
                            <label class="d-block form-label">Jenis Kelamin</label>
                            <div class="form-check mb-2">
                                <input type="radio" name="jenis_kelamin" id="jk_l" class="form-check-input"
                                    value="L" checked />
                                <label class="form-check-label" for="basic-default-radio-male">Laki-Laki</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="jenis_kelamin" id="jk_p" class="form-check-input"
                                    value="P" />
                                <label class="form-check-label" for="basic-default-radio-female">Perempuan</label>
                            </div>
                        </div>
                        <div class="col mb-0">
                            <label for="emailAnimation" class="form-label">Pekerjaan</label>
                            <input type="text" id="pekerjaan" name="pekerjaan" class="form-control"
                                placeholder="Masukan pekerjaan" />
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col mb-0">
                            <label for="dobAnimation" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="5"></textarea>
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
