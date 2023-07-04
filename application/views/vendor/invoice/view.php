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

			
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title"><?=lang('pay_invoice')?></h3>
					<a href="<?=base_url('vendor/invoices/')?>" class="btn btn-primary pull-right">
						<i class="fa fa-arrow-left"></i> <?=lang('back')?> 
					</a>
				</div>
				<!-- /.box-header -->
				<?=form_open_multipart('vendor/invoices/process_invoice',['class'=>'form-horizontal']) ?>
				<input type="hidden" name="invoice_id" value="<?=$invoice->id?>" required>
				
				<div class="box-body">
					<!-- error alert-->
					<div class="errors"></div>
					<!-- end to error alert -->

					<div class="row">

						<div class="col-xs-6">
							<p class="lead">Payment Methods:</p>
							<img src="<?=base_url("assets/dist/img/credit/visa.png")?>" alt="Visa">
							<img src="<?=base_url("assets/dist/img/credit/mastercard.png")?>" alt="Mastercard">
							<img src="<?=base_url("assets/dist/img/credit/american-express.png")?>" alt="American Express">
							<img src="<?=base_url("assets/dist/img/credit/paypal2.png")?>" alt="Paypal">
							<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
								Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
								dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
							</p>
						</div>

						<div class="col-xs-6">
							<p class="lead">Amount Due</p>
							<div class="table-responsive">
								<table class="table">
									<tbody><tr>
										<th style="width:50%">Subtotal:</th>
										<td>$<?=$invoice->total_amount?></td>
									</tr>
									<tr>
										<th>Your amount</th>
										<td>$<?=$invoice->transfer_amount?></td>
									</tr>
									
									<tr>
										<th>Total:</th>
										<td>$<?=$invoice->total_amount?></td>
									</tr>
									<tr>
										<th>File:</th>
										<td>
											<input type="file" name="file" required>
										</td>
									</tr>
								</tbody></table>
							</div>
						</div>

					</div>


				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-12">
							<button type="submit" class="pull-right btn btn-success">
								<?=lang('upload_invoice')?>
							</button>
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
