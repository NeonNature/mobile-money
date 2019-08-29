<?php
session_start();
include('connect.php');

if($_SESSION['Role']!='Customer')
{
  echo "<script>window.alert('Please Login as Customer to Continue.')</script>";
  echo "<script>window.location='signin.php'</script>";
}
?>
<html>
<head>
    <title>Received History</title>
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
    <legend> Received History -Customer- </legend>
<table align=right>
<tr >
<td>
<input type="text" name="txtdata" placeholder="Search"/>
<input type="submit" name="btnsearch" value="Search"/>
</td>
</tr>
</table>
<br/><br/>
<hr/>
    <table align="center" cellpadding="5" border=2px>
    <?php

    $rid=$_SESSION['ID'];

    if(isset($_POST['btnsearch'])) 
    {
        
        $data=$_POST['txtdata'];
        $query="SELECT * FROM CustomerTransaction
                WHERE ReceiverID='$rid'
                AND ( SenderID LIKE '%$data%'
                OR TransDate LIKE '%$data%'
                OR CID LIKE '%$data%')
                " ;
                $ret=mysql_query($query);
                $count=mysql_num_rows($ret);
                $row=mysql_fetch_array($ret);
                $sid=$row['SenderID'];
                if (!isset($sid))
                {
                  $sid='';
                }



                $query2="SELECT ct.CID, c.PhoneNo, c.CustomerName, ct.Amount, ct.TransDate FROM Customer c, CustomerTransaction ct
                        WHERE ReceiverID='$sid'
                        AND ( SenderID LIKE '%$data%'
                         OR TransDate LIKE '%$data%'
                        OR CID LIKE '%$data%'
                        OR Amount LIKE '%$data%'
                        OR PhoneNo LIKE '%$data%'
                        OR CustomerName LIKE '%$data%'
                        OR c.CustomerID='$sid')                       
                        AND c.CustomerID=ct.SenderID";

                        $ret2=mysql_query($query2);
                        $count2=mysql_num_rows($ret2);

                if ($count2==0)
                {
                    echo "No Transaction Found!";
                }
                else
                {
                    echo "<tr>";
                    echo "<th>TransactionID</th>";
                    echo "<th>Sender PhoneNo</th>";
                    echo "<th>Sender Name</th>";
                    echo "<th>Amount</th>";
                    echo "<th>Date</th>";
                    echo "</tr>";
                    for ($i=0; $i < $count2; $i++)
                    {
                        $row2=mysql_fetch_array($ret2);
                        echo "<tr>";
                        echo "<td>" . $row2['CID'] . "</td>";
                        echo "<td>" . $row2['PhoneNo'] . "</td>";
                        echo "<td>" . $row2['CustomerName'] . "</td>";
                        echo "<td>" . $row2['Amount'] . "</td>";
                        echo "<td>" . $row2['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
    else
    {

               $query="SELECT ct.CID, c.PhoneNo, c.CustomerName, ct.Amount, ct.TransDate FROM Customer c, CustomerTransaction ct
                        WHERE ReceiverID='$rid'                  
                        AND c.CustomerID=ct.SenderID";

                        $ret=mysql_query($query);
                        $count=mysql_num_rows($ret);

                if ($count==0)
                {
                    echo "No Transaction Found!";
                }
                else
                {
                    echo "<tr>";
                    echo "<th>TransactionID</th>";
                    echo "<th>Sender PhoneNo</th>";
                    echo "<th>Sender Name</th>";
                    echo "<th>Amount</th>";
                    echo "<th>Date</th>";
                    echo "</tr>";
                    for ($i=0; $i < $count; $i++)
                    {              
                        $row=mysql_fetch_array($ret);         
                        echo "<tr>";
                        echo "<td>" . $row['CID'] . "</td>";
                        echo "<td>" . $row['PhoneNo'] . "</td>";
                        echo "<td>" . $row['CustomerName'] . "</td>";
                        echo "<td>" . $row['Amount'] . "</td>";
                        echo "<td>" . $row['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
    ?>
</table>
</fieldset>
</form>
</body>
</html>

