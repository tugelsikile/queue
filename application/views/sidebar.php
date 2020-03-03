<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="active">
            
                <a href="javascript:;" uri="<?php echo base_url('home/antrian_loket');?>" onclick="load_page(this);return false">
                    <i class="fa fa-credit-card"></i> <span>Antrian Pendaftaran</span>
                </a>
            
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-rocket"></i>
                    <span>Launcher</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo base_url('entry');?>" target="_blank" >
                            <i class="fa fa-rocket"></i> <span>Pemilihan Poli</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('big_screen/pendaftaran');?>" target="_blank" >
                            <i class="fa fa-rocket"></i> <span>Tampilan Antrian Pendaftaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('big_screen/poli');?>" target="_blank" >
                            <i class="fa fa-rocket"></i> <span>Tampilan Antrian Poli</span>
                        </a>
                    </li>
                </ul>
            </li>
<?php if ($this->session->userdata('user_level') == 99){ ?>
            <li class="header">ADMIN MENU</li>
            <!--<li class="treeview">
                <a href="javascript:;" uri="<?php echo base_url('home/antri_statistik');?>" onclick="load_page(this);return false">
                    <i class="fa fa-bar-chart"></i> <span>Statistik Antrian</span>
                </a>
            </li>-->

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>Loket dan Poli</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="javascript:;" uri="<?php echo base_url('admin/admin_loket');?>" onclick="load_page(this);return false">
                            <i class="fa fa-hospital-o"></i> <span>Loket Pendaftaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" uri="<?php echo base_url('admin/admin_poli');?>" onclick="load_page(this);return false">
                            <i class="fa fa-hospital-o"></i> <span>Poli</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user-md"></i>
                    <span>Pengguna dan Dokter</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="javascript:;" uri="<?php echo base_url('admin/admin_user');?>" onclick="load_page(this);return false">
                            <i class="fa fa-user-circle"></i> <span>Pengguna</span>
                        </a>
                    </li>
                    <li><a href="javascript:;" onclick="load_page(this);return false" uri="<?php echo base_url('dokter/admin_dokter');?>"><i class="fa fa-circle-o"></i> Data Dokter</a></li>
                    <li><a href="javascript:;" onclick="load_page(this);return false" uri="<?php echo base_url('dokter/admin_spesialis');?>"><i class="fa fa-circle-o"></i> Spesialisasi</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span>Misc.</span>
                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    <ul class="treeview-menu">
                        <li>
                            <a href="javascript:;" uri="<?php echo base_url('admin/runing_text');?>" onclick="load_page(this);return false">
                                <i class="fa fa-road"></i> <span>Running Text</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;" uri="<?php echo base_url('admin/video');?>" onclick="load_page(this);return false">
                                <i class="fa fa-youtube-play"></i> <span>Video</span>
                            </a>
                        </li>
                    </ul>
                </a>
            </li>
<?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>