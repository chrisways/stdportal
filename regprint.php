<?php session_start();
if(isset($_SESSION['matric']))
{
$_SESSION['page'] = 'reg.php';
include('dbcon.php');
$matric = $_SESSION['matric'];
$cdid = $_SESSION['cdid'];
$termdid = $_SESSION['termdid'];
$termid = $_SESSION['current_term'];
$_SESSION['proname']= 'p';

if($_SESSION['summer'] == 'Y')
{
	$semesters = mysqli_query($con,"select termd_id,term_tb.term from term_details_tb join term_tb using(term_id) join session_tb using(session_id) where student_id = $matric and status = 2 order by begins asc");
}
?>
<!DOCTYPE HTML>
<html><head>
<title><?php echo $_SESSION['abr']; ?></title>




</head>
<body style ="background-image:url(<?php echo '../edozzier/'.$_SESSION['logos']; ?>); back" id="body">
<div class="container-fluid">
<div id="watermark" style="position:relative; background-image:url(<?php echo '../edozzier/'.$_SESSION['logos']; ?>) no-repeat" >
	<!-- <div class="row"> -->
		<div id="sbanner" style="background-color:#090;height:70px">
                  <img style="height:70px;width: 100%;" alt="School Banner Here" src="<?php echo '../edozzier/'.$_SESSION['banner']; ?>" />
        </div>
	<!-- </div> -->
	<div class="row" style="margin-top:20px;">
	<div class="col-md-4 col-md-offset-4">
		<div class="form-group">
		<?php if ($_SESSION['summer'] === 'Y') { echo "<h3 style='text-align:right'> SANDWITCH </h3>"; } ?>
		</div>
	</div>
	</div>
	<div class="row">
		<table width="100%"><tr><td>
			<form id="actForm" class="form-horizontal" method="POST">
				<h4 style="color:#000"><?php echo $_SESSION['abr'] ?> COURSE REGISTRATION<br /> <span style="font-size:15px;"><?php echo $_SESSION['semester'];  ?> of <?php echo $_SESSION['session_year'] ?> Session<br /><?php echo $_SESSION['stname']."[".$_SESSION['matric']."]";  ?> <br /><?php echo $_SESSION['mydept']." ".$_SESSION['myprog']." ".$_SESSION['tag'];  ?></span></h4>
		</td><td align='right' valign="top">
			<img src="<?php $stphoto = (isset($_SESSION['stphoto']))?$_SESSION['stphoto']:'images/placeholder.png'; echo $stphoto; ?>"  class="img-responsive pull-right" />
		</td></tr></table>

     <div class="content-top">
			<div class="wrap" >
				 
				<div class="section group" >
				 <div class="col span_2_of_contact" id="all">
				  <div class="contact-form" id="contact_form">
				  
				  <h2 class="form-section-title"><tr><td width="30%" colspan="2"><small></small> </td></tr></h2><div class="control-group"></div>
                    <?php
					/* $staffs = mysqli_query($con,"select * from staff_table");
					$_SESSION['staff'] = array();
					$_SESSION['office'] = array();
					while($s = mysqli_fetch_array($staffs))
					{
						$staff[$s['staff_id']] = $s['title']." ".$s['firstname']." ".$s['lastname'];	
						$office[$s['staff_id']] = $s['office_desc'];
						$_SESSION['staff'][$s['staff_id']]= $staff[$s['staff_id']];
						$_SESSION['office'][$s['staff_id']]= $s['office_desc'];
					}*/
					$proname = substr($_SESSION['proname'],0,2)."%";
					$course = mysqli_query($con,"select staff_id, title, sub_id, unit, s_desc,f_desc,elective,semester from courses_tb join subject_tb on(courses_tb.co_id = subject_tb.co_id) join class_details_tb using (cd_id) join class_tb ct using(c_id) where cd_id = $cdid or ct.name like '$proname' order by title");
					$course2 = mysqli_query($con,"select * from result_tb join subject_tb using(sub_id) join courses_tb on (courses_tb.co_id = subject_tb.co_id) where termd_id = $termdid");//(select termd_id from student_table join term_details_tb td using (student_id) join term_tb using(term_id) where student_id = $matric and current_date between begins and ends)");
					$carryovers = mysqli_query($con,"select staff_id, title, sub_id, unit, s_desc,f_desc,elective,semester from courses_tb join subject_tb on(courses_tb.co_id = subject_tb.co_id) join class_details_tb using (cd_id) join class_tb ct using(c_id) where cd_id = $cdid or ct.name like '$proname' order by title");

					 ?>
				  <div class="controls">
                  <table class="table table-bordered table-responsive"><tr style="background-color:#008000;color:#fff;" bgcolor="#fff"><th width="10%">Course Code</th><th>Course Title</th><th>Unit</th><th>Lecturer in Charge</th></tr>
                  <?php
                  $tunit = 0;//here
				  	while($c = mysqli_fetch_array($course2))
					{
						$subid = $c['sub_id'];
						$code = $c['title'];
						$unit = $c['unit'];
						$title = $c['s_desc'];
						$desc = $c['f_desc'];
						$courseStaff = mysqli_query($con,"select * from course_allocation_tb where sub_id= ".$subid." and term_id = ".$termid);
						while($cs = mysqli_fetch_array($courseStaff))
						{
							$st = ($cs['staff_id'] != null || $cs['staff_id'] != '' )? $_SESSION['staff'][$cs['staff_id']] : 'Not Assigned Yet!';
							$of = $_SESSION['office'][$cs['staff_id']];
						}
						$tunit += $unit;
						echo "<tr><td>$code</td><td title='$desc'>$title</td><td>$unit</td><td title='$of'>$st</td></tr>";
						
					} ?>
                  <tr><th colspan="2" align="right"> Total Registered Unit(s) &nbsp;&nbsp;&nbsp;</th><th align="left" colspan="3"><?php if($tunit > 11 && $unit < 19){ echo $tunit;}else{ echo "<font color=red title='Unit not within range.'> $tunit </font>";    } ?></th></tr><tr><td colspan="5">&nbsp;  </td></tr>
            <?php if($course2){  ?><tr><td colspan="5" width="100%"><table width="100%">   <tr><td align="center" >--------------------<br />Student</td><td>&nbsp;</td><td align="center">--------------------<br />H.O.D</td><td>&nbsp;  </td><td align="center">-------------------<br />F. Advisor</td></tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td align="center" >---------------------<br />D.S.A</td><td>&nbsp;</td><td align="center">--------------------<br />Student Body</td><td>&nbsp;  </td><td align="center">-------------------<br />Bursar</td></tr>
            
            </table></td></tr>    <?php } ?> 
			</table>
                
                  </form></div></div>
				 </div>
				 <div class="clear"></div>
			  </div>
			</div>
			
	</div>
    <?php include('footer.php'); ?>
    
    </div>
</div>
</body>
</html>

    	
    	<?php }
		else
		{
			include('studentlogin.php');	
		}
		 ?>
            