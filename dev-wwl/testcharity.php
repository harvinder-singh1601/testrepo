<?php
include 'dbConfig.php';
$select="select * from company_payment where Type='Charity' and Charity_ID is null";
$select_rs=mysqli_query($db,$select) or die("Cannot Execute Query".mysqli_error($db));
$COUNT=1;
while($select_row=mysqli_fetch_array($select_rs))
{
    if($select_row['Charity_Name']=="")
    {
        $charity="select * from user_charity where game_id='".$select_row['Game_id']."' and user_id='".$select_row['creator_id']."'";
        $charity_rs=mysqli_query($db,$charity) or die("Cannot Execute query".mysqli_error($db).$charity);
        $charity_row=mysqli_fetch_array($charity_rs);
        $charityid=$charity_row['charity_id'];
        $charityname=$charity_row['name'];
        
       ECHO  $update="update company_payment set Charity_ID='".$charityid."',Charity_Name='".$charityname."' where ID='".$select_row['ID']."'";
    mysqli_query($db,$update) or die("Cannot Execute Query".mysqli_error($db));
    $COUNT=$COUNT+1;
    }
    ECHO "<BR><BR>";
}
ECHO $COUNT;
?>