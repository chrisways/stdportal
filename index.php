<?php
	session_start();
	include('dbcon.php');
	
	$session = mysqli_query($con,"select session_id,session_year,comment,term_tb.term from session_tb join term_tb using(session_id) where status = 2 and CURRENT_DATE BETWEEN begins and ends");
	$company = mysqli_query($con,"select * from company_tb");
	while($ses = mysqli_fetch_array($session))
	{
		$_SESSION['session_year'] = $ses['session_year'];
		$_SESSION['current_session'] = $ses['session_id'];
		$_SESSION['description'] = $ses['comment'];
		$_SESSION['semester'] = $ses['term'];	
	}
	while($c = mysqli_fetch_array($company))
	{
		$_SESSION['website'] = $c['website'];
		$_SESSION['abr'] = $c['adm_initial'];	
		$_SESSION['banner'] = $c['path'];
	}
	/*$pwd = $_SESSION['pwd'];
	echo "
		<script>
			alert ('$pwd I ama')
			//window.location='../studentlogin.php'
		</script>
		";*/
/*if (isset($_SESSION['pwd']))
	{
		$pwd = $_SESSION['pwd'];
		$matric = $_SESSION['stid'];		
	}
	else
	{
		$matric = $_POST['matric'];
		$pwd = $_POST['pwd'];
		$pwd = sha1($pwd);
	}*/
	if(isset($_POST['matric']))
	{
		$matric = $_POST['matric'];
		$pwd = $_POST['passcode'];
		$pwd = sha1($pwd);
		$login = mysqli_query($con,"select firstname,lastname,s.student_id student_id,gender,email,passport,phone_1,phone_2,cd_id,tag,cat_id,c_id,date_of_birth,summer from student_table s join class_details_tb c using(cd_id) where s.student_id = $matric and password = '$pwd'");
		$terms = mysqli_query($con,"select termd_id from term_details_tb join term_tb using(term_id) where student_id = $matric and current_date between begins and ends");
		
	}
	
	
	if (mysqli_num_rows($login) == 1)
	{
		$_SESSION['pwd'] = $pwd;
	$_SESSION['stid'] = $matric;
	$_SESSION['matric'] = $matric;
		while($t = mysqli_fetch_array($terms))
		{
			$_SESSION['termdid'] = $t['termd_id'];	
		}
		while($log = mysqli_fetch_array($login))
		{
			//echo "after";
			$flag = true;
			$_SESSION['stname'] = $log['firstname'].' '.$log['lastname'];
			$_SESSION['stphoto'] = "../edozzier/".$log['passport'];
			$_SESSION['matric'] = $log['student_id'];
			$_SESSION['phone1'] = $log['phone_1'];
			$_SESSION['cdid'] = $log['cd_id'];
			$_SESSION['tag'] = $log['tag'];
			$_SESSION['email'] = $log['email'];
			$_SESSION['gender'] = $log['gender'];
			$cat = $log['cat_id'];
			$cid = $log['c_id'];
			$_SESSION['cdid'] = $log['cd_id'];
			$_SESSION['deptid'] = $cat;
			$summer = $log['summer'];	
			$_SESSION['summer'] = $summer;
			$sqll2 = mysqli_query($con,"select * from class_tb where c_id = $cid");
			
			$sqll3 = mysqli_query($con,"select * from categories_tb where cat_id = $cat");	
		}
		while($class = mysqli_fetch_array($sqll2))
		{
			$_SESSION['prog'] = $class['name'];
		}
		while($cate = mysqli_fetch_array($sqll3))
		{
			$_SESSION['dept'] = $cate['description'];
		}
?>
<!DOCTYPE HTML>
<html><head>
<title> Student Portal | <?php echo $_SESSION['abr']; ?> </title>
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
<script
  src="http://code.jquery.com/jquery-3.2.1.min.js" ></script>
<script src="js/Chart.js"></script>
<!-- //chart -->
 <!-- js-->
<!--<script src="js/jquery-1.11.1.min.js"></script>-->
<script src="js/jquery-3.1.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts--> 
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<link type="text/css" rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
		<div class="sidebar" role="navigation">
            <div class="navbar-collapse">
				<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right dev-page-sidebar mCustomScrollbar _mCS_1 mCS-autoHide mCS_no_scrollbar" id="cbp-spmenu-s1" style="background:green;">
					<div class="scrollbar scrollbar1">
						<ul class="nav" id="side-menu">
							<li>
								<a href="index.php" class="active"><i class="fa fa-home nav_icon"></i>Dashboard</a>
							</li>
                            	<li>
								<a href="#"><i class="fa fa-user nav_icon"></i>Profile <span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse">
									<li>
										<a href="changepcode.php" target="body">Change Passcode</a>
									</li>
									<li>
										<a href="documents.php" target="body">Documents</a>
									</li>
								</ul>
								<!-- /nav-second-level -->
							</li>

							<li>
								<a href="#"><i class="fa fa-book nav_icon"></i>Payments <span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse">
									<li>
										<a href="paytution.php" target="body">Pay Tution</a>
									</li>
									<li>
										<a href="otherpayments.php" target="body">Other Payment</a>
									</li>
                                    <li>
										<a href="payhistory.php" target="body">Payment History</a>
									</li>
								</ul>
								<!-- /nav-second-level -->
							</li>
							<li>
								<a href="#" class="chart-nav"><i class="fa fa-list-ul nav_icon"></i>Academics<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level collapse">
									<li>
										<a href="result.php" target="body">Semester Result</a>
									</li>
									<li>
										<a href="reg.php" target="new">Course Registration</a>
									</li>
                                    <li>
										<a href="reghistory" target="body">Registration History</a>
									</li>
                                    <li>
										<a href="mytimetable.php" target="body">View Timetable</a>
									</li>
								</ul>
								<!-- //nav-second-level -->
							</li>
                            <li>
								<a href="<?php echo $_SESSION['website']; ?>" target="new"><i class="fa fa-home nav_icon"></i><?php echo $_SESSION['abr']; ?>  Home</a>
							</li>
                             <li>
								<a href="<?php echo $_SESSION['website']; ?>/student-portal/" ><i class="fa fa-sign-out nav_icon"></i>Log Out</a>
							</li>
						</ul>
					</div>
					<!-- //sidebar-collapse -->
				</nav>
			</div>
		</div>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--logo -->
				<div class="logo" style="background:green;">
					<a href="index.html">
						<ul >	
							<li><h1><?php echo $_SESSION['abr']; ?></h1></li>
							<div class="clearfix"> </div>
						</ul>
					</a>
				</div>
				<!--//logo-->
				<div class="header-right header-right-grid">
					<div class="profile_details_left" style="padding-top:7%; padding-left:5%;"><!--notifications of menu start -->
                    <h3 style="color:green; width:auto;">Student Portal<br /><?php if($summer == 'Y'){ echo '(Sandwich)';  }?></h3>
						<div class="clearfix"> </div>
					</div>
				</div>
					
				
				<div class="clearfix"> </div>
			</div>
			<!--search-box-->
				<div class="search-box" style="padding-top:1%;">
					<h4 style="color:green;">Welcome <?php echo $_SESSION['stname'];  ?></h4>
                 <h4 style="color:green;"><?php   echo " (".$_SESSION['dept'].$_SESSION['tag']." -".$_SESSION['prog'].")"; ?></h4>
				</div>
				<!--//end-search-box-->
			<div class="header-right">
				
				<!--notification menu end -->
				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img width="100" height="100" class="img-circle img-responsive" src="<?php $stphoto = (isset($_SESSION['stphoto']))?$_SESSION['stphoto']:'images/placeholder.png'; echo $stphoto; ?>" alt=""> </span> 
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li> <a href="#" target="body"><i class="fa fa-user"></i> Profile</a> </li> 
								<li> <a href="/student-portal"><i class="fa fa-sign-out"></i> Logout</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
			
				<iframe style="width:100%; height:700px; border:0px solid green;" name="body" src="profile.php"></iframe>
					
			</div>
		</div>
		<!--footer-->
		 <div class="dev-page">
	 
			<!-- page footer -->   
			<!-- dev-page-footer-closed dev-page-footer-fixed -->
            <div class="dev-page-footer dev-page-footer-fixed" style="background:green;"> 
				<!-- container -->
				<div class="container" >
					<div class="copyright" >
						<p>© <?php echo date('Y'); ?> <a href=" <?php echo $_SESSION['website']; ?> "><?php echo $_SESSION['abr']; ?></a> . All Rights Reserved . Design by <a href="https://sqiprofessionals.com">SQI Professionals</a></p> 
					</div>
					</div>
               
                
                </div>
				<!-- //container -->
            </div>
            <!-- /page footer -->
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->
<!--
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
-->
	<!-- Bootstrap Core JavaScript --> 
		
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

        <script type="text/javascript" src="js/dev-loaders.js"></script>
        <script type="text/javascript" src="js/dev-layout-default.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		<!--scrolling js-->
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<!--//scrolling js-->
		
		<script>
			$(document).ready(function(){
				$("#showLeftPush").click(function(){
					if($("nav.cbp-spmenu").is(':visible')){
						$("nav.cbp-spmenu").toggle('slide',{direction:'right'},1000,function(){
							$("#page-wrapper").animate({'margin':'0'});
						});
						
					}else{
						$("#page-wrapper").animate({'margin-right':'19.3em'},function(){
							$("nav.cbp-spmenu").toggle('slide',{direction:'left'},1000);
						});
					
					}
				});
			})
		</script>
		
		
		
</body>
</html>
<?php
	}
	else {
		echo "
		<script>
			alert ('Login Failed');
			window.location='/student-portal'
		</script>
		";	
	}
	mysqli_close($con);
?>