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
					<a href="<?=base_url('admin/invoices/')?>" class="btn btn-primary pull-right">
						<i class="fa fa-arrow-left"></i> <?=lang('back')?> 
					</a>
				</div>
				<!-- /.box-header -->
				<?=form_open_multipart('admin/invoices/process_invoice',['class'=>'form-horizontal','novalidate'=>'novalidate']) ?>
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
										<th>Transfer amount</th>
										<td>$<?=$invoice->transfer_amount?></td>
									</tr>
									
									<tr>
										<th>Total:</th>
										<td>$<?=$invoice->total_amount?></td>
									</tr>
								</tbody></table>
							</div>

							<div class="form-group">
								<div class="col-sm-1" style="width:10px;">
									<input type="checkbox" id="chk" name="chk">
								</div>
								<div class="col-sm-11">
									<label>I agree to the <a href="<?php echo base_url()."admin/invoices/terms_conditions"; ?>">Terms and Conditions</a></lable>
								</div>
							</div>
						</div>

					</div>


				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div class="form-group">
						<div class="col-sm-12">
							<button id="linkButton" type="submit" disabled class="pull-right btn btn-success">
								<?=lang('pay_invoice')?>
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

<script>
	
	$("#chk").change(function() {
		if(this.checked) {
			// alert("checked");
			$('#linkButton').removeAttr('disabled');
		}else{
			// alert("unchecked");
			$('#linkButton').attr('disabled', true);
		}
	});
	
	$(document).ready(function(){ 
		setTimeout(function(){
        	
			if( $('#chk').is(':checked') )
			{
				$('#linkButton').removeAttr('disabled');
			}

        }, 100);
		
	});

</script>
