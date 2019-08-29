<?php
session_start();
include('connect.php'); 

?>


<html>
<head>
	<title>Homepage</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div align="center">
      <img src='images/logo.png'/>
  </div>  
  <ul>
      <li><a class="active" href="home.php">Home</a></li>
      <?php 
      if (!isset($_SESSION['Role']))
      {
        echo "<li><a href='customer_signup.php'>Customer Sign Up</a></li>";
        echo "<li><a href='signin.php'>Sign In</a></li>";
      }
      else if ($_SESSION['Role']=='Admin')
      {
        echo "<li><a href='admin_panel.php'>Admin Panel</a></li>";
      }
      else if ($_SESSION['Role']=='Customer' || $_SESSION['Role']=='Agent' || $_SESSION['Role']=='SuperAgent')
      {
        if ($_SESSION['Role']!='Partner')
      {
        echo "<li><a href='transaction.php'>Transaction</a></li>";
      } 
      echo "<li><a href='history.php'>History</a></li>";
      if ($_SESSION['Role']=='Agent')
      {
        echo "<li><a href='inform.php'>Inform</a></li>";
      }
       

      }
      
      

       if (isset($_SESSION['Role']))
      {
        echo "<li><a href='logout.php'>Logout</a></li>";
      }
      ?>
      
  </ul> 
<form action="#" method="post" enctype="multipart/formdata">
<fieldset>
<legend>Homepage</legend>
<h2 align=center> Welcome to MPT's Mobile Money Website! </h2>

<?php 

echo "<p align=left> Hello <b>"; if (!isset($_SESSION['Name']))
{
  echo "Guest</b>!</p>";
}
else 
{
  echo $_SESSION['Name'] . "</b>!</p> ";
}  
echo "
<p align=left> Balance: <b>"; if (!isset($_SESSION['Balance']))
{
  echo "None </b> </p>";
}
else 
{
  echo $_SESSION['Balance'] . " </b></p> ";
} 

?>
</p> 
</br> </br>

<p align=center> Choose an action from the menu bar to make a transaction. </p>

<div align="center">
<h3> What is Mobile Money? </h3> <br>
      <img src='images/mobilemoney.png'/>

      <p> Mobile Money is basically an Electronic Wallet which can be used for payment and transactions if you have deposited into your own account. It is similar to ATM cards which can be used to retrieve cash money but with Mobile Money, everything is from your own mobile! </p>
      <p> <b> Your Mobile is Your Bank. </b> </p>
      <br>

      <h3> What makes MPT's Mobile Money Special? </h3> <br>
      <p> Unlike other Mobile Money systems, MPT's is quite portable. You do not need to carry the phone you registered; you can access the system from various devices while just having internet since this is web-based!



</div>  

</fieldset>
</body>
</html>