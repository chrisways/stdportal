<<<<<<< HEAD
<?php session_start(); 
$txn_ref = 'NBTS'.time();

if(isset($_SESSION['matric']))
{
	$cust_id = $_SESSION['matric'];
	$customerName = $_SESSION['stname'];
	$product_id = 1;
	$pay_item_id = 1;	
	$site_redirect_url = "http://localhost/webpaydirect/redirect4.php";
	
	$_SESSION['page'] = 'paytuition.php';
 ?>
<?php
include("dbcon.php");
//$tamount = 0;
?>

<!DOCTYPE HTML>

<html>

<head>

<title>NBTS</title>

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src="edozzier/js/digit2words.js"></script>
<script>
function calculatecharges(pamount)
{
	
	amtwords = toWords(pamount);
	amtwords += " naira";
	amtwords = "Amount in Words :"+ amtwords;
	document.getElementById("inwords").textContent = amtwords;
	
	
		
}
function checkamt()
{	
	
 <?php $getdefval = mysqli_query($con,"select installments from ac_defaults_tb ");
	while($gdf = mysqli_fetch_array($getdefval))
	{
		
		$val = $gdf['installments'];	
	}
	?>
	var per =<?php echo $val ?>;
	var amtp = document.getElementById("pamount").value;
	var tamt = document.getElementById("tamount").value;
	var cper = tamt*per/100;
	var paid = document.getElementById("apaid").value;
	
	if(per > 10)
	{
		if(paid < 1)
		{
			
			if(amtp < cper)
			{
				alert("You cannot pay less than "+per+" percent of your first installment");
				return false;
				//document.getElementById("f1").preventDefault();//f1.preventDefault();	
			}
		}
		else
		{
			cper = 100 - per;
			cper = tamt*per/100;
			if(amtp < cper)
			{
				alert("You have to pay the remaining amount of your fee.");
				return false;
				//document.getElementById("f1").preventDefault();//f1.preventDefault();	
			}	
		}
	}
}
</script>

</head>

<body class="cbp-spmenu-push">
	<div class="main-content" style="padding:2%;">
    <div class="panel panel-widget">

     <div class="content-top">

			<div class="wrap">

				 

				<div class="section group">

				 <div class="col span_2_of_contact">

				  <div class="contact-form"><fieldset><legend></legend>

				  <h3 class="form-section-title"><tr><td width="30%"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

				  <td>School Fee Bill</td></tr></h3><div class="control-group"></div><div class="control-group">

				    <div class="controls"><span class="help-block">For any other payment apart from the reqular school fee payment please use the 'other payment' link.<br /><marquee scrollamount="3"><font size = 2 color=red>Please note that this system will only be fully functional by next session. Manual process is still allowed for now. If you are having issues using this please contact the ict office on 08062444583 or send a mail to ict@nbts.edu.ng</font></marquee>

			        </span></div></div>

				  <div class="controls">
					<form action="otherpayments2.php" method="post" form="f1" onSubmit="return checkamt()">
                  <table width="100%"><tr><th width="5%">#</th><th >Service or Product Description</th><th></th><th>Amount (N)</th></tr>
                  <?php 
				  $matric = $_SESSION['matric'];
				  $cid = $_SESSION['cdid'];
				 
				  $loaddesc = mysqli_query($con,"select inv_id from invoice_tb where student_id = $matric and session_id = (select session_id from session_tb where status = 2)");
				  $index = 0;
				  $bcharges =0;
while($ld = mysqli_fetch_array($loaddesc))
{
		
	$inv_id = $ld['inv_id'];
	$invs = mysqli_query($con,"select id.description,id.amount from invoice_tb i join invoice_detail_tb id using(inv_id) where inv_id =".$inv_id);
	$tamount = 0;
	while($f = mysqli_fetch_array($invs))
	{
		
		if($_SESSION['gender'] == 'male' && $f['description'] == 'Comprehensive Medical test for new stud')
		{
			
		}
		else
		{
						
			$amount = $f['amount'];
			$tamount = $tamount + $amount;
			$desc = $f['description'];
			$pdesc = $desc;
			$d = date('Y-m-d');
			//$acid = $f['ac_id'];
			if($amount <> 0)
			{
				$index++;
			?>
			<tr valign="top"><td><?php echo $index ?>.</td><td align="left"><?php echo $desc; ?></td><td><?php echo $amount; ?></td></tr>
			<?php
			/*mysqli_query($con,"insert into invoice_detail_tb (description,amount,inv_id) values ('$f[title]',$amount,$inv_id)");
				
				mysqli_query($con,"insert into journal_tb (Description,credit,date,ac_id) values ('income from {$desc}',$amount,'$d',$acid)");
			*/
			}
			
		}
		
	}
	
}
	$amount = $tamount;

$charges = $amount * 0.015;
	$bcharges += $charges;
	$charges = $charges * 0.015;
	$bcharges += $charges;
	$charges = $charges * 0.015;
	$bcharges += $charges;
	$charges = $charges * 0.015;
	$bcharges += $charges;
	$charges = $charges * 0.015;
	$bcharges += $charges;
	$charges = $charges * 0.015;
	$bcharges += $charges;
	$charges = $charges * 0.015;
	$bcharges += $charges;
	if($bcharges > 2000)
	$bcharges = 2000;
	$amt = $amount + $bcharges;
	$amt = round($amt,2);	
	$bcharges = round($bcharges,2);
	//final charges
	$tamount = $tamount + $bcharges;	
	
	//calculate payment
	$payment = mysqli_query($con,"select v.inv_id inv_id,v.inv_date inv_date,sum(p.amount_paid) amount_paid,p.pay_date from invoice_tb v left outer join payment_tb p using (inv_id) where inv_id =$inv_id");
			
			while($p = mysqli_fetch_array($payment))
			{
				$apaid = $p['amount_paid'];	
			}
			$arem = $tamount - $apaid;	  
	 ?>
                  
<tr><td></td><td>Bank Charges</td><td align="left"><?php echo $bcharges; ?></td></tr>
<tr><td></td><td><strong>Total Amount</strong></td><td align="left"><strong><?php echo $tamount; ?></strong>
<!-- from here -->
<input name="product_id" type="hidden" value="<?php echo $product_id; ?>" />
    <input name="pay_item_id" type="hidden" value="<?php echo $pay_item_id; ?>" />
    <input name="amount" type="text" value="<?php echo $amount ?>" />
    <input name="currency" type="hidden" value="566" />
    <!-- <input name="site_redirect_url" type="hidden" value="http://localhost/demopay4/redirect4.php" /> -->
    <input name="site_redirect_url" type="hidden" value="<?php echo $site_redirect_url; ?>" />
    <input name="txn_ref" type="hidden" value="<?php echo $txn_ref; ?>" />
    <input name="cust_id" type="hidden" value="<?php echo $cust_id; ?>"/>
    <input name="site_name" type="hidden" value=""/>
    <input name="cust_name" type="hidden" value="<?php echo $customerName; ?>" />
    <input name="hash" type="hidden" id="hash" value="<?php echo $hash;  ?>" />
<!-- to this place -->

</td></tr>
<tr><td></td><td><i>Amount Paid</i></td><td align="left"><i><?php echo $apaid ?></i></td></tr>
<tr><td></td><td><strong>Amount Due</strong></td><td align="left"><strong><?php echo $arem ?></strong></td></tr>
<tr><td></td><td><strong>Amount Paying</strong></td><td align="left"><input type="text" name="pamount" id="pamount" value="<?php echo $arem ?>" /></td></tr>
<tr><td></td><td align="left"><u><div id='inwords'>Amount in Words :</div> </u></td></tr>
<tr><td colspan="4">

<input type="submit" value="Proceed to Payment Page" name="paybutton" id="paybutton" />

</td></tr>

                 

                  </table>
				  </fieldset></form>

            

                  </div></div>


				 <div class="clear"></div>

			  </div>

			</div>

	

   
<script>
calculatecharges(<?php echo $arem ?>);
</script>
</body>

</html>

<?php } ?>
            