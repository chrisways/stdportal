<?php
if(!isset($_SESSION)){
    session_start();
    }
    $_SESSION['session_year'] = '';
    $_SESSION['current_session'] = '';
    $_SESSION['description'] = '';
    $_SESSION['semester'] = '';

    $_SESSION['stname'] = '';
    $_SESSION['stphoto'] = '';
    $_SESSION['matric'] = '';
    $_SESSION['phone1'] = '';
    $_SESSION['cdid'] = '';
    $_SESSION['tag'] = '';
    $_SESSION['email'] = '';
    $_SESSION['gender'] = '';
    $cat = '';
    $cid = '';
    $_SESSION['deptid'] = '';
    $summer = ''; 
    $_SESSION['summer'] = '';
	$_SESSION['error'] = '';

    session_destroy();
    echo "<script> window.location = 'http://".$_SESSION['website']."/student-portal' </script>";

?>