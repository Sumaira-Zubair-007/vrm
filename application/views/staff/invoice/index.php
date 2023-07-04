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
					<a href="<?=base_url('staff/invoices/add')?>" class="btn btn-info pull-right">
						<i class="fa fa-plus"></i> <?=lang('add_invoice')?>
					</a>				
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table  class="table table-bordered table-striped dataTable">
						<thead>
							<tr>
								<th>#</th>
								<th><?=lang('building_no')?></th>
                                <th><?=lang('work_order_no')?></th>
								<th><?=lang('invoice_id')?></th>
								<th><?=lang('total_amount')?></th>
								<th><?=lang('total_paid')?></th>
								<th><?=lang('status')?></th>
								<th><?=lang('created_at')?></th>
								<th><?=lang('action')?></th>
								
							</tr>
						</thead>
						<tbody>
							<?php foreach($invoices as $key => $invoice):?>
								<tr>
									<td><?=$key + 1 ?></td>
									<td><?=$invoice->building_no ?></td>
                                    <td><?=$invoice->order_no ?></td>
									<td><?=$invoice->invoice_id ?></td>
									<td><?=$invoice->total_amount.' '.$invoice->currency ?></td>
									<td><?=$invoice->total_paid.' '.$invoice->currency ?></td>
									<td>
										<small class="label <?=$invoice->status == 'paid' ? ( 'bg-green' ) : ( $invoice->status == 'open' ? ( 'bg-blue' ) : ( 'bg-red' ) )?>">
											<?=$invoice->status ?>
										</small>
										
									</td>
									<td><?=date('Y-m-d H:i:s',strtotime($invoice->created_at))?></td>
									<td>
										<?php if($invoice->can_staff_pay && $invoice->status == "open"):?>
											<a class="btn btn-info" href="<?=($invoice->status == 'open')? base_url('staff/invoices/pay_invoice'.'/'.$invoice->id):"javascript:void(0)"?>">
												<?=lang('pay invoice')?>
											</a>
										<?php endif;?>

										<?php if($invoice->requires_vendor_invoice == 1 && !empty($invoice->vendor_invoice)):?>
											<a class="btn btn-primary" target="_blank" href="<?=base_url('upload/invoices/'.$invoice->vendor_invoice)?>">
												<?=lang('view vendor invoice')?>
											</a>
										<?php endif;?>
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