<<<<<<< HEAD
<?php session_start(); 
if(isset($_SESSION['matric']))
{
$_SESSION['page'] = 'payhistory.php';
 ?>
<?php
include("dbcon.php");
if(isset($_FILES['teller']))
{
	//The code to uploade images.
		if((($_FILES["teller"]["type"] == "image/gif")
		||($_FILES["teller"]["type"] == "image/jpeg")
		||($_FILES["teller"]["type"] == "image/pjpeg")
		||($_FILES["teller"]["type"] == "image/png"))
		&&($_FILES["teller"]["size"] < 20000))
	   {
	  	 if ($_FILES["teller"]["error"] > 0)
	   	 {
	  	 	echo "Return code: ". $_FILE["teller"]["error"] . "<br/>";
	  	 }
	   	 else
	   	 {
		 if (file_exists("edozzier/teller/".$_SESSION['matric'] . $_FILES["teller"]["name"]))
		 {
			 unlink("edozzier/teller/".$_SESSION['matric'] . $_FILES["teller"]["name"]);
			 move_uploaded_file($_FILES["teller"]["tmp_name"],"edozzier/teller/".$_SESSION['matric'] . $_FILES["teller"]["name"]);
			 
			 $path ="edozzier/teller/".$_SESSION['matric'].$_FILES["teller"]["name"];
		 }
		 else
		 {
			 	
			 move_uploaded_file($_FILES["teller"]["tmp_name"],"edozzier/teller/".$_SESSION['matric'] . $_FILES["teller"]["name"]);
			 
			 $path ="edozzier/teller/".$_SESSION['matric'].$_FILES["teller"]["name"];
	     }
	   }
      }
	else
	{
		$message = "file upload failed";
	}
	//end of upload program
	$inv = $_POST['invoice'];
	$tno = $_POST['tnumber'];
	$bank = $_POST['bank'];
	$amount = $_POST['apaid'];
	$pdate = $_POST['pdate'];
	$sql = mysqli_query($con,"insert into payment_table (inv_id,teller_no,bank,amount_paid,payment_date,date_uploaded,path) values ($inv,$tno,'$bank',$amount,'$pdate',current_date(),'$path')");
	if(!$sql)
	{
		echo "Error::".mysqli_error();
	}
}

?>

<!DOCTYPE HTML>

<html>

<head>

<title>NBTS</title>

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

</head>

<body class="cbp-spmenu-push">
	<div class="main-content" style="padding:2%;">
    <div class="panel panel-widget">
				 

				<div class="section group">

				 <div class="col span_2_of_contact">

				  <div class="contact-form"><fieldset><legend></legend>

				  <h3 class="form-section-title"><tr><td width="30%"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

				  <td>Payment History</td></tr></h3><div class="control-group"></div><div class="control-group">

				    <div class="controls"><span class="help-block">History of your invoices and payments (Double Click on an invoice number to make payment.)<br /> 

			        </span></div></div>

				  <div class="controls">
					<?php 
					$matric = $_SESSION['matric'];
					$sql = mysqli_query($con,"select v.inv_id inv_id, v.amount inv_amount,v.inv_date inv_date,sum(p.amount_paid) amount_paid,p.pay_date from invoice_tb v left outer join payment_tb p using (inv_id) where student_id = $matric");?>
                  <table width="100%"><tr><th width="5%">#</th><th>Amount</th><th>Amount Due</th><th>Due Date</th><th>Status</th><th>Print/View</th></tr>

                  <?php
			while($row = mysqli_fetch_array($sql))
			{
				  $i = $row['inv_id'];

				$vdesc = mysqli_query($con,"select * from invoice_detail_tb where inv_id =$i");

				while($vd = mysqli_fetch_array($vdesc))

				{

					if($vd['amount'] <> 0)

					{

						$title .= $vd['description']." : N".$vd['amount']."\n";

							$amount += $vd['amount'];

					}

				}

				$title .= "Total : N".$amount."\n";

				//$amount = $row['inv_amount'];

				$apaid = $row['amount_paid'];

				$arem1 = $amount - $apaid;

				$arem = $arem1;

				$pdate = $row['inv_date'];
				echo "<tr align='right'><td>$i</td><td>$amount</td><td>$arem</td>";
				echo "<td>$pdate</td>";
				if($arem < $amount)

				{

					echo "<td>Partially Paid</td>";

				}

				else if($arem == 0)

				{

					echo "<td><font color=green>Paid in Full</font></td>";

				}

				else

				{

					echo "<td><font color=red>Unpaid</font></td>";

				}
				echo "<td>View/Print</td></tr>";
				
			}
			if(!$sql)
			{
				   echo "<tr><td colspan=5 align=center>No Invoices yet</td></tr>"; 
				   
			}
			?>

                  </table>
				  <form action="payhistory.php" method="post" enctype="multipart/form-data">
				  <fieldset><legend>New Payments</legend>
					<table>
					<tr><td colspan="8">&nbsp;</td></tr>
					<tr><td>Payment Date</td><td><input type="text" id="pdate" name="pdate" /></td><td>Bank</td><td><select name="bank"><option value="GTBank">GTBank</option><option value="Zenith Bank">Zenith Bank</option><option value="UBA">UBA</option></select></td><td>Teller #</td><td><input type="text" name="tnumber" /></td><td>Amount Paid:</td><td><input type="text" name="apaid" /><input type="hidden" value="5" name="invoice" /></td></tr>
                 <tr><td colspan="8"> <input type="file" placeholder="Upload" title="Click to upload a scanned payment teller" name="teller" ><input type="submit" value="Upload Payment Teller" /></td></tr></table></fieldset></form>

                  </div>

                  <h3 class="form-section-title">&nbsp;</h3><span style="display:none;" id="englishName"><div id="englishNameAlert" class="alert alert-info">Some systems cannot handle your name as you have entered it. Please enter your name using only the English alphabet in the fields below.</div><div class="control-group"><label for="englishFirstName" class="control-label">English First Name</label><div class="controls"><input id="englishFirstName" name="englishFirstName" type="text" value="" maxlength="45"/></div></div><div class="control-group"><label for="englishMiddleName" class="control-label">English Middle Name</label><div class="controls"><input id="englishMiddleName" name="englishMiddleName" type="text" value="" maxlength="25"/></div></div><div class="control-group"><label for="englishLastName" class="control-label">English Last Name</label><div class="controls"><input id="englishLastName" name="englishLastName" class="english" type="text" value="" maxlength="45"/></div></div></span><div class="form-actions"></div></fieldset></div></div>
				 <div class="clear"></div>

			  </div>

			</div>

	</div>

    <?php include('footer.php'); ?>

</body>

</html>

<?php } ?>

    	

