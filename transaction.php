<?php
session_start();
include('connect.php');

if(!isset($_SESSION['Role']))
{
	echo "<script>window.alert('Please Login to Continue.')</script>";
	echo "<script>window.location='signin.php'</script>";
}
//---------------------------------------------CustomerTransaction Part1------------------------------------------------
if(isset($_POST['btnc2c']))
{
     $sph=$_SESSION['PhNo'];
     $rph=$_POST['txtcph1'];
    $amount=$_POST['txta1'];
    $sid=$_SESSION['ID'];

      $check="SELECT * FROM Customer WHERE PhoneNo='$rph'";
     $checkret=mysql_query($check);
     $count=mysql_num_rows($checkret);
     $row=mysql_fetch_array($checkret);

     $check2="SELECT * FROM Customer WHERE PhoneNo='$sph'";
     $checkret2=mysql_query($check2);
    $row2=mysql_fetch_array($checkret2);
    $bal=$row2['CustomerBalance'];
    $ctype=$row2['CustomerTypeID'];

     
     $rid=$row['CustomerID'];         
     
       if($count==0)
       {
          echo "<script>window.alert('Invalid PhoneNo [ $rph ] !')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($sph == $rph)
       {
          echo "<script>window.alert('You cannot send to yourself!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($amount == "") 
      {
           echo "<script> window.alert('Please input something!')</script>";
      }


       elseif ($amount > $bal)
       {
        echo "<script>window.alert('You do not have enough money to perform this transaction!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }

       elseif ($amount < 500)
       {
        echo "<script>window.alert('The amount is too low to be performed! Minimum amount is 500!')</script>";
         echo"<script>window.location='transaction.php'</script>";
       }


       else 
       {

          $td=date('Y-m-d');

         $qcheck="SELECT * FROM CustomerTransaction
                    WHERE TransDate='$td' 
                    AND SenderID='$sid'";

          $ret=mysql_query($qcheck);
          $countr=mysql_num_rows($ret);

          if ($ctype==1 && $countr>5)
          {
             echo "<script>window.alert('Maximum Limit of 5 transactions reached! Upgrade for limit increasing or removal!')</script>";
            echo "<script>window.location='transaction.php'</script>";       
          }
          elseif ($ctype==2 && $countr>10)
          {
            echo "<script>window.alert('Maximum Limit of 5 transactions reached! Upgrade for limit removal!')</script>";
            echo"<script>window.location='transaction.php'</script>";
          }

          else {
       
        $update1="UPDATE Customer
          		SET CustomerBalance=(CustomerBalance-$amount)
          		WHERE PhoneNo='$sph'";

       $updateret=mysql_query($update1);


       $update2="UPDATE Customer
              SET CustomerBalance=(CustomerBalance+$amount)
              WHERE PhoneNo='$rph'";

       $updateret2=mysql_query($update2);

     


     $insert="INSERT INTO CustomerTransaction
        (ReceiverID, SenderID, Amount,TransDate)  values
       ('$rid', '$sid', '$amount','$td')";


       $insertret=mysql_query($insert);

       if($updateret && $updateret2 && $insertret)
       {
          echo"<script>window.alert('Transaction Succeeded!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       else
       {
          echo "<p>Transaction Error : " .mysql_error()."</p>";
       }
     }
     }
 }   

//----------------------------CustomerTransaction Part 2---------------------------------

 if(isset($_POST['btnup']))
{
     $sph=$_SESSION['PhNo'];
     $rph=$_POST['txtaph1'];
    $amount=$_POST['rdoi'];
    $sid=$_SESSION['ID'];

      $check="SELECT * FROM Agent WHERE PhoneNo='$rph'";
     $checkret=mysql_query($check);
     $count=mysql_num_rows($checkret);
     $row=mysql_fetch_array($checkret);

     $check2="SELECT * FROM Customer WHERE PhoneNo='$sph'";
     $checkret2=mysql_query($check2);
    $row2=mysql_fetch_array($checkret2);
    $bal=$row2['CustomerBalance'];

     
     $rid=$row['AgentID'];         
     
       if($count==0)
       {
          echo "<script>window.alert('Invalid PhoneNo [ $rph ] !')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($sph == $rph)
       {
          echo "<script>window.alert('You cannot send to yourself!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($amount == "") 
      {
           echo "<script> window.alert('Please input something!')</script>";
      }


       elseif ($amount > $bal)
       {
        echo "<script>window.alert('You do not have enough money to perform this transaction!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }

       elseif ($amount < 500)
       {
        echo "<script>window.alert('The amount is too low to be performed! Minimum amount is 500!')</script>";
         echo"<script>window.location='transaction.php'</script>";
       }


       else 
       {
       
        $update1="UPDATE Customer
              SET CustomerBalance=(CustomerBalance-$amount)
              WHERE PhoneNo='$sph'";

       $updateret=mysql_query($update1);


       $update2="UPDATE Agent
              SET AgentBalance=(AgentBalance+$amount)
              WHERE PhoneNo='$rph'";

       $updateret2=mysql_query($update2);

       $td=date('Y-m-d');


     $insert="INSERT INTO AgentTransaction
        (CustomerID, AgentID, Amount, Upgrade, TransDate)  values
       ('$sid', '$rid', '$amount', true,'$td')";


       $insertret=mysql_query($insert);

       if($updateret && $updateret2 && $insertret)
       {
          echo"<script>window.alert('Transaction Succeeded!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       else
       {
          echo "<p>Transaction Error : " .mysql_error()."</p>";
       }
     }
   }

   //----------------------------CustomerTransaction Part 3---------------------------------

 if(isset($_POST['btnc2p']))
{
     $sph=$_SESSION['PhNo'];
     $rph=$_POST['txtpph'];
    $amount=$_POST['txta2'];
    $sid=$_SESSION['ID'];

      $check="SELECT * FROM Partner WHERE PhoneNo='$rph'";
     $checkret=mysql_query($check);
     $count=mysql_num_rows($checkret);
     $row=mysql_fetch_array($checkret);

     $check2="SELECT * FROM Customer WHERE PhoneNo='$sph'";
     $checkret2=mysql_query($check2);
    $row2=mysql_fetch_array($checkret2);
    $bal=$row2['CustomerBalance'];
    

    $td=date('Y-m-d');

     
     $rid=$row['PartnerID'];         
     
       if($count==0)
       {
          echo "<script>window.alert('Invalid PhoneNo [ $rph ] !')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($sph == $rph)
       {
          echo "<script>window.alert('You cannot send to yourself!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($amount == "") 
      {
           echo "<script> window.alert('Please input something!')</script>";
      }


       elseif ($amount > $bal)
       {
        echo "<script>window.alert('You do not have enough money to perform this transaction!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }

       elseif ($amount < 500)
       {
        echo "<script>window.alert('The amount is too low to be performed! Minimum amount is 500!')</script>";
         echo"<script>window.location='transaction.php'</script>";
       }


       else 
       {        
       
        $update1="UPDATE Customer
              SET CustomerBalance=(CustomerBalance-$amount)
              WHERE PhoneNo='$sph'";

       $updateret=mysql_query($update1);


       $update2="UPDATE Partner
              SET PartnerBalance=(PartnerBalance+$amount)
              WHERE PhoneNo='$rph'";

       $updateret2=mysql_query($update2);

       


     $insert="INSERT INTO PartnerTransaction
        (CustomerID, PartnerID, Amount, TransDate)  values
       ('$sid', '$rid', '$amount', '$td')";


       $insertret=mysql_query($insert);

       if($updateret && $updateret2 && $insertret)
       {
          echo"<script>window.alert('Transaction Succeeded!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       else
       {
          echo "<p>Transaction Error : " .mysql_error()."</p>";
       }
     }
   }

//---------------------------------------------Agent Transaction------------------------------------------------
if(isset($_POST['btnp2c']))
{
     $sph=$_SESSION['PhNo'];
     $rph=$_POST['txtcph2'];
    $amount=$_POST['txta3'];
    $sid=$_SESSION['ID'];

      $check="SELECT * FROM Customer WHERE PhoneNo='$rph'";
     $checkret=mysql_query($check);
     $count=mysql_num_rows($checkret);
     $row=mysql_fetch_array($checkret);

     $check2="SELECT * FROM Agent WHERE PhoneNo='$sph'";
     $checkret2=mysql_query($check2);
    $row2=mysql_fetch_array($checkret2);
    $bal=$row2['AgentBalance'];

     
     $rid=$row['CustomerID'];         
     
       if($count==0)
       {
          echo "<script>window.alert('Invalid PhoneNo [ $rph ] !')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($sph == $rph)
       {
          echo "<script>window.alert('You cannot send to yourself!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($amount == "") 
      {
           echo "<script> window.alert('Please input something!')</script>";
      }


       elseif ($amount > $bal)
       {
        echo "<script>window.alert('You do not have enough money to perform this transaction!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }

       elseif ($amount < 500)
       {
        echo "<script>window.alert('The amount is too low to be performed! Minimum amount is 500!')</script>";
         echo"<script>window.location='transaction.php'</script>";
       }


       else 
       {
       
        $update1="UPDATE Agent
              SET AgentBalance=(AgentBalance-$amount)
              WHERE PhoneNo='$sph'";

       $updateret=mysql_query($update1);


       $update2="UPDATE Customer
              SET CustomerBalance=(CustomerBalance+$amount)
              WHERE PhoneNo='$rph'";

       $updateret2=mysql_query($update2);

       $td=date('Y-m-d');


     $insert="INSERT INTO AgentTransaction
        (CustomerID, AgentID, Amount, Upgrade, TransDate)  values
       ('$rid', '$sid', '$amount', false, '$td')";


       $insertret=mysql_query($insert);

       if($updateret && $updateret2 && $insertret)
       {
          echo"<script>window.alert('Transaction Succeeded!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       else
       {
          echo "<p>Transaction Error : " .mysql_error()."</p>";
       }
     }
 }   


//---------------------------------------------SuperAgent Transaction------------------------------------------------
if(isset($_POST['btns2a']))
{
     $sph=$_SESSION['PhNo'];
     $rph=$_POST['txtaph2'];
    $amount=$_POST['txta4'];
    $sid=$_SESSION['ID'];

      $check="SELECT * FROM Agent WHERE PhoneNo='$rph'";
     $checkret=mysql_query($check);
     $count=mysql_num_rows($checkret);
     $row=mysql_fetch_array($checkret);

     $check2="SELECT * FROM SuperAgent WHERE PhoneNo='$sph'";
     $checkret2=mysql_query($check2);
    $row2=mysql_fetch_array($checkret2);
    $bal=$row2['SuperAgentBalance'];

     
     $rid=$row['AgentID'];         
     
       if($count==0)
       {
          echo "<script>window.alert('Invalid PhoneNo [ $rph ] !')</script>";
          //echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($sph == $rph)
       {
          echo "<script>window.alert('You cannot send to yourself!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       elseif ($amount == "") 
      {
           echo "<script> window.alert('Please input something!')</script>";
      }


       elseif ($amount > $bal)
       {
        echo "<script>window.alert('You do not have enough money to perform this transaction!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }

       elseif ($amount < 500)
       {
        echo "<script>window.alert('The amount is too low to be performed! Minimum amount is 500!')</script>";
         echo"<script>window.location='transaction.php'</script>";
       }


       else 
       {
       
        $update1="UPDATE SuperAgent
              SET SuperAgentBalance=(SuperAgentBalance-$amount)
              WHERE PhoneNo='$sph'";

       $updateret=mysql_query($update1);


       $update2="UPDATE Agent
              SET AgentBalance=(AgentBalance+$amount)
              WHERE PhoneNo='$rph'";

       $updateret2=mysql_query($update2);

       $td=date('Y-m-d');


     $insert="INSERT INTO SuperAgentTransaction
        (AgentID, SuperAgentID, Amount, TransDate)  values
       ('$rid', '$sid', '$amount', '$td')";


       $insertret=mysql_query($insert);

       if($updateret && $updateret2 && $insertret)
       {
          echo"<script>window.alert('Transaction Succeeded!')</script>";
          echo"<script>window.location='transaction.php'</script>";
       }
       else
       {
          echo "<p>Transaction Error : " .mysql_error()."</p>";
       }
     }
 }   
//-------------------------------------------------------------------------
 
?>

<html>
<head>
	<title>Transaction</title>
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
        echo "<li><a class='active' href='transaction.php'>Transaction</a></li>";
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
  <form action="#" method="post" enctype="multipart/formdata">

  <?php

  if ($_SESSION['Role']=='Customer')
  {
    echo "
    <fieldset>
  <legend> CustomerTransaction </legend>
<table align=center>
	<tr>
		<td> Customer PhoneNo. </td>
		<td> <input type='text' name='txtcph1' placeholder='Enter Customer PhoneNo.' maxlength='10'/> </td>
	</tr>
  <tr>
    <td> Amount </td>
    <td> <input type='text' name='txta1' placeholder='Enter Amount' /> </td>
  </tr>
  <tr>
      <td></td>            
      <td>
        <input type='submit'   name='btnc2c'  value='Submit' />
        <input type='reset' value='Clear' />
      </td>
  </tr>
</table>
</fieldset>

<fieldset>
  <legend> Upgrade </legend>
<table align=center>
  <tr>
    <td> Agent PhoneNo. </td>
    <td> <input type='text' name='txtaph1' placeholder='Enter Agent PhoneNo.' maxlength='10'/> </td>
  </tr>
  <tr>
    <td> Type to be changed : </td>
    <td> 
      <input type='radio' name='rdoi'  value='1000' checked /> Silver
        <input type='radio' name='rdoi' value='5000' /> Golden
      </td>
  </tr>
  <tr>
      <td></td>            
      <td>
        <input type='submit'   name='btnup'  value='Submit' />
        <input type='reset' value='Clear' />
      </td>
  </tr>
</table>
</fieldset>

<fieldset>
  <legend> Payment </legend>
<table align=center>
  <tr>
    <td> Partner PhoneNo. </td>
    <td> <input type='text' name='txtpph' placeholder='Enter Partner PhoneNo.' maxlength='10'/> </td>
  </tr>
  <tr>
    <td> Amount </td>
    <td> <input type='text' name='txta2' placeholder='Enter Amount' /> </td>
  </tr>
  <tr>
      <td></td>            
      <td>
        <input type='submit'   name='btnc2p'  value='Submit' />
        <input type='reset' value='Clear' />
      </td>
  </tr>
</table>
</fieldset>
	";
}

if ($_SESSION['Role']=='Agent')
  {
    echo "
    <fieldset>
  <legend> AgentTransaction </legend>
<table align=center>
  <tr>
    <td> Customer PhoneNo. </td>
    <td> <input type='text' name='txtcph2' placeholder='Enter Customer PhoneNo.' required maxlength='10'/> </td>
  </tr>
  <tr>
    <td> Amount </td>
    <td> <input type='text' name='txta3' placeholder='Enter Amount' required/> </td>
  </tr>
  <tr>
      <td></td>            
      <td>
        <input type='submit'   name='btnp2c'  value='Submit' />
        <input type='reset' value='Clear' />
      </td>
  </tr>
</table>
</fieldset>";
}

if ($_SESSION['Role']=='SuperAgent')
  {
    echo "
    <fieldset>
  <legend> SuperAgentTransaction </legend>
<table align=center>
  <tr>
    <td> Agent PhoneNo. </td>
    <td> <input type='text' name='txtaph2' placeholder='Enter Agent PhoneNo.' required maxlength='10'/> </td>
  </tr>
  <tr>
    <td> Amount </td>
    <td> <input type='text' name='txta4' placeholder='Enter Amount' required/> </td>
  </tr>
  <tr>
      <td></td>            
      <td>
        <input type='submit'   name='btns2a'  value='Submit' />
        <input type='reset' value='Clear' />
      </td>
  </tr>
</table>
</fieldset>";
}

if ($_SESSION['Role']=='Partner')
{
  echo "<fieldset>
  <legend> Transaction </legend>
  <p align=center> There are no transactions that can be done by Partners </p>
  </fieldset>";
}
if ($_SESSION['Role']=='Admin')
{
  echo "<fieldset>
  <legend> Transaction </legend>
  <p align=center> There are no transactions that can be done by Admin </p>
  </fieldset>";
}

  ?>


	

</body>
</html>