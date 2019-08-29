<?php
session_start();
include('connect.php');

if(!isset($_SESSION['Role']))
{
  echo "<script>window.alert('Please Login to Continue.')</script>";
  echo "<script>window.location='signin.php'</script>";
}
?>
<html>
<head>
    <title>History</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  
</head>
<body>
    <div align="center">
      <img src='images/logo.png'/>
  </div>  
  <ul>
      <li><a href="home.php">Home</a></li>
      <?php 
      if (!isset($_SESSION['Role']))
      {
        echo "<li><a href='customer_signup.php'>Customer Sign Up</a></li>";
        echo "<li><a href='signin.php'>Sign In</a></li>";
      }
      if ($_SESSION['Role']=='Admin')
      {
        echo "<li><a href='admin_panel.php'>Admin Panel</a></li>";
      }
      if ($_SESSION['Role']=='Customer' || $_SESSION['Role']=='Agent' || $_SESSION['Role']=='SuperAgent')
      {
        echo "<li><a href='transaction.php'>Transaction</a></li>";
      }
      if ($_SESSION['Role']=='Customer' || $_SESSION['Role']=='Agent' || $_SESSION['Role']=='SuperAgent' || $_SESSION['Role']=='Partner')
      {
        echo "<li><a class='active' href='history.php'>History</a></li>";
      }
      if ($_SESSION['Role']=='Agent')
      {
        echo "<li><a href='inform.php'>Inform</a></li>";
      }

      if (isset($_SESSION['Role']))
      {
        echo "<li><a href='logout.php'>Logout</a></li>";
      }
      ?>
      
  </ul> 
  <form action="#" method="post" enctype="multipart/formdata">


<fieldset> 
  <legend> Transaction History </legend>
<table align=center>
  <?php 
  if ($_SESSION['Role']=='Customer')
  { 
    echo "<tr>
    <td> <a href='history_c2c_sent.php'>Sent History</a> </td>
  </tr>
  <tr>
    <td> <a href='history_c2c_received.php'>Received History</a> </td>
  </tr>
  <tr>
    <td> <a href='history_upgrade.php'>Upgrade History</a> </td>
  </tr>
  <tr>
    <td> <a href='history_topup.php'>TopUp History</a> </td>
  </tr>
  <tr>
    <td> <a href='history_payment.php'>Payment History</a> </td>
  </tr>";
}
elseif ($_SESSION['Role']=='Agent')
{
  echo "<tr>
    <td> <a href='history_topup.php'>TopUp History</a> </td>
  </tr>
  <tr>
    <td> <a href='history_upgrade.php'>Upgrade History</a> </td>
  </tr>"; 
}
elseif ($_SESSION['Role']=='Partner')
{
  echo "<tr>
    <td> <a href='history_payment.php'>Payment History</a> </td>
  </tr>";
}
elseif ($_SESSION['Role']=='SuperAgent')
{
  echo "<tr>
    <td> <a href='history_topup.php'>Refill History</a> </td>
  </tr>";
}
else
{
  echo "<tr>
    <td> There are no transactions that can be done by Admin. </td>
  </tr>";
}
?>
</table>
</fieldset>
</form>
</body>
</html>

