<?php 
session_start();
if (!isset($_SESSION["signedup"])) {
    header("Location: ../AAR/login.php");
    exit();
}

session_unset();
session_destroy();

?>
<!-- HTML Layout -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thank you for signing up to Recol!</title>
    <!-- Pure CSS Style -->
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Signika:wght@300;400;600;700&display=swap');
      html,
      body{
        background-color:#eef3f8ee;
        margin: 0;
        padding: 0;
      }
      .container{
        width: 100%;
        height: 110vh;
      }
      .item{
        background-color:#eef3f8ee;
        padding-left: 229px;
        padding-top: 29px;
        padding-bottom: 39px;
        align-items: center;
        height: 41%;
      }
      .item:nth-child(even){
        background-color: rgb(255, 255, 255);
        height: 61%;
      }
      .item h1{
        padding-top: 19px;
        font-size: 42px;
        font-weight: 50;
        margin: 0;
      }
      .item p{
        padding-bottom: 59px;
        margin: 0;
      }
      .item button{
        display: inline-block;
        border-radius: 4px;
        background-color: #1a8cff;
        border: none;
        color: #FFFFFF;
        text-align: center;
        font-size: 15px;
        padding: 9px;
        width: 129px;
        transition: all 0.5s;
        cursor: pointer;
        margin: 5px;
      }
      .item button span{
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
      }
      .item button span:after{
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
      }
      .item button:hover span{
        padding-right: 25px;
      }
      .item button:hover span:after{
        opacity: 1;
        right: 0;
      }
      .item button span a{
        color: #ffffff;
        text-decoration: none;
      }
      @media (max-width: 430px) {
      .item{
        padding-left: 59px;
        padding-top: 59px;
        padding-bottom: 19px;
        align-items: center;
        height: 31%;
      }
      }
    </style>
  </head>
<!-- Contents -->
  <body>
    <div class="container">
      <div class="item">
        <h1 style="font-family: 'Alfa Slab One';">Thanks for signing up!</h1>
        <p>You can now login to your Recol account.</p>
        <button class="button" style="vertical-align:middle">
          <span><a href="../AAR/login.php"><b>Go to login</b></a></span>
        </button>
      </div>
      <div class="item"></div>
    </div>
  </body>
</html>
