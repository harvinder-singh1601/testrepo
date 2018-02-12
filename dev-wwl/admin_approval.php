<?php include_once 'other_header.php';
include 'dbConfig.php';
if(isset($_REQUEST['approve']))
{
    $total=$_REQUEST['total'];
    for($j=1;$j<$total;$j=$j+1)
    {
        if($_REQUEST['check_'.$j])
        {
            $update="update charity_under_user set Approved='Yes' where ID='".$_REQUEST['check_'.$j]."'";
            MYSQLI_QUERY($DBcon,$update) or die("Cannot Execute Query".mysqli_error($DBcon));
            
            $update_user_charity="update user_charity set Approved='Yes' where Charity_ID='".$_REQUEST['check_'.$j]."'";
            mysqli_query($DBcon,$update_user_charity) or die("Cannot Execute Query");
            
             $email=$_REQUEST['useremail_'.$j];
            
             $subject ="Your Charity - ".$_REQUEST['charityname'.$j]." is Approved";
            $to =$email;
            $mailContent = "";
            $mailContent .= "Hello,<br><br> 
            Your Charity - ".$_REQUEST['charityname'.$j]." is approved by our site admin so now you are  able to publish the game associated with  this charity.<br><br>Thanks,<br><br>Team WinWin";
            $headers.= "From: support@winwin.com\n";
      		$headers.= "MIME-Version: 1.0\n";
      		$headers.= "Content-type: text/html; charset=iso-8859-1\n";
            mail($to,$subject,$mailContent,$headers);
            
            
            
            
            
        }
        
    }
    ?>
    <script>
    alert("Charity Approved");
    </script>
    <?php
}
if(isset($_REQUEST['disapprove']))
{
    $total=$_REQUEST['total'];
    for($j=1;$j<$total;$j=$j+1)
    {
        if($_REQUEST['check_'.$j])
        {
            $update="update charity_under_user set Approved='Declined' where ID='".$_REQUEST['check_'.$j]."'";
            MYSQLI_QUERY($DBcon,$update) or die("Cannot Execute Query".mysqli_error($DBcon));
            
            $update_user_charity="update user_charity set Approved='Declined' where Charity_ID='".$_REQUEST['check_'.$j]."'";
            mysqli_query($DBcon,$update_user_charity) or die("Cannot Execute Query");
            
            $email=$_REQUEST['useremail_'.$j];
            
            $subject ="Your Charity - ".$_REQUEST['charityname'.$j]." is Declined";
            $to =$email;
            $mailContent = "";
            $mailContent .= "Hello,<br><br> 
            Your Charity - ".$_REQUEST['charityname'.$j]." is declined by our site admin so now you are  not able to publish the game associated with  this charity.<br><br>Thanks,<br><br>Team WinWin";
            $headers.= "From: support@winwin.com\n";
      		$headers.= "MIME-Version: 1.0\n";
      		$headers.= "Content-type: text/html; charset=iso-8859-1\n";
            mail($to,$subject,$mailContent,$headers);
        }
    }
    ?>
    <script>
    alert("Charity Declined");
    </script>
    <?php
}

 ?>
  <style>
    .tablelist th,td
    {
        padding:5px;
        font-size: 14px;
        text-align: center;
    }
    </style>
 <div id="charity_approval" align = "center">
 <form method="post">
 <table>
 <tr><td>Select Approve</td>
 <td><select id="status" name="status" onchange="submit()">
        <option <?php if(($_REQUEST['status']=="Yes")) echo "selected";?> value="Yes">Yes</option>
        <option <?php if(($_REQUEST['status']=="No") or (!isset($_REQUEST['status']))) echo "selected";?>  value="No">No</option>
        <option <?php if(($_REQUEST['status']=="Declined")) echo "selected";?>  value="Declined">Declined</option>
    </select></td>
 </tr>
 </table>
 </form>
 <form method="post" onsubmit="return approve12()">
 <table class="tablelist tablecharity" id="data_table">
 <thead>
 <tr><td colspan="2"><input type="submit" name="approve" id="approve" value="Approve Selected Charity"></td><td colspan="6"><input type="submit" name="disapprove" id="disapprove" value="Decline Selected Charity"></td></tr>
<tr id="firstrow">
<th><input type="checkbox" name="checkall" id="checkall" value="Check All" onclick="checkall12()"></th>
<th>Charity Image</th>
<th>Charity Name</th>
<th>User Name</th>
<th>Charity Address</th>
<th>Charity Contact Personnel</th>
<th>Charity Phone</th>
<th>Charity Tax ID</th>
<th>non-profit-501c3</th>
<th>Approved</th>
<!--<th>Charity Type</th>
<th>Charity Location</th>
-->
</tr>
</thead>
<?php
$j=1;
if($_REQUEST['status'])
{
    $charity="select * from charity_under_user where Approved='".$_REQUEST['status']."'";
}
else
{
    $charity="select * from charity_under_user where Approved!='Yes' and Approved!='Declined'";
}

