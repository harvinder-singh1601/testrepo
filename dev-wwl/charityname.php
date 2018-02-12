<?php
include "dbconnect.php";
if(isset($_REQUEST['action']) and $_REQUEST['action']=="search")
{
//CREATE QUERY TO DB AND PUT RECEIVED DATA INTO ASSOCIATIVE ARRAY
if (isset($_REQUEST['val'])) {
    $val = $_REQUEST['val'];
    $sql = mysqli_query ($DBcon,"SELECT * FROM charity WHERE name LIKE '{$val}%'");

    while ($row = mysqli_fetch_array($sql)) {
        ?>
        <div class="autocomplete" style="width: 100%;cursor: pointer; cursor: hand; "  onclick='enterval("<?php echo $row['name'];?>","<?php echo $row['Address'];?>","<?php echo $row['Contact_personnel'];?>","<?php echo $row['Phonenumber'];?>","<?php echo $row['Tax_ID'];?>","<?php echo $row['non_profit_501c3'];?>","<?php echo $row['Description'];?>","<?php echo $_REQUEST['name']?>","<?php echo $_REQUEST['no']?>","<?php echo $row['Image'];?>")'><?php echo $row['name'];?></div><br>
         <?php   
    }
    //RETURN JSON ARRAY
    
}
}
if(isset($_REQUEST['action']) and $_REQUEST['action']=="check")
{
    if (isset($_REQUEST['val'])) {
    $val = $_REQUEST['val'];
    $sql = mysqli_query ($DBcon,"SELECT * FROM charity WHERE name = $val");
   if(mysqli_num_rows($sql)>0) echo "1";
   else echo "0";
    
    //RETURN JSON ARRAY
    
}
}
?>