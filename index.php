<?php include('leftbar.php'); ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">	
				<div class="panel-heading">
					<div class="row"><div class="col-lg-10">
					<h4>Sales Invoice Entry</h4></div><div class="col-lg-2">	<a href="record.php" class="btn btn-info" role="button">Records</a></div></div>
					</div> 
					<div class="panel-body">
						<form class="form-horizontal" id="form" method="post" action="database.php">
							<div class="row">
								<div class="col-lg-9">
									<div class="row">
										<div class="col-lg-8">
											<table class="table">
											<tr>
												<td><label class="control-label" for="email">
												To :
											</label></td><td>
											<input type="text" name="name" class="form-control" value=""/></td>
										</tr>
											<tr><td><label class="control-label" for="email">Address :</label></td>
											<td><input type="text" name="address" class="form-control" value=""/></td>
										</tr>
											<tr><td><label class="control-label" for="email">
												GST NO.
											</label></td><td>
											<input type="text" name="gstNo" class="form-control" value=""/></td>
										</tr>
										</table>
										</div>

										<div class="col-lg-4">
											<table class="table"><tr><td>
											<label class="control-label" for="email">
												Bill_No:
											</label></td>
											<td><input type="text" name="billNo" class="form-control" value=""/></td>
										</tr>
										<tr><td>
											<label class="control-label" for="email">Date : </label></td><td>
											<input type="date" name="billDate" class="form-control" value="<?php echo date('Y-m-d'); ?>"/></td></tr>
										</table>
										</div>

									</div>
								</div>
							</div>
									<br>
									<div class="row">
										<div class="col-lg-8">
											<table class="table table-bordered transaction">

												<tr>
													<th width="5%">No</th>
													<th width="60%">Item Name</th>
													<th width="10%">HSN CODE</th>
													<th width="5%">Quantity</th>
													<th width="10%">RATE</th>
													<th width="10%">AMOUNT</th>
												</tr>
												<?php for ($i=1; $i <=6 ; $i++) { 
													echo '<tr>
													<th>'.$i.'</th>
													<td><input type="text" name="item'.$i.'" class="form-control"/></td>
													<td><input type="text" name="hsn'.$i.'" class="form-control" value="0"/></td>
													<td><input type="text" name="qty'.$i.'" class="form-control qty" value="0"/></td>
													<td><input type="text" name="rate'.$i.'" class="form-control rate" value="0"/></td>
													<td><input type="text" name="amt'.$i.'" class="form-control amount" value="0"/></td>
												</tr>';	# code...
												}
												?>
											</table>
										</div>
									<div class="col-lg-4">
									<table class="table table-bordered transaction" id="transaction" style="font-size: 18px">
										<tr>
											<th>
												<label class="control-label">Total</label>
											</th>
											<td></td>
											<td>
												<input id="netAmount" type="text" name="netTotal" class="form-control"/>
											</td>
										</tr>
										<tr><th>
											<label class="control-label">CGST</label>
										</th>
										<td><input id="cgstPercent" type="text" name="cgstPercent" class="form-control" value="0"/></td>
										<td>	
											<input id="cgstAmt" type="text" name="cgstAmt" class="form-control" value="0"/>
										</td>
									</tr>
									<tr>
										<td>
											<label class="control-label">SGST</label>
										</td>
										<td>
											<input id="sgstPercent" type="text" name="sgstPercent" class="form-control" value ="0"/>
										</td>
										<td>
											<input id="sgstAmt" type="text" name="sgstAmt" class="form-control" value="0"/>
										</td>
									</tr>
									<tr>
										<td>
											<label class="control-label">IGST</label>
										</td>
										<td>
											<input id="igstPercent" type="text" name="igstPercent" class="form-control" value = "0"/>
										</td>
										<td>
											<input id="igstAmt" type="text" name="igstAmt" class="form-control" value="0"/>
										</td>
									</tr>
									<tr>
										<td>
											<label class="control-label">Grand Total</label>
										</td>
										<td></td>
										<td>
											<input id="grossTotal" type="text" name="grossTotal" class="form-control"/>
										</td>
									</tr>
								</table>
								<input class="btn btn-success" type="submit" name="submit" value="Save & Print"/>
								<input class="btn" type="reset" name="reset" value="Reset"/>
							</div>
						</div>	
						
						
				</form>
			
		
	</div>
</div>
</div>
</div>


<?php include('footer.php');?>
<script>
	
	$(document).ready(function() {

		var count = 1;
		var netAmount = 0;
		var amount = 1;
		var rate = 1;

		$('#dataTables-example').DataTable({
			responsive: true
		});
		
		$(".rate").change(function(){
			if ($(this).parent().parent().find(".qty").val() > 0) {
			var qty=$(this).parent().parent().find(".qty").val();
			console.log(qty);
			
			var amount = parseFloat(qty) * parseFloat($(this).val());
			netAmount = netAmount - 	$(this).parent().parent().find(".amount").val();
			$(this).parent().parent().find(".amount").val(amount.toFixed(2));
			netAmount = netAmount + amount;
			$("#netAmount").val(netAmount.toFixed(2));	
		}
		});
		$(".qty").change(function(){
			if ($(this).parent().parent().find(".rate").val() > 0) {
 				var rate=$(this).parent().parent().find(".rate").val();
			console.log(rate);
			netAmount = netAmount - 	$(this).parent().parent().find(".amount").val();
			var amount = parseFloat(rate) * parseFloat($(this).val());
			$(this).parent().parent().find(".amount").val(amount.toFixed(2));
			netAmount = netAmount + amount;
			$("#netAmount").val(netAmount.toFixed(2));	 			
			}
		});
		$("#cgstPercent").change(function(){
			console.log($(this).val());
			var cgst = $('#netAmount').val() * $(this).val()/100;  
			$("#cgstAmt").val(cgst.toFixed(2));
			$("#sgstAmt").val(cgst.toFixed(2));
			$("#sgstPercent").val($(this).val());
			var grossTotal = parseFloat($('#netAmount').val()) + parseFloat($('#cgstAmt').val()) + parseFloat($('#sgstAmt').val());
			gtot = grossTotal.toFixed(2);	
			$('#grossTotal').val(grossTotal.toFixed(2));
			console.log(cgst);

		});
		$("#igstPercent").change(function(){
			var igst = $('#netAmount').val() * $(this).val()/100;  
			$("#igstAmt").val(igst.toFixed(2));
			var grossTotal = parseFloat($('#netAmount').val()) + parseFloat($('#igstAmt').val());
			gtot = grossTotal.toFixed(2);	
			$('#grossTotal').val(grossTotal.toFixed(2));
			console.log(cgst);
		});
		/*$(".amount").keyup(function(){
			netAmount = parseInt(netAmount) + parseInt($(this).val());
			$("#netAmount").val(netAmount);	

		});*/
	});
</script>
