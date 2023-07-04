<?php require_once(__DIR__ .'../../inc/header.php');?>
<?php require_once(__DIR__ .'../../inc/top.php');?>


<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?=$title ?>
	</h1>
	
</section>


<!-- Main content -->
<section class="content">
	<!-- Small boxes (Stat box) -->
	<div class="row">


		
		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3><?=isset($stats->invoices)?$stats->invoices:0?></h3>

					<p><?=lang('invoices')?></p>
				</div>
				<div class="icon">
					<i class="fa fa-money"></i>
				</div>
				<a href="<?=base_url('owner/dashboard')?>" class="small-box-footer"><?=lang('more_info')?> <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->

		<!-- ./col -->
		<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?=isset($buildings)?count($buildings):0?></h3>

					<p>Buildings</p>
				</div>
				<div class="icon">
					<i class="fa fa-building"></i>
				</div>
				<a href="<?=base_url('owner/dashboard')?>" class="small-box-footer"><?=lang('more_info')?> <i class="fa fa-arrow-circle-right"></i></a>
			</div>
		</div>
		<!-- ./col -->

	</div>
	<!-- /.row -->


</section>
<!-- /.content -->

<?php require_once(__DIR__ .'../../inc/footer.php');?>
