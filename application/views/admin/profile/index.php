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
		<div class="col-xs-12">

			 <!-- messages -->
			<?php require_once(__DIR__ .'../../inc/messages.php');?>


			<div class="box">
				<div class="box-header">
					<h3 class="box-title"><?=lang('profile')?></h3>
					
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab_1" data-toggle="tab"><?=lang('account')?></a></li>
							<li><a href="#tab_2" data-toggle="tab"><?=lang('password')?></a></li>
							
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- /.box-header -->
								<?=form_open_multipart('admin/profile/update',['class'=>'form-horizontal','novalidate'=>'novalidate']) ?>

								<div class="box-body">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('name')?>
										</label>

										<div class="col-sm-8">
											<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Name" name="name" required value="<?=set_value('name' , isset($user->name) ? $user->name : ''); ?>">

											<!-- Validation Error -->
											<?=form_error('name') ?>
										</div>
									</div>

									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('email')?>
										</label>

										<div class="col-sm-8">
											<input type="email" class="form-control" id="inputEmail3" placeholder="<?=isset($user->email) ? $user->email : ''?>" name="email" required value="<?=set_value('email'); ?>">

											<!-- Validation Error -->
											<?=form_error('email') ?>
										</div>
									</div>

									

								<div class="form-group">
									<label for="inputPassword3" class="col-sm-4"><?=lang('profile_image')?></label>

									<div class="col-sm-8">
										<input type="file" class="form-control" id="inputPassword3"  name="file" required >

										<!-- Validation Error -->
										<?=form_error('file') ?>
									</div>
								</div>

							</div>
							<!-- /.box-body -->
							<div class="box-footer">
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-10">
										<button type="submit" class="btn btn-info"><?=lang('update_profile')?></button>
									</div>
								</div>

							</div>
							<!-- /.box-footer -->
							<?=form_close() ?>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_2">
							<!-- /.box-header -->
								<?=form_open('admin/profile/password',['class'=>'form-horizontal','novalidate'=>'novalidate']) ?>

								<div class="box-body">
									

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-4">
										<?=lang('new_password')?>
									</label>

									<div class="col-sm-8">
										<input type="password" class="form-control" id="inputEmail3" placeholder="Enter New Password" name="password" required value="<?=set_value('password'); ?>">

										<!-- Validation Error -->
										<?=form_error('password') ?>
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-4">
										<?=lang('confirm_password')?>
									</label>

									<div class="col-sm-8">
										<input type="password" class="form-control" id="inputEmail3" placeholder="Enter Confirm Password" name="c_password" required value="<?=set_value('c_password'); ?>">

										<!-- Validation Error -->
										<?=form_error('c_password') ?>
									</div>
								</div>



							</div>
							<!-- /.box-body -->
							<div class="box-footer">
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-10">
										<button type="submit" class="btn btn-info"><?=lang('update_password')?></button>
									</div>
								</div>

							</div>
							<!-- /.box-footer -->
							<?=form_close() ?>
						</div>

					</div>
					<!-- /.tab-content -->
				</div>
				<!-- nav-tabs-custom -->
			</div>
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

