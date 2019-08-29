<?php
session_start();
include('connect.php');

if(($_SESSION['Role']!='Customer') AND ($_SESSION['Role']!='Agent') AND ($_SESSION['Role']!='SuperAgent'))
{
  echo "<script>window.alert('Please Login as Customer, Agent or SuperAgent to Continue.')</script>";
  echo "<script>window.location='signin.php'</script>";
}
?>
<html>
<head>
    <title>TopUp History</title>
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
    <legend> TopUp History </legend>
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
        $query="SELECT * FROM AgentTransaction
                WHERE CustomerID='$rid'
                AND ( AgentID LIKE '%$data%'
                OR TransDate LIKE '%$data%'
                OR AID LIKE '%$data%')
                AND Upgrade=false
                " ;
                $ret=mysql_query($query);
                $count=mysql_num_rows($ret);
                $row=mysql_fetch_array($ret);
                $sid=$row['AgentID'];
                if (!isset($sid))
                {
                  $sid='';
                }



                $cq="SELECT at.AID, a.PhoneNo, a.AgentName, at.Amount, at.TransDate FROM Agent a, AgentTransaction at
                        WHERE CustomerID='$rid'
                        AND ( at.AgentID LIKE '%$data%'
                         OR at.TransDate LIKE '%$data%'
                        OR at.AID LIKE '%$data%'
                        OR at.Amount LIKE '%$data%'
                        OR a.PhoneNo LIKE '%$data%'
                        OR a.AgentName LIKE '%$data%'
                        OR a.AgentID='$sid')                       
                        AND a.AgentID=at.AgentID
                        AND at.Upgrade=false";

                        $ret2=mysql_query($cq);
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
                        echo "<td>" . $row2['AID'] . "</td>";
                        echo "<td>" . $row2['PhoneNo'] . "</td>";
                        echo "<td>" . $row2['AgentName'] . "</td>";
                        echo "<td>" . $row2['Amount'] . "</td>";
                        echo "<td>" . $row2['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
    else
    {

               $cq="SELECT at.AID, a.PhoneNo, a.AgentName, at.Amount, at.TransDate FROM Agent a, AgentTransaction at
                        WHERE CustomerID='$rid'                  
                        AND a.AgentID=at.AgentID
                        AND Upgrade=false";

                        $ret=mysql_query($cq);
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
                        echo "<td>" . $row['AID'] . "</td>";
                        echo "<td>" . $row['PhoneNo'] . "</td>";
                        echo "<td>" . $row['AgentName'] . "</td>";
                        echo "<td>" . $row['Amount'] . "</td>";
                        echo "<td>" . $row['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
}
    

elseif ($_SESSION['Role']=='Agent')
{
  echo "
<fieldset>
    <legend> TopUp History -Customer- </legend>
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
        $query="SELECT * FROM AgentTransaction
                WHERE AgentID='$sid'
                AND ( CustomerID LIKE '%$data%'
                OR TransDate LIKE '%$data%'
                OR AID LIKE '%$data%')
                AND Upgrade=false
                " ;
                $ret=mysql_query($query);
                $count=mysql_num_rows($ret);
                $row=mysql_fetch_array($ret);
                $rid=$row['CustomerID'];
                if (!isset($rid))
                {
                  $rid='';
                }



                $aq1="SELECT at.AID, c.PhoneNo, c.CustomerName, at.Amount, at.TransDate FROM Customer c, AgentTransaction at
                        WHERE AgentID='$sid'
                        AND ( at.CustomerID LIKE '%$data%'
                         OR at.TransDate LIKE '%$data%'
                        OR at.AID LIKE '%$data%'
                        OR at.Amount LIKE '%$data%'
                        OR c.PhoneNo LIKE '%$data%'
                        OR c.CustomerName LIKE '%$data%'
                        OR c.CustomerID='$rid')                       
                        AND c.CustomerID=at.CustomerID
                        AND at.Upgrade=false";

                        $ret2=mysql_query($aq1);
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
                        echo "<td>" . $row2['AID'] . "</td>";
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

              $aq1="SELECT at.AID, c.PhoneNo, c.CustomerName, at.Amount, at.TransDate 
               FROM Customer c, AgentTransaction at
                        WHERE AgentID='$sid'                  
                        AND c.CustomerID=at.AgentID
                        AND Upgrade=false";

                        $ret=mysql_query($aq1);
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
                        echo "<td>" . $row['AID'] . "</td>";
                        echo "<td>" . $row['PhoneNo'] . "</td>";
                        echo "<td>" . $row['CustomerName'] . "</td>";
                        echo "<td>" . $row['Amount'] . "</td>";
                        echo "<td>" . $row['TransDate'] . "</td>";
                        echo "</tr>";
                    }

                   
                }


    } 

    echo "
    </table>


    </fieldset>
