<?php
session_start();
include('connect.php');

if(!isset($_SESSION['AdminID']))
{
	echo "<script>window.alert('Please Login as Admin to Continue.')</script>";
	echo "<script>window.location='signin.php'</script>";
}
?>

<html>
<head>
	<title>Admin Panel</title>
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
        echo "<li><a class='active' href='admin_panel.php'>Admin Panel</a></li>";
      }
      if ($_SESSION['Role']=='Customer' || $_SESSION['Role']=='Agent' || $_SESSION['Role']=='SuperAgent')
      {
        echo "<li><a href='transaction.php'>Transaction</a></li>";
      }
      if ($_SESSION['Role']=='Customer' || $_SESSION['Role']=='Agent' || $_SESSION['Role']=='SuperAgent' || $_SESSION['Role']=='Partner')
      {
        echo "<li><a href='history.php'>History</a></li>";
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
<fieldset> 
	<legend> Admin Panel </legend>
<table align=center>
	<tr>
		<td> <a href="partner_signup.php">Partner Sign-Up</a> </td>
	</tr>
	<tr>
		<td> <a href="agent_signup.php">Agent Sign-Up</a> </td>
	</tr>
	<tr>
		<td> <a href="superagent_signup.php">SuperAgent Sign-Up</a> </td>
	</tr>
	<tr>
		<td> <a href="customertype_change.php">CustomerType Change</a> </td>
	</tr>
</table>
</fieldset>

</body>
</html>