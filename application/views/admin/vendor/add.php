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
	<div class="row">
		<div class="col-xs-8">

			<!-- messages -->
			<?php require_once(__DIR__ .'../../inc/messages.php');?>

			
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"><?=lang('add_user')?></h3>
					<a href="<?=base_url('admin/vendors/')?>" class="btn btn-primary pull-right">
						<i class="fa fa-arrow-left"></i> <?=lang('back')?> 
					</a>
				</div>
				<!-- /.box-header -->
				<?=form_open_multipart('admin/vendors/create',['class'=>'form-horizontal','novalidate'=>'novalidate']) ?>
				
				<div class="box-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4">
							<?=lang('name')?>
						</label>

						<div class="col-sm-8">
							<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Name" name="name" required value="<?=set_value('name'); ?>">

							<!-- Validation Error -->
							<?=form_error('name') ?>
						</div>
					</div>

					
					

					<div class="form-group">
						<label for="inputPassword3" class="col-sm-4"><?=lang('profile')?></label>

						<div class="col-sm-8">
							<input type="file" class="form-control" id="inputPassword3"  name="file" required >

							<!-- Validation Error -->
							<?=form_error('file') ?>
						</div>
					</div>



					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4">
							<?=lang('email')?>
						</label>

						<div class="col-sm-8">
							<input type="email" class="form-control" id="inputEmail3" placeholder="Enter Email" name="email" required value="<?=set_value('email'); ?>">

							<!-- Validation Error -->
							<?=form_error('email') ?>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4">
							<?=lang('password')?>
						</label>

						<div class="col-sm-8">
							<input type="password" class="form-control" id="inputEmail3" placeholder="Enter Password" name="password" required value="<?=set_value('password'); ?>">

							<!-- Validation Error -->
							<?=form_error('password') ?>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4">
							<?=lang('commission')?>
						</label>

						<div class="col-sm-8">
							<input type="number" class="form-control" id="inputEmail3" placeholder="Enter your commission" name="percentage" required value="<?=set_value('percentage'); ?>">

							<!-- Validation Error -->
							<?=form_error('percentage') ?>
						</div>
					</div>

					





				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-10">
							<button type="submit" class="btn btn-info"><?=lang('add_vendor')?></button>
						</div>
					</div>

				</div>
				<!-- /.box-footer -->
				<?=form_close() ?>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>
<!-- /.content -->

<?php require_once(__DIR__ .'../../inc/footer.php');?>


<!-- Page script -->
<script>
	$(function () {
	    //Initialize Select2 Elements
	    $('.select2').select2()
	});

</script>


