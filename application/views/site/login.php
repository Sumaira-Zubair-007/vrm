<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?=lang('login')?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?=base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url('assets/bower_components/font-awesome/css/font-awesome.min.css')?>">
	
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css')?>">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-xs-12">
			<div class="stats_box">
				<div class="stats-box-body">
					<?php if (isset($total_invoices_amount) && !empty($total_invoices_amount)) { ?> 
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
						<!-- small box -->
						<div class="small-box bg-green">
							<div class="inner">
								<h3>$<?php echo number_format($total_invoices_amount,2); ?></h3>
								<p>Projects</p>
							</div>
							<div class="icon">
								<i class="fa fa-users"></i>
							</div>
						</div>
					</div>
					<?php
					}
					?>
					
					<?php if (isset($total_buildings) && !empty($total_buildings)) { ?> 
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-6">
						<div class="info-box">
							<span class="info-box-icon bg-info"><i class="fa fa-building"></i></span>
							<div class="info-box-content">
							<span class="info-box-text">Buildings</span>
							<span class="info-box-number"><?php echo $total_buildings; ?></span>
							</div>
						</div>
					</div>
					<?php } ?>

					<?php if (isset($total_vendors) && !empty($total_vendors)) { ?> 
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-6">
						<div class="info-box">
							<span class="info-box-icon bg-aqua"><i class="fa fa-flag"></i></span>
							<div class="info-box-content">
							<span class="info-box-text">Vendors</span>
							<span class="info-box-number"><?php echo $total_vendors; ?></span>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-xs-12">
			<div class="login-box">
				<div class="login-logo">
					<a href="<?=base_url('/')?>"><b><?=lang('login')?></b></a>
				</div>
				<!-- /.login-logo -->
				<div class="login-box-body">
					<p class="login-box-msg"><?=lang('sign_in_to_start_your_session')?></p>

					<!-- Alert of Custom messages -->
					<?php if($this->session->flashdata('msg')): ?>
						<div class="alert alert-danger " role="alert">
							
							<?=$this->session->flashdata('msg') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<!-- End to alert -->

					<?=form_open('site/auth')?>
					<!--   -->
					<input type = "hidden" name="type" value="<?=$type?>" />
			
					<div class="form-group has-feedback">
						<input name="email" type="email" class="form-control" placeholder="Email">
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
						<?=form_error('email') ?>
					</div>
					<div class="form-group has-feedback">
						<input type="password" name="password" class="form-control" placeholder="Password">
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
						<?=form_error('password') ?>
					</div>
					<div class="row">
						<!-- /.col -->
						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat" style="width:200px;margin:0 auto;border-radius:4px;"><?=lang('login')?></button>
						</div>
						<!-- /.col -->
					</div>
					<?=form_close(); ?>

					<?=form_open('site/forgotpassword')?>
						<br>
						<input type="hidden" name="type" value="<?=$type?>" />
						<input type="hidden" name="load" value="view" />
						<button type="submit" class="btn btn-primary btn-block btn-flat" style="width:200px;margin:0 auto;border-radius:4px;"><?=lang('forgot_Password')?></button>
					<?=form_close(); ?>

					
				</div>
				<!-- /.login-box-body -->
			</div>
			<!-- /.login-box -->
		</div>
	</div>
	

	

	

	<!-- jQuery 3 -->
	<script src="<?=base_url('assets/bower_components/jquery/dist/jquery.min.js')?>"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?=base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>

</body>
</html>