<fieldset>
    <legend> TopUp History -SuperAgent- </legend>
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
        $query="SELECT * FROM SuperAgentTransaction
                WHERE AgentID='$rid'
                AND ( AgentID LIKE '%$data%'
                OR TransDate LIKE '%$data%'
                OR SAID LIKE '%$data%')
                " ;
                $ret=mysql_query($query);
                $count=mysql_num_rows($ret);
                $row=mysql_fetch_array($ret);
                $sid=$row['SuperAgentID'];
                if (!isset($sid))
                {
                  $sid='';
                }



                $aq2="SELECT sat.SAID, sa.PhoneNo, sa.SuperAgentName, sat.Amount, sat.TransDate FROM SuperAgent sa, SuperAgentTransaction sat
                        WHERE AgentID='$rid'
                        AND ( sat.SuperAgentID LIKE '%$data%'
                         OR sat.TransDate LIKE '%$data%'
                        OR sat.SAID LIKE '%$data%'
                        OR sat.Amount LIKE '%$data%'
                        OR sa.PhoneNo LIKE '%$data%'
                        OR sa.SuperAgentName LIKE '%$data%'
                        OR sa.SuperAgentID='$sid')                       
                        AND sa.SuperAgentID=sat.SuperAgentID";

                        $ret2=mysql_query($aq2);
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
                        echo "<td>" . $row2['SAID'] . "</td>";
                        echo "<td>" . $row2['PhoneNo'] . "</td>";
                        echo "<td>" . $row2['SuperAgentName'] . "</td>";
                        echo "<td>" . $row2['Amount'] . "</td>";
                        echo "<td>" . $row2['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
    else
    {

               $aq2="SELECT sat.SAID, sa.PhoneNo, sa.SuperAgentName, sat.Amount, sat.TransDate FROM SuperAgent sa, SuperAgentTransaction sat
                        WHERE AgentID='$rid'                  
                        AND sa.SuperAgentID=sat.SuperAgentID";

                        $ret=mysql_query($aq2);
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
                        echo "<td>" . $row['SAID'] . "</td>";
                        echo "<td>" . $row['PhoneNo'] . "</td>";
                        echo "<td>" . $row['SuperAgentName'] . "</td>";
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
    <legend> TopUp History -Agent- </legend>
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
        $query="SELECT * FROM SuperAgentTransaction
                WHERE SuperAgentID='$sid'
                AND ( AgentID LIKE '%$data%'
                OR TransDate LIKE '%$data%'
                OR SAID LIKE '%$data%')
                " ;
                $ret=mysql_query($query);
                $count=mysql_num_rows($ret);
                $row=mysql_fetch_array($ret);
                $rid=$row['AgentID'];
                if (!isset($rid))
                {
                  $rid='';
                }



                $sq="SELECT sat.SAID, a.PhoneNo, a.AgentName, sat.Amount, sat.TransDate FROM Agent a, SuperAgentTransaction sat
                        WHERE SuperAgentID='$sid'
                        AND ( sat.AgentID LIKE '%$data%'
                         OR sat.TransDate LIKE '%$data%'
                        OR sat.SAID LIKE '%$data%'
                        OR sat.Amount LIKE '%$data%'
                        OR a.PhoneNo LIKE '%$data%'
                        OR a.AgentName LIKE '%$data%'
                        OR a.AgentID='$rid')                       
                        AND a.AgentID=sat.AgentID";

                        $ret2=mysql_query($sq);
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
                        echo "<td>" . $row2['SAID'] . "</td>";
                        echo "<td>" . $row2['PhoneNo'] . "</td>";
                        echo "<td>" . $row2['AgentName'] . "</td>";
                        echo "<td>" . $row2['Amount'] . "</td>";
                        echo "<td>" . $row2['TransDate'] . "</td>";
                        echo "</tr>";
                    }
                }
    } 
    else
    {

              $sq="SELECT sat.SAID, a.PhoneNo, a.AgentName, sat.Amount, sat.TransDate FROM Agent a, SuperAgentTransaction sat
                        WHERE SuperAgentID='$sid'                  
                        AND a.AgentID=sat.AgentID";

                        $ret=mysql_query($sq);
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
                        echo "<td>" . $row['SAID'] . "</td>";
                        echo "<td>" . $row['PhoneNo'] . "</td>";
                        echo "<td>" . $row['AgentName'] . "</td>";
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

