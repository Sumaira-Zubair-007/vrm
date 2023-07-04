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
		<div class="col-md-3">

			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="<?=base_url('upload/owners/'.$building->picture)?>" alt="Owner profile picture">
					<h3 class="profile-username text-center"><?=$building->name?></h3>
					<p class="text-muted text-center"><?=$building->email?></p>
				</div>

			</div>


			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">About Me</h3>
				</div>

				<div class="box-body">
					<strong><i class="fa fa-book margin-r-5"></i> Building Code</strong>
					<p class="text-muted">
						<?=$building->code?>
					</p>
					<hr>
					<strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
					<p class="text-muted"><?=$building->address?></p>
				</div>
			</div>

			<?php if(!empty($show_compliance) && $show_compliance == 1 ): ?>
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Compliance / Event</h3>
					</div>

					<div class="box-body">
						<strong><i class="fa fa-balance-scale margin-r-5"></i> RPIE</strong> 
						<hr>
						<strong><i class="fa fa-calculator margin-r-5"></i> Tax Protest</strong> 
						<hr>
						<strong><i class="fa fa-sticky-note margin-r-5"></i> DHCR registration</strong> 
						<hr>
						<strong><i class="fa fa-building-o margin-r-5"></i> HPD Registration</strong> 
						<hr> 
					</div>
				</div>
			<?php endif;?>	
		</div>

		<!--  -->

		<div class="col-md-9">

			<div class="box box-solid">
				<div class="box-body">

					<?php if(!empty($building->payment_method_id)): ?>
						<div class="box-group" id="accordion">
						   <div class="panel box box-success">
						      <div class="box-header with-border">
						         <h4 class="box-title">
						            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
							             <i class="fa fa-bank"></i>
							             <?=$building->bank_name?> **** <?=$building->account_number?>
							             <small class="label <?=$building->setup_intent_status == 'succeeded' ? ( 'bg-green' ) : ( $building->setup_intent_status == 'pending' ? ( 'bg-blue' ) : ( 'bg-red' ) )?>">
												<?=$building->setup_intent_status ?>
										</small>
						            </a>
						         </h4>
						      </div>
						      <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true">
						         <div class="box-body">
						           	<dl class="dl-horizontal">
									   <dt>ID</dt>
									   <dd><?=$building->payment_method_id?></dd>
									   <dt>Bank Name</dt>
									   <dd><?=$building->bank_name?></dd>
									   <dt>Account Number</dt>
									   <dd>**** <?=$building->account_number?></dd>
									   <dt>Fingerprint</dt>
									   <dd><?=$building->fingerprint?></dd>
									   <dt>Currency</dt>
									   <dd><?=strtoupper($building->currency)?></dd>
									</dl>
						         </div>
						      </div>
						   </div>
					
						</div>
						<!-- In case of micro deposit verification -->
						<?php if($building->setup_intent_status == "pending" || $building->setup_intent_status == "requires_action"):?>
							<a class="btn btn-info btn-block margin" href="<?=base_url('admin/buildings/bank_account_verify/'.$building->id)?>">Verify Bank</a>
						<?php endif;?>

						<?php if($building->setup_intent_status == "succeeded"):?>
							<a class="btn btn-info btn-block margin" onclick="return confirm('Are you sure, you want to delete this bank account?')"href="<?=base_url('admin/buildings/bank_account_delete'.'/'.$building->id.'/'.$building->bid)?>">
								<?=lang('Delete Bank')?>
							</a>
						<?php endif;?>
					
					<?php else: ?>
						<a class="btn btn-success btn-block margin" href="<?=base_url('admin/buildings/bank_account/'.$building->id)?>">Attach Bank</a>
					<?php endif;?>

					
				</div>

			</div>

			<!--  -->

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
								<th><?=lang('work_order_no')?></th>
								<th><?=lang('invoice_id')?></th>
								<th><?=lang('total_amount')?></th>
								<th><?=lang('total_paid')?></th>
								<th><?=lang('net_amount')?></th>
								<th><?=lang('status')?></th>
								<th><?=lang('created_at')?></th>
								<th><?=lang('action')?></th>
								
							</tr>
						</thead>
						<tbody>
							<?php foreach($invoices as $key => $invoice):?>
								<tr>
									<td><?=$key + 1 ?></td>
									<td><?=$invoice->vendor_name.'('. $invoice->vendor_email.')' ?></td>
									<td><?=$invoice->order_no ?></td>
									<td><?=$invoice->invoice_id ?></td>
									<td><?=$invoice->total_amount.' '.$invoice->currency ?></td>
									<td><?=$invoice->total_paid.' '.$invoice->currency ?></td>
									<td><?=$invoice->net_amount.' '.$invoice->currency ?></td>
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

												<!-- view -->
												<li>
													<a target="_blank" href="<?=$invoice->invoice_url?>">
														<?=lang('view invoice')?>
													</a>
												</li>
												
												<?php if($invoice->status == "open"): ?>
												<!-- pay -->
												<li>
													<a href="<?=($invoice->status == 'open')?base_url('admin/invoices/pay_invoice'.'/'.$invoice->id):"javascript:void(0)"?>">
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