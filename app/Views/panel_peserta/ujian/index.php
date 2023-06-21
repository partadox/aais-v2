<!-- Modal -->
<div class="modal fade" id="modalujian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <h5 style="text-align:center;">Kelas <?= $kelas['nama_kelas'] ?></h5>
                <h6 style="text-align:center;"><?= $kelas['hari_kelas'] ?>, <?= $kelas['waktu_kelas'] ?> - <?= $kelas['metode_kelas'] ?></h6>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                            <th width="15%">Pelaksanaan Ujian</th>
                            <th width="5%">Nilai <br> Ujian</th>
                            <th width="5%">Nilai <br> Akhir</th>
                            <th width="10%">Rekomendasi <br> level</th>
                            <th width="60%">Note dari <br> Pengajar</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><?= $ujian['tgl_ujian'] ?> <?= $ujian['waktu_ujian'] ?></td>
                                <td><?= $ujian['nilai_ujian'] ?></td>
                                <td><?= $ujian['nilai_akhir'] ?></td>
                                <td><?= $ujian['next_level'] ?></td>
                                <td><?= $ujian['ujian_note'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
 
</script>