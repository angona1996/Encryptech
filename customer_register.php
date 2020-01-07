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
                       Register
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
                           
                           <h2> Register a new account </h2>
                           
                       </center><!-- center Finish -->
                       
                       <form action="customer_register.php" method="post" enctype="multipart/form-data"><!-- form Begin -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your Name</label>
                               
                               <input type="text" class="form-control" name="c_name" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your Email</label>
                               
                               <input type="text" class="form-control" name="c_email" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your Password</label>
                               
                               <input type="password" class="form-control" name="c_pass" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your Country</label>
                               
                               <input type="text" class="form-control" name="c_country" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your City</label>
                               
                               <input type="text" class="form-control" name="c_city" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your Contact</label>
                               
                               <input type="text" class="form-control" name="c_contact" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your Address</label>
                               
                               <input type="text" class="form-control" name="c_address" required>
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="form-group"><!-- form-group Begin -->
                               
                               <label>Your Profile Picture</label>
                               
                               <input type="file" class="form-control form-height-custom" name="c_image">
                               
                           </div><!-- form-group Finish -->
                           
                           <div class="text-center"><!-- text-center Begin -->
                               
                               <button type="submit" name="register" class="btn btn-primary">
                               
                               <i class="fa fa-user-md"></i> Register
                               
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

if(isset($_POST['register'])){
    
    $c_name = $_POST['c_name'];
    
    $c_email = $_POST['c_email'];
    
    $select_customer = "select * from customers where customer_email='$c_email' ";
    $run_customer = mysqli_query($con,$select_customer);
    $check_customer = mysqli_num_rows($run_customer);
    if($check_customer>0){
        
        echo "<script>alert('User is already Registered with this email')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
        
    }
    
    if (!filter_var($c_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email is not valid')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }
    
    $c_pass = $_POST['c_pass'];
    
    $len = strlen($c_pass);
    if($len<8){
        echo "<script>alert('password should be at least 8 characters')</script>";
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    } 
     $c_pass = md5($_POST['c_pass']);
    $c_country = $_POST['c_country'];
    
    $c_city = $_POST['c_city'];
    
    $c_contact = $_POST['c_contact'];
    
    $c_address = $_POST['c_address'];
    
    $c_image = $_FILES['c_image']['name'];
    
    $c_image_tmp = $_FILES['c_image']['tmp_name'];
    
   // $c_ip = getRealIpUser();
    $code = mt_rand();
    $code_db = md5($code);
    $code = (string)$code;  
    $verr = "no";
    move_uploaded_file($c_image_tmp,"customer/customer_images/$c_image");
    
    $insert_customer = "insert into customers (customer_name,customer_email,customer_pass,customer_country,customer_city,customer_contact,customer_address,customer_image,customer_ip,code,verified) values ('$c_name','$c_email','$c_pass','$c_country','$c_city','$c_contact','$c_address','$c_image','$c_ip','$code_db','$verr')";
    
    $run_customer = mysqli_query($con,$insert_customer);
    
    $sel_cart = "select * from cart where ip_add='$c_ip'";
    
    $run_cart = mysqli_query($con,$sel_cart);
    
    $check_cart = mysqli_num_rows($run_cart);
    
    if($check_cart>0){
        
        /// If register have items in cart ///
        
       # $_SESSION['customer_email']=$c_email;
        
        echo "<script>alert('You have been Registered Sucessfully')</script>";


        
      
        
//the subject
        $sub = "Email Verification Code";
//the message
        $msg = "Your verification Code is '$code'" ;
//recipient email here
        $rec = $c_email;
//send email
        mail($rec,$sub,$msg);
        
    
$run_cust=mysqli_query($con,$s);
         echo "<script>alert('You have been Registered Sucessfully...Please check your email and insert your email & verification code to complete registration')</script>";
        
        echo "<script>window.open('verification.php','_self')</script>";
        
    }else{
        
        /// If register without items in cart ///
        
        #$_SESSION['customer_email']=$c_email;
        
        echo "<script>alert('You have been Registered Sucessfully...Please check your email and insert your email & verification code to complete registration')</script>";
      


        
//the subject
        $sub = "Email Verification Code";
//the message
        $msg = "Your verification Code is '$code'" ;
//recipient email here
        $rec = $c_email;
//send email
        mail($rec,$sub,$msg);



// Send the message

        
        echo "<script>window.open('verification.php','_self')</script>";
        
    }
    
}

?>