$charity_rs=mysqli_query($DBcon,$charity) or die("Cannot Execute query");
while($charity_row=mysqli_fetch_array($charity_rs))
{?>
    <tr> 
    <td><input type="checkbox" name="check_<?php echo $j?>" id="check_<?php echo $j?>" value="<?php echo $charity_row['ID']?>"></td>
    <td><img width="50px" src="<?php echo $charity_row['Image']?>"></td>
   <td><?php echo $charity_row['name']?>
   <input type="hidden" name="charityname<?php echo $j?>" id="charityname<?php echo $j?>" value="<?php echo $charity_row['name']?>">
   
   
   </td>
   <td><?php 
   $select="select * from tbl_users where User_ID='".$charity_row['User_ID']."'";
    $select_rs=mysqli_query($db,$select) or die("Cannot Execute Query1".mysqli_error($db));
    $select_row=mysqli_fetch_array($select_rs);
    echo $select_row['username'];?>
    <input type="hidden" name="useremail_<?php echo $j?>" id="useremail_<?php echo $j?>" value="<?php echo $select_row['email']?>">
    </td>
    
   <td><?php echo $charity_row['Address']?></td>
   <td><?php echo $charity_row['Contact_personnel']?></td> 
   <td><?php echo $charity_row['Phonenumber']?></td> 
   <td><?php echo $charity_row['Tax_ID']?></td> 
   
   <td><?php echo $charity_row['non_profit_501c3']?></td>
   <td><?php echo $charity_row['Approved']?></td>
   </tr>
<?php
$j=$j+1;
}
/*$charity12="select distinct(charity_id) as charity_id,name as name,user_id as user_id,Address as Address,Contact_personnel as Contact_personnel,Phonenumber as Phonenumber,Tax_ID as Tax_ID,non_profit_501c3 as non_profit_501c3 from user_charity where Approved!='Yes' and Approved!='Declined' and charity_id not in (select ID from charity_under_user where Approved!='Yes')";
$charity_rs12=mysqli_query($DBcon,$charity12) or die("Cannot Execute query");
while($charity_row12=mysqli_fetch_array($charity_rs12))
{?>
    <tr>
    <td><input type="checkbox" name="check_<?php echo $j?>" id="check_<?php echo $j?>" value="<?php echo $charity_row12['charity_id']?>"></td>
   <td><?php echo $charity_row12['name']?>
    <input type="hidden" name="charityname<?php echo $j?>" id="charityname<?php echo $j?>" value="<?php echo $charity_row['name']?>">
   
   </td>
   <td><?php $select="select * from tbl_users where User_ID='".$charity_row12['user_id']."'";
    $select_rs=mysqli_query($db,$select) or die("Cannot Execute Query1".mysqli_error($db));
    $select_row=mysqli_fetch_array($select_rs);
    echo $select_row['username'];?>
    <input type="hidden" name="useremail_<?php echo $j?>" id="useremail_<?php echo $j?>" value="<?php echo $select_row['email']?>">
    </td>
   <td><?php echo $charity_row12['Address']?></td>
   <td><?php echo $charity_row12['Contact_personnel']?></td> 
   <td><?php echo $charity_row12['Phonenumber']?></td> 
   <td><?php echo $charity_row12['Tax_ID']?></td> 
   
   <td><?php echo $charity_row12['non_profit_501c3']?></td>
   </tr>
<?php
$j=$j+1;
}
*/
?>
</table>
<input type="hidden" name="total" id="total" value="<?php echo $j?>">
</form>
<script>
function approve12()
{
    var checkval=0;
    var total=document.getElementById("total").value;
    
    for(var j=1;j<total;j=j+1)
    {
        if(document.getElementById("check_"+j).checked)
        {
            checkval=1;
            break;
        }
    }
    if(checkval==0)
    {
        alert("please select atlest one checkbox");
        return false;
    }
    else
    {
        return true;
        
    }
}
function checkall12()
{
    var total=document.getElementById("total").value;
    
    
        if(document.getElementById("checkall").checked)
        {
            for(var j=1;j<total;j=j+1)
            {
                document.getElementById("check_"+j).checked=true;
                
            }
        }
        else
        {
            for(var j=1;j<total;j=j+1)
            {
                document.getElementById("check_"+j).checked=false;
                
            }
        }
}

</script>
<?php

  include "footer.php";
  ?>