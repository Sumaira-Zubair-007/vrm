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
								<th><?=lang('work_order_no')?></th>
								<th><?=lang('payment_id')?></th>
								<th><?=lang('amount')?></th>
								<th><?=lang('status')?></th>
								<th><?=lang('created_at')?></th>
								
							</tr>
						</thead>
						<tbody>
							<?php foreach($payments as $key => $payment):?>
								<tr>
									<td><?=$key + 1 ?></td>
									<td><?=$payment->building_no ?></td>
									<td><?=$payment->order_no ?></td>
									<td><?=$payment->payment_id ?></td>
									<td><?=$payment->amount.' '.$payment->currency ?></td>
									<td>
										<small class="label <?=$payment->status == 'succeeded' ? ( 'bg-green' ) : ( $payment->status == 'canceled' ? ( 'bg-red' ) : ( 'bg-blue' ) )?>">
											<?=$payment->status ?>
										</small>
										
									</td>
									<td><?=date('Y-m-d H:i:s',strtotime($payment->created_at))?></td>
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