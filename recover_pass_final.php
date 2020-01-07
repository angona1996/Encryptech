<?php 

    $active='Account';
    include("includes/header.php");

?>
   
   <div id="content"><!-- #content Begin -->
       <div class="container"><!-- container Begin -->
           <div class="col-md-12"><!-- col-md-12 Begin -->
               
               <ul class="breadcrumb"><!-- breadcrumb Begin -->
                   <li>
                       <a href="index.php">Home</a>
                   </li>
                   <li>
                       Recover Password
                   </li>
               </ul><!-- breadcrumb Finish -->
               
           </div><!-- col-md-12 Finish -->
           
           <div class="col-md-3"><!-- col-md-3 Begin -->
   
   <?php 
    
    include("includes/sidebar.php");
    
    ?>
               
           </div><!-- col-md-3 Finish -->
           
           <div class="col-md-9"><!-- col-md-9 Begin -->
               
               <div class="box"><!-- box Begin -->
                   
                   <div class="box-header"><!-- box-header Begin -->
                       
                       <center><!-- center Begin -->
                           
                           <h2> Recover Password </h2>
                           <h5>Enter Email and click resend code to generate a new recovery code</h5>
                           
                       </center><!-- center Finish -->
                       
                       <form action="recover_pass_final.php" method="post" enctype="multipart/form-data"><!-- form Begin -->
                           
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your Email</label>
                               
                               <input type="text" class="form-control" name="c_email" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Password Recovery Code</label>
                               
                               <input type="text" class="form-control" name="code" >
                               
                           </div><!-- form-group Finish     <div class="text-center"><!-- text-center Begin -->
                            
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>New Password</label>
                               
                               <input type="password" class="form-control" name="pass" >
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                            <label>Retype New Password</label>
                               
                               <input type="password" class="form-control" name="repass" >
                               
                           </div><!-- form-group Finish -->
                               
                               
                               
                               <button type="submit" name="recover" class="btn btn-primary">
                                <i class="fa fa-user-md"></i> Recover Password
                                   
                               <button type="submit" name="sendcode" class="btn btn-primary">
                               
                               <i class="fa fa-user-md"></i> Regenerate Code
                               
                               </button>
                               
                           </div><!-- text-center Finish -->
                           
                       </form><!-- form Finish -->
                       
                   </div><!-- box-header Finish -->
                   
               </div><!-- box Finish -->
               
           </div><!-- col-md-9 Finish -->
           
       </div><!-- container Finish -->
   </div><!-- #content Finish -->
   
   <?php 
    
    include("includes/footer.php");
    
    ?>
    
    <script src="js/jquery-331.min.js"></script>
    <script src="js/bootstrap-337.min.js"></script>
    
    
</body>
</html>


<?php 

if(isset($_POST['recover'])){
    
   
    
    $c_email = $_POST['c_email'];
    
    if (!filter_var($c_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email is not valid')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }
    $select_customer = "select * from customers where customer_email='$c_email' ";
    $run_customer = mysqli_query($con,$select_customer);
    $check_customer = mysqli_num_rows($run_customer);
    if($check_customer==0){
        
        echo "<script>alert('No user is registered with this email')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
        
    }
    
    
    
    
    $code =(int) $_POST['code'];

    $code = md5($code);
    $code = (string)$code;  
    
    $select_customer = "select * from customers where customer_email='$c_email' and code = '$code' ";
    $run_customer = mysqli_query($con,$select_customer);
    $check_customer = mysqli_num_rows($run_customer);
    if($check_customer==0){
        
        echo "<script>alert('Invalid Verification Code')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
        
    }
    else {
        
    $c_pass = $_POST['pass'];
    $c_repass = $_POST['repass'];
    if($c_pass==$c_repass){
        $len = strlen($c_pass);
        if($len<8){
           echo "<script>alert('Password must be at least 8 characters long')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;  
        }
        else{
            $c_pass = md5($_POST['pass']);
             $insert_customer = "update customers set customer_pass = '$c_pass' where customer_email = '$c_email' ";  
            $run_customer = mysqli_query($con,$insert_customer);
        }
        
    }
    else{
        echo "<script>alert('Password and Retype Password doesnt match')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }    
        

    $code  = mt_rand();
    $code  = md5($code);
        
    
    
     $insert_customer = "update customers set code = '$code' where customer_email = '$c_email' ";  
    $run_customer = mysqli_query($con,$insert_customer);
        echo "<script>alert('Your password recover is succesful')</script>";
        echo "<script>window.open('index.php','_self')</script>";

        
    }
    
    
   
    
}
if(isset($_POST['sendcode'])){
    
   
    
    $c_email = $_POST['c_email'];
    
    if (!filter_var($c_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email is not valid')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }
    $select_customer = "select * from customers where customer_email='$c_email' ";
    $run_customer = mysqli_query($con,$select_customer);
    $check_customer = mysqli_num_rows($run_customer);
    if($check_customer==0){
        
        echo "<script>alert('No user is registered with this email')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
        
    }
    
    $verr = "yes";
      $select_customer = "select * from customers where customer_email='$c_email' and verified='$verr' ";
    $run_customer = mysqli_query($con,$select_customer);
    $check_customer = mysqli_num_rows($run_customer);
    
    if($check_customer==0){
        
        echo "<script>alert('Your account is not verified.')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
        
    }
       
    else{
    
    
    
        
    $code  = mt_rand();
    
            
//the subject
        $sub = "Email Verification Code";
//the message
        $msg = "Your password recovery code is $code " ;
//recipient email here
        $rec = $c_email;
//send email
        mail($rec,$sub,$msg);
    $code  = md5($code);
        
  
    
     $insert_customer = "update customers set code = '$code' where customer_email = '$c_email' ";  
    $run_customer = mysqli_query($con,$insert_customer);
        echo "<script>alert('A new password recovery code is send to your email')</script>";
        echo "<script>window.open('recover_pass_final.php','_self')</script>";

        die;

    }
    
}


?>