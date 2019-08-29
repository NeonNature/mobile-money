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

	?>



<html>
<head>
	<title>CustomerType Change</title>
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
<form action="customertype_change.php" method="post" enctype="multipart/formdata">
<?php
$select="SELECT * FROM Customer
	WHERE Informed!=1";
$ret=mysql_query($select);
$count=mysql_num_rows($ret);

if ($count!=0)
{

echo "<fieldset> <legend> CustomerType Change </legend> <table align=center border='2px' cellpadding='2px'>
	<tr>
		<th>CustomerName</th>
		<th>PhoneNo</th>
		<th>Location</th>
		<th>Desired Type</th>
		<th>Current Type</th>
		<th>Action</th>
	</tr>";

	for($i=0;$i<$count;$i++)
	{
	$row=mysql_fetch_array($ret);
	$cid=$row['CustomerID'];
	echo "<tr>";
	echo "<td>" . $row['CustomerName'] . "</td>";
	echo "<td>" . $row['PhoneNo'] . "</td>";
	echo "<td>" . $row['Location'] . "</td>";

	if ($row['Informed']==2)
	{
		echo "<td> Silver </td>";
	}
	else
	{
		echo "<td> Golden </td>";
	}

	if ($row['CustomerTypeID']==1)
	{
		echo "<td> Normal </td>";
	}
	elseif ($row['CustomerTypeID']==2)
	{
		echo "<td> Silver </td>";
	}
	else
	{
		echo "<td> Golden </td>";
	}
	
	
	echo "<td> <a href='customer_approve.php?cid=$cid'>Approve</a></td>";
	echo "</tr> </table> </fieldset>";
	}
}
else
{
	echo " <fieldset> <legend> CustomerType Change </legend> <p align=center> No new type change requests. </p> </fieldset>";
}
?>


</body>
</html>