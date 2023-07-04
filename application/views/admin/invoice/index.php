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
					<a href="<?=base_url('admin/invoices/add')?>" class="btn btn-info pull-right">
						<i class="fa fa-plus"></i> <?=lang('add_invoice')?>
					</a>
					
				</div>
				<!-- /.box-header -->
				<div class="box-body" style="overflow-x: auto;">
					<table  class="table table-bordered table-striped dataTable">
						<thead>
							<tr>
								<th>#</th>
								<th><?=lang('vendor')?></th>
								<th><?=lang('building_code')?></th>
								<th><?=lang('building_address')?></th>
								<th><?=lang('work_order_no')?></th>
								<th><?=lang('total_amount')?></th>
								<th><?=lang('total_paid')?></th>
								<th><?=lang('net_amount')?></th>
								<th><?=lang('pay_status')?></th>
								<th><?=lang('status')?></th>
								<th><?=lang('created_at')?></th>
								<th><?=lang('action')?></th>
								
							</tr>
						</thead>
						<tbody>
							<?php foreach($invoices as $key => $invoice):?>
								<tr>
									<td><?=$key + 1 ?></td>
									<td><?=$invoice->vendor_name.'('. $invoice->vendor_email.')<br><b>Invoice#:</b> '.  $invoice->invoice_id ?></td>
									<td><?=$invoice->building_code ?></td>
									<td><?=$invoice->building_address ?></td>
									<td><?=$invoice->order_no ?></td>
									<td><?=$invoice->total_amount.' '.$invoice->currency ?></td>
									<td><?=$invoice->total_paid.' '.$invoice->currency ?></td>
									<td><?=$invoice->net_amount.' '.$invoice->currency ?></td>
									<td>
										<small class="label <?=$invoice->pay_status == 'approved' ? ( 'bg-green' ) : ( $invoice->pay_status == 'inprocess' ? ( 'bg-orange' ) : ( 'bg-red' ) )?>">
											<?=$invoice->pay_status ?>
										</small>
									</td>
									<td>
										<small class="label <?=$invoice->status == 'paid' ? ( 'bg-green' ) : ( $invoice->status == 'open' ? ( 'bg-blue' ) : ( 'bg-red' ) )?>">
											<?=$invoice->status ?>
										</small>
									</td>
									<td><?=date('Y-m-d H:i:s',strtotime($invoice->created_at))?></td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
												<?=lang('action')?>
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu">

												<?php if($invoice->status == "paid"): ?>
												<!-- view -->
												<li>
													<a target="_blank" href="<?=$invoice->invoice_url?>">
														<?=lang('view invoice')?>
													</a>
												</li>
												<?php endif;?>
												<!-- View Vendor Invoice -->
												<?php if($invoice->requires_vendor_invoice == 1 && !empty($invoice->vendor_invoice)):?>
													<li>
														<a  target="_blank" href="<?=base_url('upload/invoices/'.$invoice->vendor_invoice)?>">
															<?=lang('view vendor invoice')?>
														</a>
													</li>
												<?php endif;?>
												
												<?php if($invoice->status == "open" && $invoice->pay_status == "approved"): ?>
												<!-- pay -->
												<li>
													<a href="<?=($invoice->status == 'open' && $invoice->pay_status == "approved")? base_url('admin/invoices/pay_invoice'.'/'.$invoice->id):"javascript:void(0)"?>">
														<?=lang('pay invoice')?>
													</a>
												</li>
												
												<!-- void -->
												<li>
													<a onclick="return confirm('Are you sure?')"href="<?=($invoice->status == 'open')?base_url('admin/invoices/void_invoice'.'/'.$invoice->id):"javascript:void(0)"?>">
														<?=lang('void invoice')?>
													</a>
												</li>
											<?php endif;?>

											<?php if($invoice->status == "open" || $invoice->status == "processing"): ?>
												<!-- recreate -->
												<li>
													<a onclick="return confirm('Are you sure, you want to re-create this invoice?')"href="<?=($invoice->status == 'open' || $invoice->status == 'processing')?base_url('admin/invoices/recreate'.'/'.$invoice->id):"javascript:void(0)"?>">
														<?=lang('re-create invoice')?>
													</a>
												</li>
											<?php endif;?>
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
		// $('.dataTable').dataTable();
		$('.dataTable').DataTable({
			order: [[10, 'desc']],
		});
	});
</script>