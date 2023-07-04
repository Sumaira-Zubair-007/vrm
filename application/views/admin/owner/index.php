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
					<h3 class="box-title"><?=lang('listings')?></h3>
					<a href="<?=base_url('admin/owners/add')?>" class="btn btn-info pull-right">
						<i class="fa fa-plus"></i> <?=lang('add_owner')?>
					</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table  class="table table-bordered table-striped dataTable">
						<thead>
							<tr>
								<th>#</th>
								<th><?=lang('name')?></th>
								<th><?=lang('email')?></th>
								<th><?=lang('status')?></th>
								<th><?=lang('action')?></th>
								
							</tr>
						</thead>
						<tbody>
							<?php foreach($owners as $key => $user):?>
								<tr>
									<td>
										<?=$key + 1 ?>
									</td>
									
									<td>
										<?=$user->name ?>
									</td>
									<td>
										<?=$user->email ?>
									</td>

									<td>
										<small class="label <?=$user->status == 1 ? 'bg-green' : 'bg-red'?>">
											<?=$user->status == 1 ? lang(
												'enabled') : lang('disabled')?>
										</small>
										
									</td>

									

									
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
												<?=lang('action')?>
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
												<!-- Status -->
												<li>
													<a href="<?=isset($user->id)?base_url('admin/owners/enable_disable'.'/'.$user->id.'/'.$user->status):"javascript:void(0)"?>">
														<?=lang('update_status')?>
													</a>
												</li>


												<!-- Edit -->
												<li>
													<a href="<?=isset($user->id)?base_url('admin/owners/edit'.'/'.$user->id):"javascript:void(0)"?>">
														<?=lang('edit')?>
													</a>
												</li>
												
												<!-- Delete  -->

												<li>
													<a onclick="return confirm('Are you sure?')" href="<?=isset($user->id)?base_url('admin/owners/delete'.'/'.$user->id):"javascript:void(0)"?>">
														<?=lang('delete')?>
													</a>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							<?php endforeach;?>
							

						</tbody>

					</table>
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


<script type="text/javascript">
	$(document).ready(function($) {
		$('.dataTable').dataTable();
	});
</script>