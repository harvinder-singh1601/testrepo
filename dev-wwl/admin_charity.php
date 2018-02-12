<?php include_once 'header.php';
include 'dbConfig.php';
if(isset($_REQUEST['cid']))
{
    $delete="delete from charity_under_user where Type='Default'";
    mysqli_query($DBcon,$delete) or die("Cannot Execute Query1".mysqli_error($DBcon));
    
    $update="update charity set `Default`='No'";
    mysqli_query($DBcon,$update) or die("Cannot Execute Query2".mysqli_error($DBcon));
    
    $update_charity="update charity set `Default`='Yes' Where id='".$_REQUEST['cid']."'";
    mysqli_query($DBcon,$update_charity) or die("Cannot Execute Query3".mysqli_error($DBcon));
    
    // add default charity in everey user account
    $select="select * from charity where id='".$_REQUEST['cid']."'";
    $rs=mysqli_query($DBcon,$select) or die("Cannot Execute query4".mysqli_error($DBcon));
    $charity_row=mysqli_fetch_array($rs);
    
    $user="select * from tbl_users";
    $user_rs=mysqli_query($DBcon,$user) or die("Cannot Execute Query5".mysqli_error($DBcon));
    while($user_row=mysqli_fetch_array($user_rs))
    {
         $check="select * from charity_under_user where User_ID='".$user_row['user_id']."' and Charity_ID='".$charity_row['id']."'";
        $check_rs=mysqli_query($DBcon,$check) or die("Cannot Execute Query6".mysqli_error($DBcon));
        if(mysqli_num_rows($check_rs)>0)
        {
            $check_row=mysqli_fetch_array($check_rs);
             $update_charity="update charity_under_user set Type='default' where User_ID='".$user_row['user_id']."' and Charity_ID='".$charity_row['id']."'";
            mysqli_query($DBcon,$update_charity) or die("Cannot Execute Query7".mysqli_error($DBcon));
        }
        else
        {
             $insert_charity="insert into charity_under_user (User_ID,Charity_ID,name,Address,Contact_personnel,Phonenumber,Tax_ID,non_profit_501c3,Approved,Image,Type) values
            ('".$user_row['user_id']."','".$charity_row['id']."','".$charity_row['name']."','".$charity_row['Address']."','".$charity_row['Contact_personnel']."','".$charity_row['Phonenumber']."','".$charity_row['Tax_ID']."','".$charity_row['non_profit_501c3']."','Yes','".$charity_row['Image']."','default')";
           mysqli_query($DBcon,$insert_charity) or die("Cannot Execute query".mysqli_error($DBcon));
        }
        
         
    }
    ?>
    <script>
    alert("Charity Default Change successfully");
    </script>
    <?php
}

 ?>
 <script>
 $('#profile').hide();
 </script>
  <style>
    .tablelist th,td
    {
        padding:5px;
        font-size: 14px;
        text-align: center;
    }
    </style>
 <div id="charity_approval" align = "center">
 <form method="post" onsubmit="return approve12()">
 <table class="tablelist tablecharity" id="data_table">
 <thead>
 <tr id="firstrow">

<th>Charity Name</th>
<th>Charity Address</th>
<th>Charity Contact Personnel</th>
<th>Charity Phone</th>
<th>Charity Tax ID</th>
<th>non-profit-501c3</th>
<th></th>
<!--<th>Charity Type</th>
<th>Charity Location</th>
-->
</tr>
</thead>
<?php
$j=1;
$charity="select * from charity";
$charity_rs=mysqli_query($DBcon,$charity) or die("Cannot Execute query");
while($charity_row=mysqli_fetch_array($charity_rs))
{?>
    <tr <?php if($charity_row['Default']=="Yes") echo "style='color:white;background-color:green;'"?>> 
    
   <td><?php echo $charity_row['name']?>
   
   </td>
   <td><?php echo $charity_row['Address']?></td>
   <td><?php echo $charity_row['Contact_personnel']?></td> 
   <td><?php echo $charity_row['Phonenumber']?></td> 
   <td><?php echo $charity_row['Tax_ID']?></td> 
   
   <td><?php echo $charity_row['non_profit_501c3']?></td>
   <td><?php if($charity_row['Default']=="No") echo "<a href='javascript:void(0)' onclick='setd(".$charity_row['id'].")'>Make as Default</a>"; else ECHO "Default";?></td>
   </tr>
<?php
$j=$j+1;
}
?>
</table>
<input type="hidden" name="total" id="total" value="<?php echo $j?>">
</form>
<script>
function setd(id)
{
    var ans=confirm("Are you sure you want to set this charity as default");
    if(ans==true)
    {
        document.location="admin_charity.php?cid="+id;
    }
}
</script>
<?php

  include "footer.php";
  ?>