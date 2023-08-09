<!-- Modal -->
<div class="modal fade" id="modalimport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('/ujian-custom/import', ['class' => 'formimport']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <p class="mt-1">Catatan :<br>
                    <i class="mdi mdi-information"></i> Template import adalah langsung dari hasil export excel.<br>
                    <i class="mdi mdi-information"></i> Untuk menghindari salah input harap hapus data ujian yang tidak ingin diisi/diedit (Hapus seluruh row / langsung satu baris).<br> 
                    <i class="mdi mdi-information"></i> Data import Excel maximal berisi 300 Data/Baris. Jika lebih maka data selebihnya akan gagal ter-import ke dalam sistem.<br>
                    <i class="mdi mdi-information"></i> Data yang diproses pada menu import ini hanya data <b>Variabel ujian custom saja.</b><br>
                </p>
                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" class="form-control" name="file_excel" accept=".xls, .xlsx" required>
                    </div>
            </div>    
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan"><i class="fa fa-file-upload"></i> Import</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<!-- Your modal HTML here -->

<script>
    $(document).ready(function() {
        $('.js-example-basic-single-edit').select2({});

        $('.formimport').submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var formData = new FormData(form[0]);

            // Show loading animation
            let loadingSwal = Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: "post",
                url: form.attr('action'),
                data: formData,
                dataType: "json",
                contentType: false, // Set to false for FormData
                processData: false, // Set to false for FormData
                success: function(response) {
                    if (response.status === 'success') {
                        loadingSwal.close(); // Close the loading animation
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            html: response.message,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to the specified URL
                                window.location.href = response.url;
                            }
                        });
                    }
                },
                error: function() {
                    loadingSwal.close(); // Close the loading animation
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        allowOutsideClick: false
                    });
                }
            });
        });
    });
</script>
