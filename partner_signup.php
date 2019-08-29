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
     $pname=$_POST['txtpname'];
     $pph=$_POST['txtpph'];
     $ploc=$_POST['txtploc'];
     $ppass=$_POST['txtppass'];
     $ptid=$_POST['rdopt'];


     $check="SELECT * FROM Partner WHERE PhoneNo='$pph'";
     $checkret=mysql_query($check);
     $count1=mysql_num_rows($checkret);

     $check="SELECT * FROM Customer WHERE PhoneNo='$pph'";
     $checkret=mysql_query($check);
     $count2=mysql_num_rows($checkret);

     $check="SELECT * FROM Agent WHERE PhoneNo='$pph'";
     $checkret=mysql_query($check);
     $count3=mysql_num_rows($checkret);

     $check="SELECT * FROM SuperAgent WHERE PhoneNo='$pph'";
     $checkret=mysql_query($check);
     $count4=mysql_num_rows($checkret);

     $mptcheck="SELECT * FROM MPT WHERE PhoneNo='$pph'";
     $mptcheckret=mysql_query($mptcheck);
     $mptcount=mysql_num_rows($mptcheckret);

     $finalcount=$count1+$count2+$count3+$count4;

       if($finalcount<>0)
       {
          echo "<script>window.alert('The account for this PhoneNo [ $pph ] already exists!')</script>";
          echo"<script>window.location='partner_signup.php'</script>";
       }
       elseif ($mptcount==0)
        {
          echo "<script>window.alert('This PhoneNo [ $pph ] is not MPT PhoneNo!')</script>";
          echo"<script>window.location='partner_signup.php'</script>";
       }
       else
       {
        $insert="INSERT INTO Partner
          (PartnerName, PartnerBalance, PhoneNo, Location, Password, PartnerTypeID)
          VALUES 
          ('$pname', 0, '$pph','$ploc','$ppass','$ptid')";

       $insertret=mysql_query($insert);
       if($insertret)
       {
          echo"<script>window.alert('Partner Account Created!')</script>";
          echo"<script>window.location='admin_panel.php'</script>";
       }
       else
       {
          echo "<p>Error in Partner Registration : " .mysql_error()."</p>";
       }
     }
   }
 

?>


<html>
<head>
  <title>Partner Sign-Up</title>
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
<form action="partner_signup.php" method="post" enctype="multipart/formdata">
<fieldset>
<legend>Enter Partner information :</legend>
<table align="center" cellspacing="3">

  <tr>
    <td width="145">Name</td>
    <td width="208">
    <input type="text" name="txtpname" placeholder="Enter Name" required/>
    </td>
  </tr>
  
  <tr>
    <td>Phone No.</td>
    <td>
    <input type="text" name="txtpph" placeholder="Enter PhoneNo." maxlength='10' required/>
    </td>
  </tr>

  <tr>
    <td>Location</td>
    <td>
    <input type="text" name="txtploc" placeholder="Enter Location" required/>
    </td>
  </tr>

  <tr>
    <td>Password</td>
    <td>
    <input type="password" name="txtppass" placeholder="********"  required/>
    </td>
  </tr>

  <tr>
    <td>Partner Type</td>
    <td>
    <input type="radio" name="rdopt"  value="1" checked />Restaurant
    <input type="radio" name="rdopt" value="2" />Hotel
    <input type="radio" name="rdopt" value="3" />Supermarket
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