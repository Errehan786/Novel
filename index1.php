<?php
//index.php

//Include Configuration File
include_once('config.php');

$login_button = '';


if(isset($_GET["code"]))
{

 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


 if(!isset($token['error']))
 {
 
  $google_client->setAccessToken($token['access_token']);

 
  $_SESSION['access_token'] = $token['access_token'];

  $google_service = new Google_Service_Oauth2($google_client);

 
  $data = $google_service->userinfo->get();

 
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  }

  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }

  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  }

  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }

  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }
}


if(!isset($_SESSION['access_token']))
{

 $login_button = '<a href="'.$google_client->createAuthUrl().'">Login With Google</a>';
}

?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>PHP Login using Google Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 </head>
 <style>
   /* a{
    text-decoration:none !important;
    color:black;
   } */
 </style>
 <body>

 <?php
  if($login_button == '')
  {
    echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
    echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
    echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
    echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
    echo '<h3><a href="logout.php">Logout</h3></div>';
    echo '<script>location.href="requester/home.php"</script>';
  }
  else
  {
 ?>                      


<!-- google login section -->
<div class="container mt-4">
   <div class="row">
     <div class="col-sm-6 m-auto border border-warning shadow-lg p-3">
       <h1 class="text-center">Logo</h1>
       <h3 class="text-center">Lorem, ipsum dolor sit amet consectetur.</h3>
       <p class="text-center">Lorem, ipsum dolor sit amet consectetur adipisicing elit. </p>
       <div class="row shadow-md">
         <div class="col-sm-8 m-auto border border-primary" style="padding-left:20px; border-radius:100px;">
           <div class="row">
           <div class="col-sm- mt-3">
              <img class="bg-light mx-3" src="image/logo.png" alt="Google Logo" width="30px" height="30px">
         </div>
         <div class="col-sm- mx-2">
         <p> <?php
                          echo '<div style="">'.$login_button . '</div>';
                        }
                        ?></p>
         </div>
           </div>
         </div>
       </div>
       
     </div>
   </div>
 </div>
 </body>
</html>
                        
