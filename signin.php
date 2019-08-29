<?php
session_start();
include('connect.php');

if(isset($_POST['btnsignin']))
{
	$ph=$_POST['txtph'];
	$pass=$_POST['txtpass'];

	$ph=mysql_real_escape_string($ph);
	$pass=mysql_real_escape_string($pass);

	$check="SELECT * FROM Customer
			WHERE PhoneNo='$ph'
			AND Password='$pass'";

	$ret=mysql_query($check);
	$count=mysql_num_rows($ret);
	$row=mysql_fetch_array($ret);

	
	if ($count==1)
	{
		$_SESSION['ID']=$row['CustomerID'];		
		$_SESSION['Name']=$row['CustomerName'];				
		$_SESSION['Balance']=$row['CustomerBalance'];
		$_SESSION['PhNo']=$row['PhoneNo'];
		$_SESSION['Role']="Customer";

		$Name=$_SESSION['Name'];

		echo "<script> window.alert('Welcome $Name')</script>";
		echo "<script> window.location='transaction.php'</script>";

	}

	//-----------------------------------

	$check="SELECT * FROM Agent
			WHERE PhoneNo='$ph'
			AND Password='$pass'";

	$ret=mysql_query($check);
	$count=mysql_num_rows($ret);
	$row=mysql_fetch_array($ret);

	
	if ($count==1)
	{
		$_SESSION['ID']=$row['AgentID'];		
		$_SESSION['Name']=$row['AgentName'];				
		$_SESSION['Balance']=$row['AgentBalance'];
		$_SESSION['PhNo']=$row['PhoneNo'];
		$_SESSION['Role']="Agent";

		$Name=$_SESSION['Name'];

		echo "<script> window.alert('Welcome $Name')</script>";
		echo "<script> window.location='transaction.php'</script>";

	}

	//-----------------------------------

	$check="SELECT * FROM SuperAgent
			WHERE PhoneNo='$ph'
			AND Password='$pass'";

	$ret=mysql_query($check);
	$count=mysql_num_rows($ret);
	$row=mysql_fetch_array($ret);

	
	if ($count==1)
	{
		$_SESSION['ID']=$row['SuperAgentID'];		
		$_SESSION['Name']=$row['SuperAgentName'];				
		$_SESSION['Balance']=$row['SuperAgentBalance'];
		$_SESSION['PhNo']=$row['PhoneNo'];
		$_SESSION['Role']="SuperAgent";

		$Name=$_SESSION['Name'];

		echo "<script> window.alert('Welcome $Name')</script>";
		echo "<script> window.location='transaction.php'</script>";

	}

	//-----------------------------------

	$check="SELECT * FROM Partner
			WHERE PhoneNo='$ph'
			AND Password='$pass'";

	$ret=mysql_query($check);
	$count=mysql_num_rows($ret);
	$row=mysql_fetch_array($ret);

	
	if ($count==1)
	{
		$_SESSION['ID']=$row['PartnerID'];		
		$_SESSION['Name']=$row['PartnerName'];				
		$_SESSION['Balance']=$row['PartnerBalance'];
		$_SESSION['PhNo']=$row['PhoneNo'];
		$_SESSION['Role']="Partner";

		$Name=$_SESSION['Name'];

		echo "<script> window.alert('Welcome $Name')</script>";
		echo "<script> window.location='history.php'</script>";

	}

	//-----------------------------------

	$check="SELECT * FROM Admin
			WHERE Username='$ph'
			AND Password='$pass'";

	$ret=mysql_query($check);
	$count=mysql_num_rows($ret);
	$row=mysql_fetch_array($ret);

	
	if ($count==1)
	{
		$_SESSION['AdminID']=$row['AdminID'];		
		$_SESSION['Name']=$row['Username'];
		$_SESSION['Role']="Admin";

		$Name=$_SESSION['Name'];

		echo "<script> window.alert('Welcome $Name')</script>";
		echo "<script> window.location='admin_panel.php'</script>";

	}

	//------------

	if ($count!==1)
	{
		echo "<script>window.alert('PhoneNo or Password Incorrect.')</script>";
		echo "<script>window.location='signin.php'</script>";
	}


}


?>

<html>
<head>
	<title>
		Sign-In
	</title>
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
        echo "<li><a class='active' href='signin.php'>Sign In</a></li>";
      }
      else if ($_SESSION['Role']=='Admin')
      {
        echo "<li><a href='admin_panel.php'>Admin Panel</a></li>";
      }
      else if ($_SESSION['Role']=='Customer' || $_SESSION['Role']=='Agent' || $_SESSION['Role']=='SuperAgent')
      {
        echo "<li><a href='transaction.php'>Transaction</a></li>";
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
	<form action="signin.php" method="post">
		<fieldset> 
				<legend>
						 Sign-In 
				</legend>
				<table align="center" cellspacing="8">
					<tr>
						<td>
							Phone No.
						</td>
						<td>
							 : <input type="text" name="txtph" placeholder="PhoneNo" maxlength="10">
						</td>
					</tr>
					<tr>
						<td>
				 			Password 
						</td>
						<td> : 
 							<input type="password" name="txtpass" placeholder="********" required />
    
						</td>
					</tr>


<tr align="center">
	<td> </td>
	<td>
		<input type='submit'  name='btnsignin'  value='Sign In' />
	 
		<input type="reset" value="Clear" />
	</td>
</tr>
<tr></tr>
<tr>
	
	<td colspan=2>
		<p> Don't have a Customer account?  <a href="customer_signup.php"> Sign Up! </a> </p>
	</td>
</tr>


</table>
</form>
</fieldset>
</body>
</html>