"use strict";

function resetRadio(name) {
    $(`input[name="${name}"]`).prop("checked", false);
}

$(function () {
    var dt_ajax_table = $(".datatables-ajax");
    let storeUrl = $("#formInput").data("store");
    let updateUrl = "/anggota";

    if (dt_ajax_table.length) {
        var dt_ajax = dt_ajax_table.DataTable({
            processing: true,
            serverside: true,
            ajax: $("#anggotaTable").data("url"),
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "nik", name: "nik" },
                {
                    data: "nama",
                    name: "nama",
                },
                {
                    data: "jenis_kelamin",
                    name: "jenis_kelamin",
                    render: (data) =>
                        data === "L" ? "Laki-Laki" : "Perempuan",
                },
                {
                    data: "pekerjaan",
                    name: "pekerjaan",
                },
                {
                    data: "usia",
                    name: "usia",
                },
                {
                    data: "alamat",
                    name: "alamat",
                },
                {
                    data: "aksi",
                    name: "aksi",
                    orderable: false,
                    searchable: false,
                },
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                paginate: {
                    next: '<i class="ti ti-chevron-right ti-sm"></i>',
                    previous: '<i class="ti ti-chevron-left ti-sm"></i>',
                },
            },
        });
    }

    $("#btnAdd").on("click", function () {
        resetRadio("jenis_kelamin");
        $("#formInput")[0].reset();
        $("#hidden_id").val("");
        $("#exampleModalLabel5").text("Tambah Data");
        $("#animationModal").modal("show");
    });

    $("#formInput").on("submit", function (e) {
        e.preventDefault();

        let id = $("#hidden_id").val(); // ambil id, kosong = tambah
        let formData = new FormData(this);

        // Ambil URL update dari tombol edit jika ada
        let url = id
            ? $("#formInput").data("update") || updateUrl + "/" + id
            : storeUrl;

        if (id) formData.append("_method", "PUT"); // method spoofing untuk update

        $.ajax({
            url: url,
            type: "POST", // selalu POST untuk AJAX + _method
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status) {
                    $("#animationModal").modal("hide");
                    dt_ajax.ajax.reload();
                    Swal.fire({
                        title: "Berhasil",
                        text: res.message,
                        icon: "success",
                        showConfirmButton: false,
                        showCloseButton: true,
                        showClass: {
                            popup: "animate__animated animate__flipInX",
                        },
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    title: "Error",
                    text: xhr.responseJSON?.message || "Terjadi kesalahan",
                    icon: "error",
                    showClass: {
                        popup: "animate__animated animate__shakeX",
                    },
                });
            },
        });
    });

    $(document).on("click", ".editBtn", function () {
        // RESET FORM & FILE INPUT
        $("#formInput")[0].reset();

        let id = $(this).data("id");

        $.get("/anggota/" + id, function (res) {
            let data = res.data;

            $("#hidden_id").val(id);
            $("#nik").val(data.nik);
            $("#nama").val(data.nama);

            if (data.jenis_kelamin === "L") {
                $("#jk_l").prop("checked", true);
            } else if (data.jenis_kelamin === "P") {
                $("#jk_p").prop("checked", true);
            }

            $("#pekerjaan").val(data.pekerjaan);
            $("#usia").val(data.usia);
            $("#alamat").val(data.alamat);

            $("#exampleModalLabel5").text("Edit Anggota");
            $("#animationModal").modal("show");
        });
    });

    $(document).on("click", ".deleteBtn", function () {
        let id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            customClass: {
                confirmButton: "btn btn-primary me-3 waves-effect waves-light",
                cancelButton:
                    "btn btn-label-secondary waves-effect waves-light",
            },
            buttonsStyling: false,
            showClass: {
                popup: "animate__animated animate__flipInX",
            },
            hideClass: {
                popup: "animate__animated animate__flipOutX",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/anggota/" + id,
                    type: "POST", // method spoofing
                    data: {
                        _method: "DELETE",
                        _token: $('meta[name="csrf-token"]').attr("content"),
                    },
                    success: function (res) {
                        if (res.status) {
                            dt_ajax.ajax.reload(null, false);
                            Swal.fire({
                                icon: "success",
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                customClass: {
                                    confirmButton:
                                        "btn btn-success waves-effect waves-light",
                                },
                                showClass: {
                                    popup: "animate__animated animate__flipInX",
                                },
                                hideClass: {
                                    popup: "animate__animated animate__flipOutX",
                                },
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: "Error",
                            text:
                                xhr.responseJSON?.message ||
                                "Terjadi kesalahan",
                            icon: "error",
                            showClass: {
                                popup: "animate__animated animate__shakeX",
                            },
                        });
                    },
                });
            }
        });
    });
});
