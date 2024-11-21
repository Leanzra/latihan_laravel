<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $title ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url() ?>assets/fontawesome-free-6.6.0-web/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="<?= base_url() ?>assets/backend/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url() ?>assets/backend/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>assets/backend/css/pembayaran_listrik.css" rel="stylesheet">

  <!-- datatables -->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/tables/datatable/datatables.min.css">

  <!-- AutoCompleted -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/easy-autocomplete/easy-autocomplete.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/easy-autocomplete/easy-autocomplete.themes.min.css">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('admin') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fa-solid fa-bolt-lightning"></i>
        </div>
        <?php
            $judul = "Kamu Siapaa!"; // Default judul jika session tidak ada atau tidak sesuai
            if ($this->session->has_userdata('session_akses')) {
                if ($this->session->userdata('session_akses') == 'Agen') {
                    $judul = 'Agen PLN <i class="fa-solid fa-circle-check"></i>'; 
                } elseif ($this->session->userdata('session_akses') == 'Petugas') {
                    $judul = "Petugas PLN ";
                }
            }
            ?>
        <div class="sidebar-brand-text mx-3"><?=$judul?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?= ($this->uri->segment(1) == 'admin') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= site_url('admin') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Antar Muka
      </div>


      <!-- Nav Item - Data Utama -->
      <li class="nav-item <?= in_array($this->uri->segment(1), ['tarif', 'pelanggan', 'petag']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataUtama" aria-expanded="<?= in_array($this->uri->segment(1), ['tarif', 'pelanggan', 'petag']) ? 'true' : 'false' ?>" aria-controls="collapseDataUtama">
          <i class="fas fa-fw fa-cog"></i>
          <span>Data Utama</span>
        </a>
        <div id="collapseDataUtama" class="collapse <?= in_array($this->uri->segment(1), ['tarif', 'pelanggan', 'petag']) ? 'show' : '' ?>" aria-labelledby="headingDataUtama" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Komponen Data Utama:</h6>
            <a class="collapse-item <?= $this->uri->segment(1) === 'tarif' ? 'active' : '' ?>" href="<?= base_url('tarif') ?>">Data Tarif</a>
            <a class="collapse-item <?= $this->uri->segment(1) === 'pelanggan' ? 'active' : '' ?>" href="<?= base_url('pelanggan') ?>">Data Pelanggan</a>
            <?php if ($this->session->userdata('session_akses') === 'Petugas'): ?>
              <a class="collapse-item <?= $this->uri->segment(1) === 'petag' ? 'active' : '' ?>" href="<?= base_url('petag') ?>">Petugas dan Agen</a>
            <?php endif; ?>
          </div>
        </div>
      </li>

      <!-- Nav Item - Penggunaan -->
      <li class="nav-item <?= $this->uri->segment(1) === 'penggunaan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('penggunaan') ?>">
          <i class="fa-solid fa-user-clock"></i>
          <span>Penggunaan</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Pembayaran
      </div>

      <!-- Nav Item - Tagihan Listrik -->
      <li class="nav-item <?= $this->uri->segment(1) === 'tagihan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('tagihan') ?>">
          <i class="fa-solid fa-money-bills"></i>
          <span>Tagihan Listrik</span>
        </a>
      </li>

      <!-- Nav Item - Pembayaran -->
      <li class="nav-item <?= in_array($this->uri->segment(1), ['pembayaran','rpembayaran','tunggakan']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePembayaran" aria-expanded="<?= in_array($this->uri->segment(1), ['pembayaran','rpembayaran','tunggakan']) ? 'true' : 'false' ?>" aria-controls="collapsePembayaran">
          <i class="fa-solid fa-wallet"></i>
          <span>Bayar Tagihan</span>
        </a>
        <div id="collapsePembayaran" class="collapse <?= in_array($this->uri->segment(1), ['pembayaran','rpembayaran','tunggakan']) ? 'show' : '' ?>" aria-labelledby="headingPembayaran" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Komponen Pembayaran:</h6>
            <a class="collapse-item <?= $this->uri->segment(1) === 'pembayaran' ? 'active' : '' ?>" href="<?= base_url('pembayaran') ?>">Pembayaran Tagihan</a>
            <a class="collapse-item <?= $this->uri->segment(1) === 'rpembayaran' ? 'active' : '' ?>" href="<?= base_url('rpembayaran') ?>">Riwayat Pembayaran</a>
            <a class="collapse-item <?= $this->uri->segment(1) === 'tunggakan' ? 'active' : '' ?>" href="<?= base_url('tunggakan') ?>">Pelanggan Menunggak</a>
          </div>
        </div>
      </li>

      

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <h5>Pembayaran Listrik Pascabayar</h5>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
            </li>

            


            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  Akses Sebagai <?= isset($cek_login['akses']) ? htmlspecialchars($cek_login['akses']) : '' ?> 
                  | <?= isset($cek_login['nama_petugas']) ? htmlspecialchars($cek_login['nama_petugas']) : '' ?>  
                </span>
                <img class="img-profile rounded-circle" src="<?= isset($cek_login['foto_profil']) ? htmlspecialchars($cek_login['foto_profil']) : '' ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->


        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?=site_url('logout')?>">Logout</a>
              </div>
            </div>
          </div>
        </div>

