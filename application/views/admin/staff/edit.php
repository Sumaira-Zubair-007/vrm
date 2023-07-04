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
					<h3 class="box-title"> <?=lang('edit_user')?></h3>
					<a href="<?=base_url('admin/staffs/')?>" class="btn btn-primary pull-right">
						<i class="fa fa-arrow-left"></i> <?=lang('back')?> 
					</a>
				</div>
				<!-- /.box-header -->
				<?=form_open_multipart('admin/staffs/update',['class'=>'form-horizontal','novalidate'=>'novalidate']) ?>
				<input type="hidden" name="id" value="<?=isset($staff->id)?$staff->id:''?>" >
				<div class="box-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4">
							<?=lang('name')?>
						</label>

						<div class="col-sm-8">
							<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Name" name="name" required value="<?=set_value('name' , isset($staff->name) ? $staff->name : ''); ?>">

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
							<input type="email" class="form-control" id="inputEmail3" placeholder="<?=isset($staff->email) ? $staff->email : 'Enter Email'?>" name="email" required value="<?=set_value('email'); ?>" autocomplete="off">

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
							<?=lang('Roles_Access')?>
						</label>
						<div class="col-sm-8">
							<input type="radio" name="roles_access" value="1" <?=($staff->roles_access == 1) ? ' checked="checked"' : ''?>> Allow Access to Invoices <br>
							<input type="radio" name="roles_access" value="0" <?=($staff->roles_access != 1) ? ' checked="checked"' : ''?>> Dis-Allow Access to Invoices <br>
						</div>
					</div>

					

				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-10">
							<button type="submit" class="btn btn-info"><?=lang('update_staff')?></button>
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
		<div class="col-xs-4">
			<img class="img img-responsive" src="<?=base_url('upload/staffs/'.$staff->picture.'')?>" alt="Vendor Image">
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


