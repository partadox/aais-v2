<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h3 class="page-title">Dashboard - Angkatan Perkuliahan Saat ini : </h3>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-right">
        <div id="clock"></div>
    </ol>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <i class="mdi mdi-account-multiple-outline"></i>
    <strong>Selamat Datang <?= $user['nama'] ?> </strong> Di Sistem Informasi Al-Haqq.
</div>
<?php if ($user['level'] == 1 || $user['level'] == 2 || $user['level'] == 3 || $user['level'] == 7) { ?>
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-cash-marker bg-warning  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Konfirmasi Pembayaran</h5>
                    </div>
                    <h3 class="mt-4"><?= $konfirmasi ?></h3>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-office-building bg-warning text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Jumlah Kantor/Cabng</h5>
                    </div>
                    <h5 class="mt-4"><?= $kantor ?></h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-application bg-warning text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Jumlah Program</h5>
                    </div>
                    <h5 class="mt-4"><?= $program ?></h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-school bg-warning text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Jumlah Kelas</h5>
                    </div>
                    <h5 class="mt-4"><?= $kelas ?></h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-account bg-warning text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Jumlah Pengajar</h5>
                    </div>
                    <h5 class="mt-4"><?= $pengajar ?></h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-account-badge bg-warning text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Jumlah Akun Pengajar</h5>
                    </div>
                    <h5 class="mt-4"><?= $akun_pengajar ?></h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-account bg-warning text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Jumlah Peserta</h5>
                    </div>
                    <h5 class="mt-4"><?= $peserta ?></h5>
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-md-3">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-account-badge bg-warning text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Jumlah Akun Peserta</h5>
                    </div>
                    <h5 class="mt-4"><?= $akun_peserta ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg">
        <div class="card-header pb-0">
            <h6 class="card-title mb-2">Rekap Pembayaran SPP Peserta Angkatan Perkuliahan <?= $angkatan ?></h6>
            <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-auto mb-2">
                    <label for="angkatan_kelas">Pilih Angkatan Perkuliahan</label>
                    <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="angkatan_kelas" id="angkatan_kelas" class="js-example-basic-single mb-2">
                        <?php foreach ($list_angkatan as $key => $data) { ?>
                            <option value="dashboard?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?>> <?= $data['angkatan_kelas'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <h6><b>Seluruh Level (IKHWAN + AKHWAT)</b></h6>
            <div class="row">
                <div class="col-8">
                    <div id="bar_spp"></div>
                </div>
                <div class="col-4">
                    <div id="pie_spp"></div>
                </div>
            </div>
            <hr>
            <h6><b>Seluruh Level (IKHWAN)</b></h6>
            <button class="btn btn-warning" data-toggle="modal" data-target="#ModalIkhwan"> Detail Per Level</button>
            <div class="col-8">
                <div id="pie_ikhwan"></div>
            </div>
            <hr>
            <h6><b>Seluruh Level (AKHWAT)</b></h6>
            <button class="btn btn-warning" data-toggle="modal" data-target="#ModalAkhwat"> Detail Per Level</button>
            <div class="col-8">
                <div id="pie_akhwat"></div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ModalIkhwan" tabindex="-1" role="dialog" aria-labelledby="ModalIkhwanLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalIkhwanLabel">Detail per Level Ikhwan Angkatan <?= $angkatan_pilih ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="bar_level_ikhwan"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="ModalAkhwat" tabindex="-1" role="dialog" aria-labelledby="ModalAkhwatLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalAkhwatLabel">Detail per Level Akhwat Angkatan <?= $angkatan_pilih ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="bar_level_akhwat"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#angkatan_kelas').bind('change', function() { // bind change event to select
            var url = $(this).val(); // get selected value
            if (url != '') { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
        // Create the chart
        Highcharts.setOptions({
            colors: ['#fcbe2d', '#28a745']

        });

        Highcharts.chart('pie_spp', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    //   valueSuffix: '%'
                }
            },

            credits: {
                enabled: false
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:14px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
            },

            series: [{
                name: "SPP Peserta",
                colorByPoint: true,
                data: [{
                        name: "BELUM LUNAS",
                        y: <?= $spp_belum_lunas ?>,
                        //   drilldown: "Chrome"
                    },
                    {
                        name: "LUNAS",
                        y: <?= $spp_lunas ?>,
                        //   drilldown: "Firefox"
                    }
                ]
            }]
        })

        //Bar chart
        Highcharts.chart('bar_spp', {
            chart: {
                type: 'bar'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [
                    'Seluruh Level'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'JUMLAH PESERTA'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:14px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f} ORANG</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'BELUM LUNAS',
                data: [<?= $spp_belum_lunas ?>]

            }, {
                name: 'LUNAS',
                data: [<?= $spp_lunas ?>]

            }]
        });

        Highcharts.chart('pie_ikhwan', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    //   valueSuffix: '%'
                }
            },

            credits: {
                enabled: false
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:14px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
            },

            series: [{
                name: "SPP Peserta",
                colorByPoint: true,
                data: [{
                        name: "BELUM LUNAS",
                        y: <?= $spp_belum_lunas_ikhwan ?>,
                        //   drilldown: "Chrome"
                    },
                    {
                        name: "LUNAS",
                        y: <?= $spp_lunas_ikhwan ?>,
                        //   drilldown: "Firefox"
                    }
                ]
            }]
        })

        Highcharts.chart('pie_akhwat', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    //   valueSuffix: '%'
                }
            },

            credits: {
                enabled: false
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:14px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
            },

            series: [{
                name: "SPP Peserta",
                colorByPoint: true,
                data: [{
                        name: "BELUM LUNAS",
                        y: <?= $spp_belum_lunas_akhwat ?>,
                        //   drilldown: "Chrome"
                    },
                    {
                        name: "LUNAS",
                        y: <?= $spp_lunas_akhwat ?>,
                        //   drilldown: "Firefox"
                    }
                ]
            }]
        })

        //Bar chart Per Level Ikhwan
        Highcharts.chart('bar_level_ikhwan', {
            chart: {
                type: 'bar'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [
                    <?= $ikhwan_nama_level ?>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'JUMLAH PESERTA'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:14px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f} ORANG</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'BELUM LUNAS',
                data: [<?= $ikhwan_belum_lunas ?>]

            }, {
                name: 'LUNAS',
                data: [<?= $ikhwan_lunas ?>]

            }]
        })

        //Bar chart Per Level Akhwat
        Highcharts.chart('bar_level_akhwat', {
            chart: {
                type: 'bar'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: [
                    <?= $akhwat_nama_level ?>
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'JUMLAH PESERTA'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:14px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f} ORANG</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                },
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'BELUM LUNAS',
                data: [<?= $akhwat_belum_lunas ?>]

            }, {
                name: 'LUNAS',
                data: [<?= $akhwat_lunas ?>]

            }]
        })
    </script>
