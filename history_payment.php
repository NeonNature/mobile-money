<?php
session_start();
include('connect.php');

if(($_SESSION['Role']!='Customer') AND ($_SESSION['Role']!='Partner'))
{
  echo "<script>window.alert('Please Login as Customer or Partner to Continue.')</script>";
  echo "<script>window.location='signin.php'</script>";
}
?>
<html>
<head>
    <title>Payment History</title>
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

<?php

if ($_SESSION['Role']=='Customer')
{
echo "
<fieldset>
    <legend> Payment History </legend>
<table align=right>
<tr >
<td>
<input type='text' name='txtdata' placeholder='Search'/>
<input type='submit' name='btnsearch' value='Search'/>
</td>
</tr>
</table>
<br/><br/>
<hr/>
    <table align='center' cellpadding='5' border=2px>";
    

    $sid=$_SESSION['ID'];

    if(isset($_POST['btnsearch'])) 
    {
        
        $data=$_POST['txtdata'];
        $query="SELECT * FROM PartnerTransaction
                WHERE CustomerID='$sid'
                AND ( PartnerID LIKE '%$data%'
                OR TransDate LIKE '%$data%'
                OR PID LIKE '%$data%')
                " ;
                $ret=mysql_query($query);
                $count=mysql_num_rows($ret);
                $row=mysql_fetch_array($ret);
                $rid=$row['PartnerID'];
                if (!isset($rid))
                {
                  $rid='';
                }



                $query2="SELECT pt.PID, p.PhoneNo, p.PartnerName, pt.Amount, pt.TransDate FROM Partner p, PartnerTransaction pt
                        WHERE CustomerID='$sid'
                        AND ( pt.PartnerID LIKE '%$data%'
                         OR pt.TransDate LIKE '%$data%'
                        OR pt.PID LIKE '%$data%'
                        OR pt.Amount LIKE '%$data%'
                        OR p.PhoneNo LIKE '%$data%'
                        OR p.PartnerName LIKE '%$data%'
                        OR p.PartnerID='$rid')                       
                        AND p.PartnerID=pt.PartnerID";

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
                    echo "<th>Receiver PhoneNo</th>";
                    echo "<th>Receiver Name</th>";
                    echo "<th>Amount</th>";
                    echo "<th>Date</th>";
                    echo "</tr>";
                    for ($i=0; $i < $count2; $i++)
                    {
                        $row2=mysql_fetch_array($ret2);
                        echo "<tr>";
                        echo "<td>" . $row2['PID'] . "</td>";
                        echo "<td>" . $row2['PhoneNo'] . "</td>";
                        echo "<td>" . $row2['PartnerName'] . "</td>";
                        echo "<td>" . $row2['Amount'] . "</td>";
                        echo "<td>" . $row2['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
    else
    {

               $query="SELECT pt.PID, p.PhoneNo, p.PartnerName, pt.Amount, pt.TransDate FROM Partner p, PartnerTransaction pt
                        WHERE CustomerID='$sid'                  
                        AND p.PartnerID=pt.PartnerID";

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
                    echo "<th>Receiver PhoneNo</th>";
                    echo "<th>Receiver Name</th>";
                    echo "<th>Amount</th>";
                    echo "<th>Date</th>";
                    echo "</tr>";
                    for ($i=0; $i < $count; $i++)
                    {              
                        $row=mysql_fetch_array($ret);         
                        echo "<tr>";
                        echo "<td>" . $row['PID'] . "</td>";
                        echo "<td>" . $row['PhoneNo'] . "</td>";
                        echo "<td>" . $row['PartnerName'] . "</td>";
                        echo "<td>" . $row['Amount'] . "</td>";
                        echo "<td>" . $row['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
    
}
else
{
  echo "
<fieldset>
    <legend> Payment History </legend>
<table align=right>
<tr >
<td>
<input type='text' name='txtdata' placeholder='Search'/>
<input type='submit' name='btnsearch' value='Search'/>
</td>
</tr>
</table>
<br/><br/>
<hr/>
    <table align='center' cellpadding='5' border=2px>";
    

    $rid=$_SESSION['ID'];

    if(isset($_POST['btnsearch'])) 
    {
        
        $data=$_POST['txtdata'];
        $query="SELECT * FROM PartnerTransaction
                WHERE PartnerID='$rid'
                AND ( CustomerID LIKE '%$data%'
                OR TransDate LIKE '%$data%'
                OR PID LIKE '%$data%')
                " ;
                $ret=mysql_query($query);
                $count=mysql_num_rows($ret);
                $row=mysql_fetch_array($ret);
                $sid=$row['CustomerID'];
                if (!isset($sid))
                {
                  $sid='';
                }



                $query2="SELECT pt.PID, c.PhoneNo, c.CustomerName, pt.Amount, pt.TransDate FROM Customer c, PartnerTransaction pt
                        WHERE CustomerID='$sid'
                        AND ( pt.PartnerID LIKE '%$data%'
                         OR pt.TransDate LIKE '%$data%'
                        OR pt.PID LIKE '%$data%'
                        OR pt.Amount LIKE '%$data%'
                        OR c.PhoneNo LIKE '%$data%'
                        OR c.CustomerName LIKE '%$data%'
                        OR c.CustomerID='$sid')                       
                        AND c.CustomerID=pt.CustomerID";

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
                        echo "<td>" . $row2['PID'] . "</td>";
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

               $query="SELECT pt.PID, c.PhoneNo, c.CustomerName, pt.Amount, pt.TransDate FROM Customer c, PartnerTransaction pt
                        WHERE PartnerID='$rid'                  
                        AND c.CustomerID=pt.CustomerID";

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
                        echo "<td>" . $row['PID'] . "</td>";
                        echo "<td>" . $row['PhoneNo'] . "</td>";
                        echo "<td>" . $row['CustomerName'] . "</td>";
                        echo "<td>" . $row['Amount'] . "</td>";
                        echo "<td>" . $row['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
}
?>
</table>
</fieldset>
</form>
</body>
</html>

