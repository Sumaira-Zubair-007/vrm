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

				
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table  class="table table-bordered table-striped dataTable">
						<thead>
							<tr>
								<th>#</th>
								<th><?=lang('building_no')?></th>
								<th><?=lang('building_address')?></th>
                                <th><?=lang('work_order_no')?></th>
								<th><?=lang('total_amount')?></th>
								<th><?=lang('total_paid')?></th>
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
									<td><?=$invoice->building_no ?></td>
									<td><?=$invoice->building_address ?></td>
                                    <td><?=$invoice->order_no ?></td>
									<td><?=$invoice->total_amount.' '.$invoice->currency ?></td>
									<td><?=$invoice->total_paid.' '.$invoice->currency ?></td>
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
										<?php if($invoice->requires_vendor_invoice && $invoice->status == "open"):?>
											<a class="btn btn-<?=!empty($invoice->vendor_invoice) ? "danger" : "info" ?>" href="<?=base_url('vendor/invoices/upload_invoice'.'/'.$invoice->id)?>">
												<?=!empty($invoice->vendor_invoice) ? "Re-Upload Invoice" : "Upload Invoice" ?>
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
		// $('.dataTable').dataTable();
		$('.dataTable').DataTable({
			order: [[7, 'desc']],
		});
	});
</script>