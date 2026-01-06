"use strict";

$(function () {
    var dt_ajax_table = $(".datatables-ajax");
    let storeUrl = $("#formInput").data("store");
    let updateUrl = "/pinjaman";

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
                { data: "NamaAnggota", name: "NamaAnggota" },
                { data: "NikAnggota", name: "NikAnggota" },
                {
                    data: "NoTransaksi",
                    name: "NoTransaksi",
                },
                {
                    data: "JumlahPinjaman",
                    name: "JumlahPinjaman",
                },
                {
                    data: "tenor_bulan",
                    name: "tenor_bulan",
                },
                {
                    data: "status",
                    name: "status",
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
        $("#formInput")[0].reset();
        $("#hidden_id").val("");
        $("#exampleModalLabel5").text("Tambah Data");
        $("#animationModal").modal("show");
    });

    $("#formInput").on("submit", function (e) {
        e.preventDefault();

        $("#formError").addClass("d-none").text("");

        let id = $("#hidden_id").val();
        let formData = new FormData(this);

        let url = id
            ? $("#formInput").data("update") || updateUrl + "/" + id
            : storeUrl;

        if (id) formData.append("_method", "PUT");

        $.ajax({
            url: url,
            type: "POST",
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
                if (xhr.status === 422) {
                    $("#formError")
                        .removeClass("d-none")
                        .text("Data tidak valid");
                    return;
                }

                Swal.fire({
                    title: "Error",
                    showConfirmButton: false,
                    showCloseButton: true,
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

        $.get("/pinjaman/" + id, function (res) {
            let data = res.data;

            $("#hidden_id").val(id);
            $("#status").val(data.status);
            $("#tenor_bulan").val(data.tenor_bulan);

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
                    url: "/pinjaman/" + id,
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
