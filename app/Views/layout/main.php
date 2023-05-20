<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Al-Haqq - <?= $title ?></title>
    <meta content="Alhaqq Academic Information System" name="description" />
    <meta content="AAIS v2.0 by Arta Kusuma Teknologi Development" name="author" />
    <link rel="shortcut icon" href="<?= base_url('public/img/favicon.png') ?>">

    <link href="<?= base_url() ?>public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>public/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>public/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>public/assets/css/style.css" rel="stylesheet" type="text/css">
    <script src="<?= base_url() ?>public/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>public/assets/select2/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>public/assets/select2/dist/css/select2-bootstrap4.min.css" />
    <link href="<?= base_url() ?>public/assets/plugins/summernote/summernote-bs4.css" rel="stylesheet" />
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/fc-4.2.2/datatables.min.css" rel="stylesheet"/>
    <!-- <link href="<?= base_url() ?>public/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" /> -->
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.4/fc-4.2.2/datatables.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css"> -->
    
    <!-- Hightcharts JS-->
    <script src="<?= base_url() ?>public/assets/js/highcharts.js"></script>

    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>public/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Top Bar Start -->
        <div class="topbar">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="/" class="logo">
                    <span class="logo-light">
                        <img src="<?= base_url('public/img/favicon.png') ?>" alt="" height="35"> Al Haqq
                    </span>
                    <span class="logo-sm">
                        <img src="<?= base_url('public/img/favicon.png') ?>" alt="" height="35">
                    </span>
                </a>
            </div>

            <?= $this->renderSection('nav') ?>

        </div>
        <!-- Top Bar End -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <div class="slimscroll-menu" id="remove-scroll">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu" id="side-menu">
                        <?= $this->renderSection('menu') ?>
                    </ul>

                </div>
                <!-- Sidebar -->
                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="page-title-box">
                        <div class="row align-items-center">

                            <?= $this->renderSection('judul') ?>


                        </div> <!-- end row -->
                    </div>
                    <!-- end page-title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <?= $this->renderSection('isi') ?>
                                    <?= $this->renderSection('script') ?>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->


                </div>
                <!-- container-fluid -->

            </div>
            <!-- content -->




        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->
</body>

</html>