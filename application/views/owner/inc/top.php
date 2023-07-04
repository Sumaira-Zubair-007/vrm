<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= base_url('owner/dashboard') ?>" class="logo">
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
                            <img src="<?= base_url('upload/owners/' . $this->session->userdata('picture') . '') ?>"
                                 class="user-image" alt="owner Image">
                            <span class="hidden-xs"><?= $this->session->userdata('name') ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- owner image -->
                            <li class="user-header">
                                <img src="<?= base_url('upload/owners/' . $this->session->userdata('picture') . '') ?>"
                                     class="img-circle" alt="owner Image">
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
                                    <a href="<?= base_url('owner/profile') ?>"
                                       class="btn btn-default btn-flat"><?=lang('profile')?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?= base_url('owner/dashboard/logout') ?>"
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
                    <img src="<?= base_url('upload/owners/' . $this->session->userdata('picture') . '') ?>"
                         class="img-circle" alt="owner Image">
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
                    <a href="<?= base_url('owner/dashboard') ?>">
                        <i class="fa fa-dashboard"></i>
                        <span><?=lang('dashboard') ?></span>
                    </a>
                </li>

                <!-- buildings -->
                <li class="treeview <?= (($this->uri->segment('2') == 'buildings')) ? 'active menu-open' : '' ?>">
                    <a href="#"> <i class="fa fa-building"></i> <span>Buildings</span> <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span> </a>
                    <ul class="treeview-menu">
                        <?php foreach($buildings as $building):?>
                            <li><a href="<?=base_url('owner/buildings/view/'.$building->id)?>"><i class="fa fa-circle-o"></i><?=$building->code?> </a></li>
                        <?php endforeach;?>
                    </ul>
                </li>


                <!-- Profile -->
                <li class="<?= (($this->uri->segment('2') == 'profile')) ? 'active' : '' ?>">
                    <a href="<?= base_url('owner/profile') ?>">
                        <i class="fa fa-pencil"></i>
                        <span><?=lang('profile') ?></span>
                    </a>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
			
