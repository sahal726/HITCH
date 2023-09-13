<?php
 session_start();

 include("connections.php");
 include("functions.php");
 
  
 if ($_SERVER['REQUEST_METHOD'] =="POST")
 {
     //something was posted
     $user_name=$_POST['uname'];
     $password=$_POST['password'];
 
     if(!empty($user_name)&& !empty($password) )
     {
         
         $query1 = "select * from users where uname = '$user_name' limit 1";
         
        
          $result = mysqli_query($con,$query1);
          

          $count=mysqli_num_rows($result);
          



        if($result && $count>0)
        {
            
              $user_data=mysqli_fetch_assoc($result);
            
              if($user_data['password'] === $password )
              {
                $_SESSION['id'] = $user_data['id'];
                header("Location: index.php");
                die;
              }
              else
              {
                echo("Enter the correct password");
              }
            
            
        
            
        }  
        else
        {  
          echo"please enter some valid information!";
        }
      }
 }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./asset/style.css">



    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">

</head>

<body>

  <section id="navbar">

    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light bg-light mx-5  bg-light">

        <h4 class="hitch-h1 ">hitch</h4>
       
       
      </nav>
    </div>
 </section>


    




<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Log in</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="4x0la6"></button>
      </div>
      
      


        
      <div class="modal-body p-5 pt-0">
        <form  action="" method="POST" class="">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com" fdprocessedid="f9bzpb" name="uname">
            <label for="floatingInput">User Name</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password" fdprocessedid="zrk37a" name="password">
            <label for="floatingPassword">Password</label>
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" fdprocessedid="kpcbbk">Log in</button>
          <small class="text-body-secondary">If you are not registered yet .</small>

         
       
       <a href="signup.php" class=" my-4">Sign up</a>
           
          
         
        </form>
        <a href="https://www.youtube.com" class="my-4 ">YouTube</a> 
      </div>
    </div>
  </div>
</div>














<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>