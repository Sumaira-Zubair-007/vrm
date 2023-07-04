<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= base_url('admin/dashboard') ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
             <span class="logo-mini"><?=isset($settings->name)?substr($settings->name, 0,3):''?></span>
            <!-- logo for regular state and mobile devices -->
             <span class="logo-lg"><?=isset($settings->name)?$settings->name:''?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">

            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>


            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- end to messages here -->
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= base_url('upload/admins/' . $this->session->userdata('picture') . '') ?>"
                                 class="user-image" alt="User Image">
                            <span class="hidden-xs"><?= $this->session->userdata('name') ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= base_url('upload/admins/' . $this->session->userdata('picture') . '') ?>"
                                     class="img-circle" alt="User Image">
                                <p>
                                    <?= $this->session->userdata('name') ?>
                                    <?php if ($this->session->userdata('created_at')): ?>
                                        <small>Member
                                            Since <?= date('M , Y', strtotime($this->session->userdata('created_at'))) ?></small>
                                    <?php endif; ?>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?= base_url('admin/profile') ?>"
                                       class="btn btn-default btn-flat"><?=lang('profile')?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?= base_url('admin/dashboard/logout') ?>"
                                       class="btn btn-default btn-flat"><?=lang('logout')?></a>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= base_url('upload/admins/' . $this->session->userdata('picture') . '') ?>"
                         class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?= $this->session->userdata('name') ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i><?=lang('online') ?></a>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <!-- dashboard -->
                <li class="<?= (($this->uri->segment('2') == '') || ($this->uri->segment('2') == 'dashboard')) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/dashboard') ?>">
                        <i class="fa fa-dashboard"></i>
                        <span><?=lang('dashboard') ?></span>
                    </a>
                </li>
                <!--buildings-->

                <li class="<?= ($this->uri->segment('2') == 'buildings') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/buildings') ?>">
                        <i class="fa fa-building"></i>
                        <span><?=lang('buildings') ?></span>
                    </a>
                </li>

                 <!--invoices-->

                <li class="<?= ($this->uri->segment('2') == 'invoices') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/invoices') ?>">
                        <i class="fa fa-credit-card"></i>
                        <span><?=lang('invoices') ?></span>
                    </a>
                </li>

                <!--payments-->

                <li class="<?= ($this->uri->segment('2') == 'payments') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/payments') ?>">
                        <i class="fa fa-bars"></i>
                        <span><?=lang('payments') ?></span>
                    </a>
                </li>


                <!-- vendors -->
                <li class="<?= ($this->uri->segment('2') == 'vendors') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/vendors') ?>">
                        <i class="fa fa-user-o"></i>
                        <span><?=lang('vendors') ?></span>
                    </a>
                </li>

                 <!-- staffs -->
                <li class="<?= ($this->uri->segment('2') == 'staffs') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/staffs') ?>">
                        <i class="fa fa-user"></i>
                        <span><?=lang('staffs') ?></span>
                    </a>
                </li>

                <!-- owners -->
                <li class="<?= ($this->uri->segment('2') == 'owners') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/owners') ?>">
                        <i class="fa fa-user-circle-o"></i>
                        <span><?=lang('owners') ?></span>
                    </a>
                </li>


                <!-- Profile -->
                <li class="<?= (($this->uri->segment('2') == 'profile')) ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/profile') ?>">
                        <i class="fa fa-pencil"></i>
                        <span><?=lang('profile') ?></span>
                    </a>
                </li>

                
                <!--Settings-->

                <li class="<?= ($this->uri->segment('2') == 'settings') ? 'active' : '' ?>">
                    <a href="<?= base_url('admin/settings') ?>">
                        <i class="fa fa-cog"></i>
                        <span><?=lang('settings') ?></span>
                    </a>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
			
