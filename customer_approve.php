<?php
session_start();
include('connect.php');

$AdminID=$_SESSION['AdminID'];

if (isset($AdminID))
{
	$CustomerID=$_GET['cid'];

	$check="SELECT * FROM Customer
			WHERE CustomerID='$CustomerID'";

	$check_ret=mysql_query($check);
	$count=mysql_num_rows($check_ret);

	if ($count==0)
	{
		echo "<script>window.alert('Invalid request')</script>";
		echo "<script>window.location='customertype_change.php'</script>";
	}
	else
	{
			$check="SELECT Informed FROM Customer
					WHERE CustomerID='$CustomerID'";
			$checkret=mysql_query($check);
			$row=mysql_fetch_array($checkret);
			

			if($row['Informed']==2)
			{
			 $update="UPDATE Customer
          		SET CustomerTypeID='2',
          		 	Informed='1'
          		WHERE CustomerID='$CustomerID'";
          	}

          	if($row['Informed']==3)
			{
			 $update="UPDATE Customer
          		SET CustomerTypeID='3',
          		 	Informed='1'
          		WHERE CustomerID='$CustomerID'";
          	}

       $updateret=mysql_query($update);
       if($updateret)
       {
          echo"<script>window.alert('Successfully Changed!')</script>";
          echo"<script>window.location='customertype_change.php'</script>";
       }
       else
       {
          echo "<p>Error in Changing CustomerType : " .mysql_error()."</p>";
       }
	}
}
else
{
	echo "<script>window.alert('Please Login as Admin to Continue')</script>";
	echo "<script>window.location='signin.php'</script>";
}
?>