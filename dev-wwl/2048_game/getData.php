<?php
require_once 'config.php';
if ($_GET) {
    $id = (int)$_GET['id'];
   // $sql  = "SELECT * FROM 2048_user WHERE id = '$id'";
    $sql="select max(Score)as bestscore from game_history where game_type='2' and game_id='".$id."'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0)
    {
        $row=mysqli_fetch_array($result);
        if($row['bestscore']>0)
        $arr["bestscore"] =$row['bestscore'];
        else
        $arr["bestscore"]=0;
        
    }
    else
    {
        $arr["bestscore"]=0;
    }
    
    header("Content-Type: application/json");
    print json_encode($arr);
}