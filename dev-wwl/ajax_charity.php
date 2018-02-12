<?php
session_start();
include "dbconnect.php";
$user_id= $_SESSION['userSession'];
if($_REQUEST['action']=="update")
{
    
     $select="select * from charity where name='".$_REQUEST['name_val']."'";
    $select_rs=mysqli_query($DBcon,$select) or die("Cannot Execute Query".$select.mysqli_error($DBcon));
    if(mysqli_num_rows($select_rs)>0)
    {
        $select_row=mysqli_fetch_array($select_rs);
        $id1=$select_row['id'];  
        $approve="Yes";      
    }
    else
    {
        $id1="0";
        $approve="No";
    }
    if(isset($_FILES['file']['tmp_name']))
    {
            $file2="upload_images/charity/".time()."_".$_FILES['file']['name'];    
            move_uploaded_file($_FILES['file']['tmp_name'],$file2) or die ("Cannot upload Image");
    }     
         
    else
    {
        $file2=$_REQUEST['fileold'];
        
    }   
    
    $check="select * from charity_under_user where User_ID='".$user_id."' and name='".$_REQUEST['name_val']."' and ID!='".$_REQUEST['id']."'";
    $check_rs=mysqli_query($DBcon,$check) or die("Cannot Execute Query".mysqli_error($DBcon));
    if(mysqli_num_rows($check_rs)>0)
    {
        echo "Charity Already Exist";
    }
    else
    {
    //$delete="update charity_under_user set name='".$_REQUEST['name_val']."',charity_type='".$_REQUEST['type']."',charity_location='".$_REQUEST['location']."' where ID='".$_REQUEST['id']."'";
    $delete="update charity_under_user set Charity_ID='".$id1."',Approved='".$approve."',name='".$_REQUEST['name_val']."',Address='".$_REQUEST['address']."',Contact_personnel='".$_REQUEST['contact']."',Phonenumber='".$_REQUEST['phone']."',Tax_ID='".$_REQUEST['taxid']."',non_profit_501c3='".$_REQUEST['non_profit']."',Image='".$file2."',Description='".mysqli_real_escape_string($DBcon,$_REQUEST['description'])."' where ID='".$_REQUEST['id']."'";
   
    mysqli_query($DBcon,$delete) or die("Cannot Execute Query".mysqli_error($DBcon));
    echo "1";
    }
    }
if($_REQUEST['action']=="del")
{
    $del12="select user_charity.* from user_charity,game where user_charity.game_id=game.id and game.publish!='Yes' and user_charity.charity_id='".$_REQUEST['id']."'";
    $del_rs=mysqli_query($DBcon,$del12) or die("Cannot Execute Query".mysqli_error($DBcon));
    if(mysqli_num_rows($del_rs)==0)
    {
    $delete="delete from charity_under_user where ID='".$_REQUEST['id']."'";
    mysqli_query($DBcon,$delete) or die("Cannot Execute Query".mysqli_error($DBcon));
    echo "1";
    }
    else
    {
        echo " This charity assosiated with ". mysqli_num_rows($del_rs)." games .First edit that games and then delete this charity";
    }
    }
if($_REQUEST['action']=="add")
{
    
    //$charity_type=$_REQUEST['charity_type'];
    $charity_name=$_REQUEST['charity_name'];
    //$charity_location=$_REQUEST['charity_location'];
    
     $select="select * from charity where name='".$charity_name."'";
    $select_rs=mysqli_query($DBcon,$select) or die("Cannot Execute Query".$select.mysqli_error($DBcon));
    if(mysqli_num_rows($select_rs)>0)
    {
        $select_row=mysqli_fetch_array($select_rs);
        $id1=$select_row['id'];  
        $approve="Yes"; 
        $file2=$_REQUEST['fileold'];     
    }
    else
    {
        $id1="0";
        $approve="No";
        if(isset($_FILES['file']['tmp_name']))
        {
            $file2="upload_images/charity/".time()."_".$_FILES['file']['name'];    
            move_uploaded_file($_FILES['file']['tmp_name'],$file2) or die ("Cannot upload Image");
        }     
         
        else
        {
            $file2=$_REQUEST['fileold'];
            
        }   
    }
    
    $check="select * from charity_under_user where User_ID='".$user_id."' and name='".$charity_name."'";
    $check_rs=mysqli_query($DBcon,$check) or die("Cannot Execute Query".mysqli_error($DBcon));
    if(mysqli_num_rows($check_rs)>0)
    {
        echo "Charity Already Exist";
    }
    else
    {
          $insert_charity="insert into charity_under_user (User_ID,Charity_ID,name,Address,Contact_personnel,Phonenumber,Tax_ID,non_profit_501c3,Approved,Type,Image,Description) values('".$user_id."','".$id1."','$charity_name','".$_REQUEST['address']."','".$_REQUEST['contact']."','".$_REQUEST['phone']."','".$_REQUEST['taxid']."','".$_REQUEST['nonprofit']."','".$approve."','user','".$file2."','".mysqli_real_escape_string($DBcon,$_REQUEST['description'])."')";
    mysqli_query($DBcon,$insert_charity) or die("Cannot Execute query".mysqli_error($DBcon));
        $id=mysqli_insert_id($DBcon);
       
        echo $id.":".$id1.":".$approve.":".$file2;
    }
    
        mysqli_close($DBcon);
}
if($_REQUEST['action']=="addbyid")
{
    
    //$charity_type=$_REQUEST['charity_type'];
    $charity_id=$_REQUEST['id'];
    //$charity_location=$_REQUEST['charity_location'];
    
     $select="select * from charity where id='".$charity_id."'";
    $select_rs=mysqli_query($DBcon,$select) or die("Cannot Execute Query".$select.mysqli_error($DBcon));
    if(mysqli_num_rows($select_rs)>0)
    {
        $select_row=mysqli_fetch_array($select_rs);
        $id1=$select_row['id'];  
        $approve="Yes";      
    }
    
    
    $check="select * from charity_under_user where User_ID='".$user_id."' and name='".$select_row['name']."'";
    $check_rs=mysqli_query($DBcon,$check) or die("Cannot Execute Query".mysqli_error($DBcon));
    if(mysqli_num_rows($check_rs)>0)
    {
        echo "Charity Already Exist";
    }
    else
    {
         $insert_charity="insert into charity_under_user (User_ID,Charity_ID,name,Address,Contact_personnel,Phonenumber,Tax_ID,non_profit_501c3,Approved,Image,Description) values('".$user_id."','".$id1."','".$select_row['name']."','".$select_row['Address']."','".$select_row['Contact_personnel']."','".$select_row['Phonenumber']."','".$select_row['Tax_ID']."','".$select_row['non_profit_501c3']."','Yes','".$select_row['Image']."','".$select_row['Description']."')";
    mysqli_query($DBcon,$insert_charity) or die("Cannot Execute query".mysqli_error($DBcon));
        $id=mysqli_insert_id($DBcon);
       
        echo $id.":".$select_row['name'];
    }
    
        mysqli_close($DBcon);
}

?>