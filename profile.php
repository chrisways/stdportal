<<<<<<< HEAD
<?php
session_start();
if (isset( $_SESSION['stid'])){
	include ("dbcon.php");
	if (isset($_POST['savep']))
	{
		$mat = $_SESSION['stid'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$mname = $_POST['mname'];
		$phone1 = $_POST['phone1'];
		$phone2 = $_POST['phone2'];
		$gen = $_POST['gender'];
		$dob = $_POST['dob'];
		if ($dob == "")
		{
			$dob = date("Y-m-d");
		}
		$email = $_POST['email'];
		$state = $_POST['state'];
		$add = $_POST['address'];
		$matric = $_SESSION['stid'];
		$nat = $_POST['national'];
		$st = $_POST['state'];
		$nphone = $_POST['nphone'];
		$mstatus = $_POST['mstatus'];
		$nemail = $_POST['nemail'];
		$nfname = $_POST['nfname'];
	
	//DATE_SUB('$dob',INTERVAL 40 YEAR)
	
		$ins = mysqli_query($con,"update student_table set firstname = '$fname',lastname = '$lname', middlename = '$mname',phone_1 = '$phone1',phone_2 = '$phone2',email = '$email',state_of_origin = '$state',date_of_birth ='$dob' ,gender = '$gen',address = '$add',nationality = '$nat',marital_status='$mstatus',rfullname_1 = '$nfname',rphone1_1 = '$nphone',remail_1 = '$nemail' where student_id = $matric");
	if ($ins){
		echo "
		<script>
			alert ('Profile Updated');
		</script>
		";
		}
		else{
				$e = mysqli_error($con);
		echo "
		<script>
			alert ('Profile Update Failed $e');
		</script>
		";	
		}
		
	}
	if (isset($_POST['imgsub'])){
		if((($_FILES["imgfile"]["type"] == "image/gif")
		||($_FILES["imgfile"]["type"] == "image/jpeg")
		||($_FILES["imgfile"]["type"] == "image/pjpeg")
		||($_FILES["imgfile"]["type"] == "image/png"))
		&&($_FILES["imgfile"]["size"] < 50000))
	   {
	  	 if ($_FILES["imgfile"]["error"] > 0)
	   	 {
			 $er = $_FILE["imgfile"]["error"];
	  	 }
	   	 else
	   	 {
		 if (file_exists("../edozzier/upload/".$_SESSION['stid'].$_FILES["imgfile"]["name"]))
		 {
			 unlink("../edozzier/upload/".$_SESSION['stid'] .$_FILES["imgfile"]["name"]);
			 move_uploaded_file($_FILES["imgfile"]["tmp_name"],"../edozzier/upload/".$_SESSION['stid'].$_FILES["imgfile"]["name"]);
			 
			 $path ="upload/".$_SESSION['stid'].$_FILES["imgfile"]["name"];
		 }
		 else
		 {
			 	
			 move_uploaded_file($_FILES["imgfile"]["tmp_name"],"../edozzier/upload/".$_SESSION['stid'].$_FILES["imgfile"]["name"]);
			 
			 $path ="upload/".$_SESSION['stid'].$_FILES["imgfile"]["name"];
			 
	     }
	   }
	$imgup = mysqli_query($con,"update student_table set passport = '$path' where student_id =".$_SESSION['stid']);
	$_SESSION['stphoto'] = "../edozzier/".$path;
	if ($imgup){
		echo "
			<script>
				alert ('Image Updated');
			</script>
			";
	}
	else{
		echo "
			<script>
				alert ('Image Update Failed');
			</script>
			";
	}
      }
	else
	{
		$message = "Invalid file size or extension. No picture uploaded";
		echo "
			<script>
				alert ('$message');
			</script>
			";
		
	}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Student Profile | NBTS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<link rel="icon" href="favicon.ico" type="image/x-icon" >
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- chart -->
<script src="js/Chart.js"></script>
<!-- //chart -->
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<style>
	input,select { width:80%;
					height:30px;
					margin:2%; border:0px; color:green;}
	.dis {  background:#FFF;}
	._header{
		width:100%;
		border-bottom: solid 1px #008000;
		height: 90px;
	}
	._header img{
		
	}
	
	._header h3{
		float:left;
		width: 80%;
		color:#008000;
	}
	div#pass{
		float: right;
		width:20%;
		text-align: right;
	}
	input[type='button']{
		border:solid 1px #008000;
		background:none;
		transition:background 1s;
	}
	input[type='button']:hover{
		background-color: #008000;
		color:#fff;
	}
</style>
<script>
	$(document).ready(function() {
    $(".dis").attr("disabled",true);
	$("#save, #imgbtn, #imgsub").hide();
	$("#edit").click(function(){
		$(".dis").removeAttr("disabled");
		$("#save").show();
	});
	$("#chgimg").click(function(){
		$("#imgbtn, #imgsub").show();
	});
	
});

</script>

<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content" style="padding:2%;">
					<div class="progressbar-heading grids-heading">
					</div>
					<div class="panel panel-widget">
						<div class="block-page">
							<?php 
								 $select = mysqli_query($con,"select * from student_table where student_id =".$_SESSION['stid']);
								  while($st = mysqli_fetch_array($select))
								  {
									$fname = $st['firstname'];
									$lname = $st['lastname'];
									$mname = $st['middlename'];
									$p1 = $st['phone_1'];
									$p2 = $st['phone_2'];
									$em = $st['email'];
									$dob = $st['date_of_birth'];
									$add = $st['address'];
									$national = $st['nationality'];
									$gender = $st['gender'];
									$state = $st['state_of_origin'];
									$mstatus = $st['marital_status'];
									$nphone = $st['rphone1_1'];
									$nfname = $st['rfullname_1'];
									$nemail = $st['remail_1'];
								  }
							?>
                            
							<div class="contact-form">
							<div class="_header">
								<h3>Profile Page</h3>
								<div id="pass">
									<img src="<?php $stphoto = (isset($_SESSION['stphoto']))?$_SESSION['stphoto']:'images/placeholder.png'; echo $stphoto; ?>" width="80" height="80" class="img-circle img-responsive" />
								</div>
							</div>
							<?php //echo $_SESSION['stphoto'] ?>
<!--
				 <tr><td width="30%"></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				  <td><b style="color:green; font-size:20px;">Profile Page</b></td></tr>
-->
                  
                 
                 <span class="help-block"> 
                 <p>
                  <div style="float:right;width: 100%;text-align: right;">
                  <span>Max Size : 40kb</span>
                   <input type="button" name="button2" id="chgimg" style="width:15%; margin:0px;" value="Change Image">
					 
                   <form method="post" action="profile.php" enctype="multipart/form-data" id="imgform">
                   <input type="file" name="imgfile" id="imgbtn" style="width:15%; margin:0px;" value="Change Image">
                   <input type="submit" name="imgsub" id="imgsub" style="width:10%; margin:1px;" /></form>
					 </div>
                   <form id="form1" action="profile.php" class="form-horizontal" method="POST" style="color:green;clear:both;"><fieldset>
                 <table width="100%"><tr align="left"><th colspan="2">           
Personal Information</th><th colspan="2">Contact Information</th></tr><tr><td width="20%">           
Surname:</td><td width="28%"><input type="text" name="lname"  value="<?php echo $lname; ?>" id="lname" class="dis" ></td><td width="18%">Phone 1</td><td width="23%"><input type="text" value="<?php echo $p1; ?>" id="phone1" class="dis" name="phone1" ></td></tr>
<tr><td>           
Firstname:</td><td><input type="text" name="fname" id="fname" value="<?php echo $fname; ?>" class="dis" ></td><td>Phone 2</td><td><input type="text" name="phone2" id="phone2" value="<?php echo $p2; ?>" class="dis" ></td></tr>
<tr><td>           
Middlename:</td><td><input id="mname" name="mname" type="text" value="<?php echo $mname; ?>" class="dis" ></td><td>e-mail</td><td><input type="text" id="email" name="email" value="<?php echo $em; ?>" class="dis" ></td></tr>
<tr><td>           
Date of Birth:</td>
<td><input type="text" id="dob" name="dob" title="Format: 1990-10-10" placeholder="<?php echo $dob; ?>" class="dis" value="<?php echo $dob; ?>"  /></td><td>Address</td><td><input type="text" id="address" name="address" value="<?php echo $add ?>"></td></tr>
<tr><td>           
Nationality:</td><td><div class="controls"><select id="national" name="national" class="dis" >
	                     <option value="<?php echo $national ?>"><?php echo $national ?></option>
						 <option value="Algeria">Algeria</option>
	                     <option value="Angola">Angola</option>
	                     <option value="Ascension Island">Ascension Island</option>
	                     <option value="Argentina">Argentina</option>
	                     <option value="Australia">Australia</option>
	                     <option value="Austria">Austria</option>
	                     <option value="Belgium">Belgium</option>
	                     <option value="Benin">Benin</option>
	                     <option value="Botswana">Botswana</option>
	                     <option value="Brazil">Brazil</option>
	                     <option value="Burkina Faso">Burkina Faso</option>
	                     <option value="Cameroon">Cameroon</option>
	                     <option value="Canada">Canada</option>
	                     <option value="Cape Verde Island">Cape Verde Island</option>
	                     <option value="Central African Rep">Central African Rep</option>
	                     <option value="Congo">Congo</option>
	                     <option value="Cote Divoire">Cote Divoire</option>
	                     <option value="Cyprus">Cyprus</option>
	                     <option value="Demark">Demark</option>
	                     <option value="Djibouti">Djibouti</option>
	                     <option value="Egypt">Egypt</option>
	                     <option value="Equatoria Guinea">Equatoria Guinea</option>
	                     <option value="Ethiopia">Ethiopia</option>
	                     <option value="Finland">Finland</option>
	                     <option value="France">France </option>
	                     <option value="Gabon">Gabon</option>
	                     <option value="Gambia">Gambia</option>
	                     <option value="German Federal Rep">German Federal Rep</option>
	                     <option value="Ghana">Ghana</option>
	                     <option value="Greece">Greece</option>
	                     <option value="Guinea Bissau">Guinea Bissau</option>
	                     <option value="Hong Kong">Hong Kong</option>
	                     <option value="India">India</option>
	                     <option value="Italy">Italy</option>
	                     <option value="Japan">Japan</option>
	                     <option value="Kenya">Kenya</option>
	                     <option value="Lebanon">Lebanon</option>
	                     <option value="Lesotho">Lesotho</option>
	                     <option value="Liberia">Liberia</option>
	                     <option value="Libya">Libya</option>
	                     <option value="Luxemboourg">Luxembourg</option>
	                     <option value="Madagagscar">Madagagscar</option>
	                     <option value="Malawi">Malawi</option>
	                     <option value="Mali">Mali</option>
	                     <option value="Mauritania">Mauritania</option>
	                     <option value="Maritius">Maritius</option>
	                     <option value="Morocco">Morocco</option>
	                     <option value="Mozambique">Mozambique</option>
	                     <option value="Nethelands">Nethelands</option>
	                     <option value="New Zealand">New zealand</option>
	                     <option value="Norway">Norway</option>
	                     <option value="Niger">Niger</option>
	                     <option value="Nigeria">Nigeria</option>
	                     <option value="Phillipine">Phillippine</option>
	                     <option value="Portugal">Portugal</option>
	                     <option value="Rwanda">Rwanda</option>
	                     <option value="Sao Tme&amp; Principle">Sao Tme&amp; Principle</option>
	                     <option value="Senegal">Senegal</option>
	                     <option value="Seychelles">Seychelles</option>
	                     <option value="Sierra-Leone">Sierra-Leone</option>
	                     <option value="South Africa">South Africa</option>
	                     <option value="Spain">Spain</option>
	                     <option value="Sudan">Sudan</option>
	                     <option value="Sweden">Sweden</option>
	                     <option value="Switzerland">Switzerland</option>
	                     <option value="Swaziland">Swaziland</option>
	                     <option value="Syria">Syria</option>
	                     <option value="Tanzania">Tanzania</option>
	                     <option value="Togo">Togo</option>
	                     <option value="Tunisia">Tunsia</option>
	                     <option value="Uganda">Uganda</option>
	                     <option value="United Kingdom">United Kingdom</option>
	                     <option value="United States of America">United States of America</option>
	                     <option value="United Arab Emirates">United Arab Emirates</option>
	                     <option value="Zaire">Zaire</option>
	                     <option value="Zambia">Zambia</option>
	                     <option value="Zimbabwe">Zimbabwe</option>
                       </select></div></td><th colspan="2" align="left">Next of Kin Contact Information</th></tr>
<tr>
  <td>State of Origin(for Nigerians):</td><td><select name="state" id="state" class="dis" >
                      <option value="<?php echo $state ?>"><?php echo $state ?></option>
					 	
					  <option value="Abia">Abia</option>
					  <option value="Adamawa">Adamawa</option>
					  <option value="Akwa Ibom">Akwa Ibom</option>
					  <option value="Anambra">Anambra</option>
					  <option value="Bauchi">Bauchi</option>
					  <option value="Bayelsa">Bayelsa</option>
					  <option value="Benue">Benue</option>
					  <option value="Borno">Borno</option>
					  <option value="Cross River">Cross River</option>
					  <option value="Delta">Delta</option>
					  <option value="Ebonyi">Ebonyi</option>
					  <option value="Edo">Edo</option>
					  <option value="Ekiti">Ekiti</option>
					  <option value="Enugu">Enugu</option>
					  <option value="Gombe">Gombe</option>
					  <option value="Imo">Imo</option>
					  <option value="Jigawa">Jigawa</option>
					  <option value="Kaduna">Kaduna</option>
					  <option value="Kano">Kano</option>
					  <option value="Katsina">Katsina</option>
					  <option value="Kebbi">Kebbi</option>
					  <option value="Kogi">Kogi</option>
					  <option value="Kwara">Kwara</option>
					  <option value="Lagos">Lagos</option>
					  <option value="Nasarawa">Nasarawa</option>
					  <option value="Niger">Niger</option>
					  <option value="Ogun">Ogun</option>
					  <option value="Ondo">Ondo</option>
					  <option value="Osun">Osun</option>
					  <option value="Oyo">Oyo</option>
					  <option value="Plateau">Plateau</option>
					  <option value="Rivers">Rivers</option>
					  <option value="Sokoto">Sokoto</option>
					  <option value="Taraba">Taraba</option>
					  <option value="Yobe">Zamfara</option>
					  <option value="FCT Abuja">FCT Abuja</option>
                      </select></td><td>Full Name:</td><td><input type="text" name="nfname" id="nfname" value="<?php echo $nfname; ?>" class="dis" ></td></tr>
					  <tr><td>Gender</td><td><select name="gender" id="gender" class="dis" ><option value="">Select--gender</option><?php if($gender <> 'Male'){?><option value="Male">Male</option><?php } else{ ?><option value="Male" selected>Male</option><?php } ?><?php if($gender <> 'Female'){?><option value="Female">Female</option><?php }else{ ?><option value="Female" selected>Female</option><?php } ?></select></td><td>Office Phone</td><td><input type="text" name="nphone" id="nphone" value="<?php echo $nphone; ?>" class="dis" ></td></tr>
					  
					  <tr><td>Marital Status:</td><td><select name="mstatus" id="mstatus" value="<?php echo $mstatus; ?>" class="dis" ><option value="">Select--Status</option><?php if($mstatus <> 'Single'){?><option value="Single">Single</option><?php } else{ ?><option value="Single" selected>Single</option><?php } ?><?php if($mstatus <> 'Married'){?><option value="Married">Married</option><?php }else{ ?><option value="Married" selected>Married</option><?php } ?></select></td><td>Email</td><td><input type="text" name="nemail" id="nemail" value="<?php echo $nemail; ?>" class="dis" ></td></tr>
  <tr>
  <td colspan="3" align="center" valign="top"><input type="submit" name="savep" id="save" value="Save Information" /></td><td align="right" valign="bottom"><input type="button" name="button" value="Edit" id="edit" />  </td></tr>
</table>

</span>
                  
                  
                  
					</div>
				</div>
				<!--//grids-->
				
			</div>
 	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!-- Bootstrap Core JavaScript --> 
		
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

        <script type="text/javascript" src="js/dev-loaders.js"></script>
        <script type="text/javascript" src="js/dev-layout-default.js"></script>
		<script type="text/javascript" src="js/jquery.marquee.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<script type="text/javascript" src="js/jquery.jqcandlestick.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jqcandlestick.css" />
		
		<!--max-plugin-->
		<script type="text/javascript" src="js/plugins.js"></script>
		<!--//max-plugin-->
		
		<!--scrolling js-->
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<!--//scrolling js-->
</body>
</html>
<?php
}
else{
	echo "
	<script>
		alert ('Access Denied');
		alert ('You need to Login First');
			window.location='../studentlogin.php';
	</script>
	";
	
}

?>