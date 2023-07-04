<?php require_once(__DIR__ .'../../inc/header.php');?>
<?php require_once(__DIR__ .'../../inc/top.php');?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?=$title ?>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">

		<!-- Content Header (Page header) -->
		<div class="col-xs-12">

			<div class="box box-primary">
				<div>
					<br>&nbsp;&nbsp;&nbsp;&nbsp;<b><u>Your Authorization for Debits</u></b><br>
					<ul style="all: revert; text-align: justify;">
						<li style="padding: 5px;"> By agreeing to these Terms, you authorize VRMBIM to debit the bank account specified above for any amount owed for charges arising from your use of VRMBIM’ services and/or purchase of products from VRMBIM, pursuant to VRMBIM’ website and terms, until this authorization is revoked. You may amend or cancel this authorization at any time by providing notice to VRMBIM with 30 (thirty) days notice.</li>

						<li style="padding: 5px;"> If you use VRMBIM’ services or purchase additional products periodically pursuant to VRMBIM’ terms, you authorize VRMBIM to debit your bank account periodically. Payments that fall outside of the regular debits authorized above will only be debited after your authorization is obtained.</li>

						<li style="padding: 5px;"> For purposes of these Terms, “Business Day” means Monday through Friday, excluding federal banking holidays.
					</ul>
				</div>
				
				<!-- /.box-body -->
				<div style="border:0px solid #ccc; height:20px;"></div>
				<div class="box-footer" style="">
					<a href="JavaScript: history.back();" class="btn btn-primary">
						<i class="fa fa-arrow-left"></i> <?=lang('back')?> 
					</a>
				</div>
				<!-- /.box-footer -->
				

			</div>
			
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->

<!-- /.row -->
</section>
<!-- /.content -->

<?php require_once(__DIR__ .'../../inc/footer.php');?>
