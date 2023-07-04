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
					<h3 class="box-title"><?=lang('update_settings')?></h3>
					
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<!-- Custom Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab_1" data-toggle="tab"><?=lang('general_settings')?></a></li>
							<li><a href="#tab_2" data-toggle="tab"><?=lang('payment_settings')?></a></li>
							
							
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<!-- /.box-header -->
								<?=form_open_multipart('admin/settings/general',['class'=>'form-horizontal','novalidate'=>'novalidate']) ?>

								<input type="hidden" name="id" value="<?=isset($setting->id)?$setting->id:''?>">

								<div class="box-body">
									

									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('site_name')?>
										</label>

										<div class="col-sm-8">
											<input type="text" class="form-control" id="inputEmail3" placeholder="Enter Name" name="name" required value="<?=set_value('name' , isset($setting->name) ? $setting->name : ''); ?>">

											<!-- Validation Error -->
											<?=form_error('name') ?>
										</div>
									</div>

									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('site_email')?>
										</label>

										<div class="col-sm-8">
											<input type="email" class="form-control" id="inputEmail3" placeholder="Enter Email" name="email" required value="<?=set_value('email' , isset($setting->email) ? $setting->email : ''); ?>">

											<!-- Validation Error -->
											<?=form_error('email') ?>
										</div>
									</div>
									

									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('site_description')?>
										</label>

										<div class="col-sm-8">
											<textarea class="form-control" name="description" cols="30" rows="5"><?=set_value('description' , isset($setting->description) ? $setting->description : '')?></textarea>

											<!-- Validation Error -->
											<?=form_error('description') ?>
										</div>
									</div>


									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('site_keywords')?>
										</label>

										<div class="col-sm-8">
											<textarea class="form-control" name="keywords" cols="30" rows="5"><?=set_value('keywords' , isset($setting->keywords) ? $setting->keywords : '')?></textarea>

											<!-- Validation Error -->
											<?=form_error('keywords') ?>
										</div>
									</div>


									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('copyright')?>
										</label>

										<div class="col-sm-8">
											<textarea class="form-control" name="copyright" cols="30" rows="5"><?=set_value('copyright' , isset($setting->copyright) ? $setting->copyright : '')?></textarea>

											<!-- Validation Error -->
											<?=form_error('copyright') ?>
										</div>
									</div>

									

								</div>
								<!-- /.box-body -->
								<div class="box-footer">
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-10">
											<button type="submit" class="btn btn-info"><?=lang('update_general_settings')?></button>
										</div>
									</div>

								</div>
								<!-- /.box-footer -->
								<?=form_close() ?>
							</div>
							
							<!-- /.tab-pane -->
							<div class="tab-pane" id="tab_2">
								<!-- /.box-header -->
								<?=form_open('admin/settings/payment',['class'=>'form-horizontal','novalidate'=>'novalidate']) ?>

								<input type="hidden" name="id" value="<?=isset($setting->id)?$setting->id:''?>">

								<!-- STRIPE BODY -->
								<div class="box-body">

									<div class="box-header">
										<h3 class="box-title"><?=lang('stripe')?></h3>
										<hr>
									</div>

									<!-- mode -->
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('stripe_mode')?>
										</label>

										<div class="col-sm-8">
											<select name="stripe_mode" id="" class="form-control">
												<option <?=($setting->stripe_mode == 'development')?'selected':'' ?> value="development"><?=lang('development')?></option>
												<option <?=($setting->stripe_mode == 'live')?'selected':'' ?> value="live"><?=lang('live')?></option>
											</select>

										</div>
									</div>

									<!-- publish -->
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('stripe_publish_key')?>
										</label>

										<div class="col-sm-8">
											<input type="text" class="form-control" id="inputEmail3" placeholder="Enter publish key" name="stripe_publish_key" required value="<?=set_value('stripe_publish_key' , isset($setting->stripe_publish_key) ? $setting->stripe_publish_key : ''); ?>">

											<!-- Validation Error -->
											<?=form_error('stripe_publish_key') ?>
										</div>

									</div>

									<!-- secret -->
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('stripe_secret_key')?>
										</label>

										<div class="col-sm-8">
											<input type="text" class="form-control" id="inputEmail3" placeholder="Enter secret key" name="stripe_secret_key" required value="<?=set_value('stripe_secret_key' , isset($setting->stripe_secret_key) ? $setting->stripe_secret_key : ''); ?>">

											<!-- Validation Error -->
											<?=form_error('stripe_secret_key') ?>
										</div>
									</div>

									<!-- webhook -->
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-4">
											<?=lang('stripe_webhook_key')?>
										</label>

										<div class="col-sm-8">
											<input type="text" class="form-control" id="inputEmail3" placeholder="Enter webhook key" name="stripe_webhook_key" required value="<?=set_value('stripe_webhook_key' , isset($setting->stripe_webhook_key) ? $setting->stripe_webhook_key : ''); ?>">

											<!-- Validation Error -->
											<?=form_error('stripe_webhook_key') ?>
										</div>
									</div>
								</div>
								<!-- /.box-body -->

								


								<div class="box-footer">
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-10">
											<button type="submit" class="btn btn-info"><?=lang('update_payment_settings')?></button>
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

