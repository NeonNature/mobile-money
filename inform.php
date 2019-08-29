<?php
session_start();
include('connect.php');

if (!isset($_SESSION['Role']))
{
  $_SESSION['Role']="";
}
if($_SESSION['Role']!="Agent")
{
	echo "<script>window.alert('Please Login as Agent to Continue.')</script>";
	echo "<script>window.location='signin.php'</script>";
}

if(isset($_POST['btnsubmit']))
{
  
     $cph=$_POST['txtcph'];
     $i=$_POST['rdoi'];


     $check="SELECT * FROM Customer WHERE PhoneNo='$cph'";
     $checkret=mysql_query($check);
     $count=mysql_num_rows($checkret);

       if($count==0)
       {
          echo "<script>window.alert('Invalid PhoneNo [ $cph ] !')</script>";
          echo"<script>window.location='inform.php'</script>";
       }
       else
       {
        $update="UPDATE Customer
          		SET Informed='$i'
          		WHERE PhoneNo='$cph'";

       $updateret=mysql_query($update);
       if($updateret)
       {
          echo"<script>window.alert('Successfully Informed!')</script>";
          echo"<script>window.location='inform.php'</script>";
       }
       else
       {
          echo "<p>Error in Informing for CustomerType Change : " .mysql_error()."</p>";
       }
    }
}
 
 
?>

<html>
<head>
	<title>Inform</title>
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
        echo "<li><a href='history.php'>History</a></li>";
      }
      if ($_SESSION['Role']=='Agent')
      {
        echo "<li><a class='active' href='inform.php'>Inform</a></li>";
      }

      if (isset($_SESSION['Role']))
      {
        echo "<li><a href='logout.php'>Logout</a></li>";
      }
      ?>
      
  </ul> 
  <form action="inform.php" method="post" enctype="multipart/formdata">
<fieldset>
  <legend> Informing Admin </legend>
<table align=center>
	<tr>
		<td> Customer PhoneNo </td>
		<td> <input type="text" name="txtcph" placeholder="Enter Customer PhoneNo." required/> </td>
	</tr>
	<tr>
		<td> Type to be changed : </td>
		<td> 
			<input type="radio" name="rdoi"  value="2" checked /> Silver
    		<input type="radio" name="rdoi" value="3" /> Golden
    	</td>
	</tr>
	<tr>
      <td></td>    		     
      <td>
        <input type="submit"   name="btnsubmit"  value="Submit" />
    		<input type="reset" value="Clear" />
   		</td>
  </tr>
</table>
</fieldset>

</body>
</html>