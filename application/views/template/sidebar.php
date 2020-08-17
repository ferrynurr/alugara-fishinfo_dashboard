<style type="text/css">

</style>
</head>
  <body class="nav-md">

  <div id="loader" class="loader loader-default is-active" data-text="Sedang Memuat Halaman..."></div>

    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">  
              <center>
                  <img src="<?php echo base_url('assets/img/jatim.png') ?>" alt="..." class="img-responsive" style="max-width: 45px; padding: 6px;">
                  <span style="color: #e8e8e8; font-size: 10px;" class="profile clearfix"><strong>Dashboard Fish Info</strong></span>
              </center>             
            </div>

            <div class="clearfix"></div>
            <br/>

            <!-- menu profile quick info -->
            <div class="profile clearfix"><br/>
                <div class="profile_pic">
                  <img src="<?php echo base_url('assets/gentelella/production/images/gmb.png') ?>" alt="..." class="img-circle profile_img">
                </div>
                <div class="profile_info">
                  <span>Welcome,</span>
                  <h2><?php echo $this->session->userdata('nama_surveyor') ?></h2>
                </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
          <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li id="dashboard_nav"><a href="<?= base_url('') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
  
                    <li><a><i class="fa fa-money" aria-hidden="true"></i> Ikan Konsumsi <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li id="eceran_konsumsi_nav"><a href="<?= base_url('Harga_konsumsi/tb_list_eceran') ?>">Eceran</a></li>
                        <li id="grosir_konsumsi_nav"><a href="<?= base_url('Harga_konsumsi/tb_list_grosir') ?>">Grosir</a></li>
                      </ul>
                    </li>
                    <li id="nonkonsumsi_nav"><a href="<?= base_url('Non_konsumsi') ?>"><i class="fa fa-money" aria-hidden="true"></i>Non-Konsumsi</a>
                    </li>

                    
                    <li><a><i class="fa fa-exchange" aria-hidden="true"></i> Domestik <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li id="dom_masuk_nav"><a href="<?= base_url('in_out/dom_masuk') ?>">Masuk</a></li>
                        <li id="dom_keluar_nav"><a href="<?= base_url('in_out/dom_keluar') ?>">Keluar</a></li>
                      </ul>
                    </li>
                     <li><a><i class="fa fa-inbox" aria-hidden="true"></i> Ekspor & Impor <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li id="ekspor_nav"><a href="<?= base_url('in_out/ekspor') ?>">Ekspor</a></li>
                        <li id="impor_nav"><a href="<?= base_url('in_out/impor') ?>">Impor</a></li>
                      </ul>
                    </li>
                    <li id="omset_nav"><a href="<?= base_url('omset') ?>"><i class="fa fa-credit-card" aria-hidden="true"></i> Omzet Kegiatan Perikanan</a></li>
                    <li id="konsumsi_ikan_nav"><a href="<?= base_url('konsumsi_ikan') ?>"><i class="fa fa-cutlery" aria-hidden="true"></i> Konsumsi Ikan</a></li>
                    <li><a><i class="fa fa-database" aria-hidden="true"></i> Master Data <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li id="trader_nav"><a href="<?= base_url('trader') ?>">Trader</a></li>
                        <li id="komokel_nav"><a href="<?= base_url('komoditas_kelompok') ?>">Kelompok Komoditas</a></li>
                        <li id="komo_nav"><a href="<?= base_url('komoditas') ?>">Komoditas</a></li>
                        <li><a href="#" onclick="bypass_login('data_pasar')">Pasar</a></li>
                        <li><a href="#" onclick="bypass_login('ikan?jenis=all')">Ikan konsumsi</a></li>
                        <li><a href="#" onclick="bypass_login('ikan_hias')">Ikan Hias/Non-konsumsi</a></li>
  
                      </ul>
                    </li>
                   <li><a><i class="fa fa-cog" aria-hidden="true"></i>Manajemen Pengguna <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="#" onclick="bypass_login('surveyor')">Pengguna</a></li>
                        
  
                      </ul>
                    </li>
                    

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

           </div>
        </div>