<?php } ?>
<?php if ($user['level'] == 4) { ?>
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-teach bg-warning  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Jumlah Kelas Anda pada Angkatan <?= $angkatan ?></h5>
                    </div>
                    <h3 class="mt-4"><?= $jml_kelas + $jml_kelas_bina ?></h3>
                </div>
            </div>
        </div>
    </div>
    <?php if ($pengumuman != NULL) { ?>
        <hr>
        <h4>Pengumuman</h4>
        <div class="container-fluid">
            <div class="row">
                <?php
                foreach ($pengumuman as $data) :
                ?>
                    <div class="col-sm-3 col-md-3">
                        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-body">
                                <h6 class="card-title"><?= $data['pengumuman_title'] ?></h6>
                                <span><?= $data['pengumuman_create'] ?></span>
                                <hr>
                                <button class="expandButton btn btn-warning">Baca</button>
                                <div class="baca" style="display: none;">
                                    <?= $data['pengumuman_content'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($beasiswa != NULL) { ?>
        <hr>
        <h4>Voucher Beasiswa</h4>
        <div class="container-fluid">
            <div class="row">
                <?php $nomor = 0;
                foreach ($beasiswa as $data) :
                    $nomor++; ?>
                    <div class="col-sm-3 col-md-3">
                        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-body">
                                <h6 class="card-title">Selamat Anda Mendapatkan Kode Voucher Beasiswa! </h6>
                                <hr>
                                Program : <b><?= $data['nama_program'] ?></b> <br> <br>
                                Kode Voucher : <b><?= $data['beasiswa_code'] ?></b> <br> <br>
                                <input style="display: none;" type="text" id="voucherCopy<?= $nomor ?>" value="<?= $data['beasiswa_code'] ?>"> <br> <br>
                                Untuk :
                                <ul>
                                    <?php if ($data['beasiswa_daftar'] == 1) { ?> <li>Pendaftaran</li> <?php } ?>
                                    <?php if ($data['beasiswa_spp1'] == 1) { ?> <li>SPP-1</li> <?php } ?>
                                    <?php if ($data['beasiswa_spp2'] == 1) { ?> <li>SPP-2</li> <?php } ?>
                                    <?php if ($data['beasiswa_spp3'] == 1) { ?> <li>SPP-3</li> <?php } ?>
                                    <?php if ($data['beasiswa_spp4'] == 1) { ?> <li>SPP-4</li> <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($pengumuman != NULL) { ?>
        <script>
            $(document).ready(function() {
                $(".expandButton").click(function() {
                    $(this).next('.baca').toggle(); // This will only toggle the zoom-container that is directly after the clicked button
                });
            });
        </script>
    <?php } ?>
    <?php if ($beasiswa != NULL) { ?>
        <script>
            const voucherCopyElements = document.querySelectorAll("input[id^='voucherCopy']");
            for (const voucherCopyElement of voucherCopyElements) {
                const copyButton = document.createElement("button");
                copyButton.id = voucherCopyElement.id + "-copy";
                copyButton.innerHTML = "<i class='fas fa-copy mr-1'></i> Copy Code Voucher";
                copyButton.addEventListener("click", function() {
                    navigator.clipboard.writeText(voucherCopyElement.value);
                    copyButton.innerHTML = "Voucher Copied";
                });

                voucherCopyElement.insertAdjacentElement("afterend", copyButton);
            }
        </script>
    <?php } ?>

<?php } ?>
<?php if ($user['level'] == 5 || $user['level'] == 6) { ?>
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-teach bg-warning  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Kelas Reguler Anda pada Angkatan <?= $angkatan ?> <br> (Sbg Pengajar)</h5>
                    </div>
                    <h3 class="mt-4"><?= $jml_kelas ?></h3>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-teach bg-warning  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Kelas Non-Reguler Anda tahun <?= date('Y') ?></h5>
                    </div>
                    <h3 class="mt-4"><?= $jml_kelas_nonreg ?></h3>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-4">
            <div class="card shadow-lg p-3">
                <div class="card-heading p-4">
                    <div class="mini-stat-icon float-right">
                        <i class="mdi mdi-teach bg-warning  text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-16">Kelas Anda pada Angkatan <?= $angkatan ?> <br> (Sbg Penguji)</h5>
                    </div>
                    <h3 class="mt-4"><?= $jml_kelas_penguji ?></h3>
                </div>
            </div>
        </div>
    </div>
    <?php if ($pengumuman != NULL) { ?>
        <hr>
        <h4>Pengumuman</h4>
        <div class="container-fluid">
            <div class="row">
                <?php
                foreach ($pengumuman as $data) :
                ?>
                    <div class="col-sm-3 col-md-3">
                        <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                            <div class="card-body">
                                <h5 class="card-title"><?= $data['pengumuman_title'] ?></h5>
                                <span><?= $data['pengumuman_create'] ?></span>
                                <hr>
                                <button class="expandButton btn btn-warning">Baca</button>
                                <div class="baca" style="display: none;">
                                    <?= $data['pengumuman_content'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $(".expandButton").click(function() {
                    $(this).next('.baca').toggle(); // This will only toggle the zoom-container that is directly after the clicked button
                });
            });
        </script>
    <?php } ?>
<?php } ?>
<?= $this->endSection('isi') ?>