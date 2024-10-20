<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <a href="<?= base_url('public/sertifikat/'.$data_sertifikat['sertifikat_file']) ?>" target="_blank" type="button" class="btn btn-warning mx-auto mb-3">Download e-Sertifikat</a>
                </div>
                <div id="pdf-container">
                    <embed id="pdf-object" src="/public/sertifikat/<?= $data_sertifikat['sertifikat_file'] ?>" type="application/pdf" style="width: 100%; height: calc(100vh - 120px); justify-content: center;"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
        });
    });
</script>