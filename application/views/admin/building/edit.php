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
					<h3 class="box-title"><?=lang('edit_building')?></h3>
					<a href="<?=base_url('admin/buildings/')?>" class="btn btn-primary pull-right">
						<i class="fa fa-arrow-left"></i> <?=lang('back')?> 
					</a>
				</div>
				<!-- /.box-header -->
				<?=form_open_multipart('admin/buildings/update',['class'=>'form-horizontal','novalidate'=>'novalidate']) ?>
				<input type="hidden" name="id" value="<?=isset($building->id) ? $building->id : ''?>">
				
				<div class="box-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4">
							<?=lang('owner')?>
						</label>

						<div class="col-sm-8">
							<select class="form-control select2" name="owner_id" required>
								<option value="" selected disabled>Select owner...</option>
								<?php foreach($owners as $owner): ?>
									<option <?=set_value('owner_id', isset($building->owner_id) ? $building->owner_id : '') == $owner->id ? 'selected' : '' ?> value="<?=$owner->id?>"> <?=$owner->name?></option>
								<?php endforeach;?>
							</select>

							<!-- Validation Error -->
							<?=form_error('owner_id') ?>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4">
							<?=lang('code')?>
						</label>

						<div class="col-sm-8">
							<input type="text" class="form-control" id="inputEmail3" placeholder="<?=isset($building->code) ? $building->code : ''?>" name="code" required value="">

							<!-- Validation Error -->
							<?=form_error('code') ?>
						</div>
					</div>


					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4">
							<?=lang('address')?>
						</label>

						<div class="col-sm-8">
							<textarea class="form-control" id="inputEmail3" placeholder="Enter building address" name="address" required><?=set_value('address', isset($building->address) ? $building->address : ''); ?></textarea>
						
							<!-- Validation Error -->
							<?=form_error('address') ?>
						</div>
					</div>

					





				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-10">
							<button type="submit" class="btn btn-info"><?=lang('edit_building')?></button>
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


