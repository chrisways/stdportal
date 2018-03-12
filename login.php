<?php
if(!isset($_SESSION)){
    session_start();
    }
require_once("db_con.php");
class Login extends Db_con{
    public function __construct(){
        parent::__construct();
    }
    public function sessions($status){
        $sessio = $this->conn->prepare("select session_id,session_year,comment,term_tb.term from session_tb join term_tb using(session_id) where status = ? and CURRENT_DATE BETWEEN begins and ends");
        $compan = $this->conn->prepare("select website,adm_initial,path,logo from company_tb");
         $sessio->bind_param("s",$status);
         $sessio->execute();
         $sessio->store_result();
         $num_of_rows = $sessio->num_rows;
         $sessio->bind_result($sid,$year,$comment,$term);
        // $session = $sessio->get_result();
        while($sessio->fetch()){
                $_SESSION['session_year'] = $year;
                $_SESSION['current_session'] = $sid;
                $_SESSION['description'] = $comment;
                $_SESSION['semester'] = $term;
        }
        $compan->execute();
       // $company = $compan->get_result();
       $compan->store_result();
       $num_of_rows = $compan->num_rows;
       $compan->bind_result($website,$adm_initial,$path,$logo);
        while($compan->fetch()){
             $_SESSION['website'] = $website;
             $_SESSION['abr'] = $adm_initial;   
             $_SESSION['banner'] = $path;
             $_SESSION['logos'] = $logo;
            }
    }
    public function student_login($matric,$pwd){
        // $session = mysqli_query($con,"select session_id,session_year,comment,term_tb.term from session_tb join term_tb using(session_id) where status = 2 and CURRENT_DATE BETWEEN begins and ends");
    // $company = mysqli_query($con,"select * from company_tb");
    // while($ses = mysqli_fetch_array($session))
    // {
    //  $_SESSION['session_year'] = $ses['session_year'];
    //  $_SESSION['current_session'] = $ses['session_id'];
    //  $_SESSION['description'] = $ses['comment'];
    //  $_SESSION['semester'] = $ses['term'];   
    // }
    // while($c = mysqli_fetch_array($company))
    // {
    //  $_SESSION['website'] = $c['website'];
    //  $_SESSION['abr'] = $c['adm_initial'];   
    //  $_SESSION['banner'] = $c['path'];
    // }
         $logi = $this->conn->prepare("select firstname,lastname,s.student_id student_id,gender,email,passport,phone_1,phone_2,cd_id,tag,cat_id,c_id,date_of_birth,summer from student_table s join class_details_tb c using(cd_id) where s.student_id = ? and password = ?");
         $logi->bind_param("ss",$matric,$pwd);
         $logi->execute();
         $login = $logi->get_result();
         $terms = $this->conn->query("select termd_id from term_details_tb join term_tb using(term_id) where student_id = $matric and current_date between begins and ends");
         if($login->num_rows==1){
            $_SESSION['pwd'] = $pwd;
            $_SESSION['stid'] = $matric;
            $_SESSION['matric'] = $matric;
            while($t = $terms->fetch_assoc())
            {
                $_SESSION['termdid'] = $t['termd_id'];  
            }
            while($log = $login->fetch_assoc())
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
            $sqll2 = $this->conn->query("select * from class_tb where c_id = $cid");
            
            $sqll3 = $this->conn->query("select * from categories_tb where cat_id = $cat");
        }
        while($class = $sqll2->fetch_assoc())
        {
            $_SESSION['prog'] = $class['name'];
        }
        while($cate = $sqll3->fetch_assoc())
        {
            $_SESSION['dept'] = $cate['description'];
        }
        echo "<script>location.href='index.php'</script>";
         }else{
        //     echo "
        // <script>
        //     alert ('Login Failed');
        //     window.location='/student-portal'
        // </script>
        // ";  
         }
       
        //$this->conn->close();
    }

}

?>
