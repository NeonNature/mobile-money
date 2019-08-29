<?php
session_start();
include('connect.php');
if(isset($_POST['btnsubmit']))
{
if(strcmp($_SESSION['code'],$_POST['code'])!=0)
{
  echo"<script>window.alert('Security does not match!')</script>";
}
else
{
     $cname=$_POST['txtcname'];
     $cbal=0;
     $cph=$_POST['txtcph'];
     $cloc=$_POST['txtcloc'];
     $cpass=$_POST['txtcpass'];
     $ci=1;
     $ctid=1;


     $check="SELECT * FROM Partner WHERE PhoneNo='$cph'";
     $checkret=mysql_query($check);
     $count1=mysql_num_rows($checkret);

     $check="SELECT * FROM Customer WHERE PhoneNo='$cph'";
     $checkret=mysql_query($check);
     $count2=mysql_num_rows($checkret);

     $check="SELECT * FROM Agent WHERE PhoneNo='$cph'";
     $checkret=mysql_query($check);
     $count3=mysql_num_rows($checkret);

     $check="SELECT * FROM SuperAgent WHERE PhoneNo='$cph'";
     $checkret=mysql_query($check);
     $count4=mysql_num_rows($checkret);

     

     $mptcheck="SELECT * FROM MPT WHERE PhoneNo='$cph'";
     $mptcheckret=mysql_query($mptcheck);
     $mptcount=mysql_num_rows($mptcheckret);

     $finalcount=$count1+$count2+$count3+$count4;

       if($finalcount<>0)
       {
          echo "<script>window.alert('The account for this PhoneNo [ $cph ] already exists!')</script>";
          echo"<script>window.location='customer_signup.php'</script>";
       }
       elseif ($mptcount==0)
        {
          echo "<script>window.alert('This PhoneNo [ $cph ] is not MPT PhoneNo!')</script>";
          echo"<script>window.location='customer_signup.php'</script>";
       }
       else
       {
        $insert="INSERT INTO Customer
          (CustomerName, CustomerBalance, PhoneNo, Location, Password, Informed, CustomerTypeID)
          VALUES 
          ('$cname','$cbal','$cph','$cloc','$cpass', '$ci','$ctid')";

       $insertret=mysql_query($insert);
       if($insertret)
       {
          echo"<script>window.alert('Customer Account Created!')</script>";
          echo"<script>window.location='signin.php'</script>";
       }
       else
       {
          echo "<p>Error in Customer Registration : " .mysql_error()."</p>";
       }
     }
   }
 }

?>


<html>
<head>
	<title>Customer Sign-Up</title>
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
        echo "<li><a class='active' href='customer_signup.php'>Customer Sign Up</a></li>";
        echo "<li><a href='signin.php'>Sign In</a></li>";
      }
      else if ($_SESSION['Role']=='Admin')
      {
        echo "<li><a href='admin_panel.php'>Admin Panel</a></li>";
      }
      else if ($_SESSION['Role']=='Customer' || $_SESSION['Role']=='Agent' || $_SESSION['Role']=='SuperAgent')
      {
        echo "<li><a href='transaction.php'>Transaction</a></li>";
      }
      else if ($_SESSION['Role']=='Customer' || $_SESSION['Role']=='Agent' || $_SESSION['Role']=='SuperAgent' || $_SESSION['Role']=='Partner')
      {
        echo "<li><a class='active' href='history.php'>History</a></li>";
      }
      else if ($_SESSION['Role']=='Agent')
      {
        echo "<li><a href='inform.php'>Inform</a></li>";
      }

      if (isset($_SESSION['Role']))
      {
        echo "<li><a href='logout.php'>Logout</a></li>";
      }
      ?>
      
  </ul> 
<form action="customer_signup.php" method="post" enctype="multipart/formdata">
<fieldset>
<legend>Enter Customer information :</legend>
<table align="center" cellspacing="3">

  <tr>
    <td width="145">Name</td>
    <td width="208">
    <input type="text" name="txtcname" placeholder="Enter Name" required/>
    </td>
  </tr>
  
  <tr>
    <td>Phone No.</td>
    <td>
    <input type="text" name="txtcph" placeholder="Enter PhoneNo." maxlength="10" required/>
    </td>
  </tr>

  <tr>
    <td>Location</td>
    <td>
    <input type="text" name="txtcloc" placeholder="Enter Location" required/>
    </td>
  </tr>

  <tr>
    <td>Password</td>
    <td>
    <input type="password" name="txtcpass" placeholder="********"  required/>
    </td>
  </tr>

  <tr>
    <td colspan="2" align="center">
    <img src="generatecaptcha.php?rand=<?php echo rand(); ?>" id='captchaimg'/>
    <a href='javascript: refreshCaptcha();'>Refresh
    </a>
    <script language='javascript' type='text/javascript'>
	function refreshCaptcha()
	{
		var img =document.images['captchaimg'];
		img.src= img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
	}	
	</script>
    </td>
  </tr>
  
  <tr>
    <td>Security Answer</td>
    <td>
    <input type="text" name="code" placeholder="Enter Security Answer" required />
    </td>
  </tr>
  
  <tr>
  <td></td>
    <td>
    <input type="submit"  name="btnsubmit"  value="Submit" />
    <input type="reset" value="Clear" class="btn" />
    </td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td colspan=2 align="center">
        <p> Already have an account? <a href="signin.php"> Sign In </a> </p>
    </td>
  </tr>

</table>
</fieldset>
</body>
</html>