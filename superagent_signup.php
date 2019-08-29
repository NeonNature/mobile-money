<?php
session_start();
include('connect.php');

if (!isset($_SESSION['Role']))
{
  $_SESSION['Role']="";
}
if($_SESSION['Role']!="Admin")
{
  echo "<script>window.alert('Please Login as Admin to Continue.')</script>";
  echo "<script>window.location='signin.php'</script>";
}

if(isset($_POST['btnsubmit']))
{

     $saname=$_POST['txtsaname'];
     $sabal=$_POST['txtsabal'];
     $saph=$_POST['txtsaph'];
     $saloc=$_POST['txtsaloc'];
     $sapass=$_POST['txtsapass'];


     $check="SELECT * FROM Partner WHERE PhoneNo='$saph'";
     $checkret=mysql_query($check);
     $count1=mysql_num_rows($checkret);

     $check="SELECT * FROM Customer WHERE PhoneNo='$saph'";
     $checkret=mysql_query($check);
     $count2=mysql_num_rows($checkret);

     $check="SELECT * FROM Agent WHERE PhoneNo='$saph'";
     $checkret=mysql_query($check);
     $count3=mysql_num_rows($checkret);

     $check="SELECT * FROM SuperAgent WHERE PhoneNo='$saph'";
     $checkret=mysql_query($check);
     $count4=mysql_num_rows($checkret);

     $mptcheck="SELECT * FROM MPT WHERE PhoneNo='$saph'";
     $mptcheckret=mysql_query($mptcheck);
     $mptcount=mysql_num_rows($mptcheckret);

     $finalcount=$count1+$count2+$count3+$count4;

       if($finalcount<>0)
       {
          echo "<script>window.alert('The account for this PhoneNo [ $saph ] already exists!')</script>";
          echo"<script>window.location='superagent_signup.php'</script>";
       }
       elseif ($mptcount==0)
        {
          echo "<script>window.alert('This PhoneNo [ $saph ] is not MPT PhoneNo!')</script>";
          echo"<script>window.location='superagent_signup.php'</script>";
       }
       elseif ($sabal<0)
       {
        echo "<script>window.alert('Invalid Balance!')</script>";
          echo"<script>window.location='superagent_signup.php'</script>";
       }
       else
       {
        $insert="INSERT INTO SuperAgent
          (SuperAgentName, SuperAgentBalance, PhoneNo, Location, Password)
          VALUES 
          ('$saname','$sabal','$saph','$saloc','$sapass')";

       $insertret=mysql_query($insert);
       if($insertret)
       {
          echo"<script>window.alert('SuperAgent Account Created!')</script>";
          echo"<script>window.location='admin_panel.php'</script>";
       }
       else
       {
          echo "<p>Error in Agent Registration : " .mysql_error()."</p>";
       }
     }
   }
 

?>


<html>
<head>
	<title>SuperAgent Sign-Up</title>
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
<form action="superagent_signup.php" method="post" enctype="multipart/formdata">
<fieldset>
<legend>Enter SuperAgent information :</legend>
<table align="center" cellspacing="3">

  <tr>
    <td width="145">Name</td>
    <td width="208">
    <input type="text" name="txtsaname" placeholder="Enter Name" required/>
    </td>
  </tr>

  <tr>
    <td>Balance</td>
    <td>
    <input type="text" name="txtsabal" placeholder="Enter SuperAgent's Balance" required/>
    </td>
  </tr>
  
  <tr>
    <td>Phone No.</td>
    <td>
    <input type="text" name="txtsaph" placeholder="Enter PhoneNo." maxlength='10' required/>
    </td>
  </tr>

  <tr>
    <td>Location</td>
    <td>
    <input type="text" name="txtsaloc" placeholder="Enter Location" required/>
    </td>
  </tr>

  <tr>
    <td>Password</td>
    <td>
    <input type="password" name="txtsapass" placeholder="********"  required/>
    </td>
  </tr>

  
  <tr>
  <td></td>
    <td>
    <input type="submit"  name="btnsubmit"  value="Submit" />
    <input type="reset" value="Clear" class="btn" />
    </td>
  </tr>

</table>
</fieldset>
</body>
</html>