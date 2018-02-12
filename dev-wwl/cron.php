<?php
//date_default_timezone_set('Asia/Kolkata');
echo "'dashboard".date("Y-m-d H:i");
include 'dbConfig.php';
//echo $select="select * from game where publish='yes' and DATE_FORMAT(DATE_ADD(Publish_Date, INTERVAL +1 DAY),'%Y-%M-%d %H:%i')=DATE_FORMAT(now(), '%Y-%M-%d %H:%i')";
$select="select * from game where Publish='Yes' and Status='Running'";
$rs=mysqli_query($db,$select) or die("Cannot Execute Query".mysqli_error($db));
while($row=mysqli_fetch_array($rs))
{
    
$creditsql = "SELECT charity_percentage ,winwin_percentage ,creator_percentage,winner_percentage  from game_credit where game_id=".$row['id'];
$credit_sql = $db->query($creditsql);
$credit_Row=$credit_sql->fetch_array();

$charity_percentage=$credit_Row['charity_percentage']/100;

$winwin_percentage=$credit_Row['winwin_percentage']/100;

$creator_percentage=($credit_Row['creator_percentage'])/100;

$winner_percentage=($credit_Row['winner_percentage'])/100;


    $stop_date = $row['Publish_Date'];
//echo 'date before day adding: ' . $stop_date."<br>"; 
//$stop_date = date('Y-m-d H:i', strtotime($stop_date . ' +1 day'));
$stop_date = date('Y-m-d H:i',strtotime('+'.$row['End_Day'].' day +'.$row['End_Hour'].' hour +'.$row['End_Minute'].' minutes',strtotime($stop_date)));

echo '<br><br>date after adding'.$row['End_Day'].'  day '.$row['End_Hour'].' Hour '.$row['End_Minute'].' Minute: ' . $stop_date."<br><br>";

echo $today= date('Y-m-d H:i');
echo "<br>".strtotime($today) ."   ".strtotime($stop_date)."<br>";
echo "Min Credits =".$row['Min_credits']."    value of the game=".$row['value_of_the_game']." winner option   ".$row['winner_option'];
$result=0;
//get on which option game based on 1-Duration based ,2-min credit based ,3 -both
if($row['winner_option']==2)
{
    echo "winner option 2<br>";
    if($row['Min_credits']<=$row['value_of_the_game'])
    {
        $result=1;
    }
    else
    {
        $result=0;
    }
}
else if($row['winner_option']==1)
{
    echo "winner option 1<br>";
    if(strtotime($today)>=strtotime($stop_date))
    {
        $result=1;
    }
    else
    {
        $result=0;
    }
}
else
{
    echo "winner option32<br>";
    if((strtotime($today)>=strtotime($stop_date)) and ($row['Min_credits']<=$row['value_of_the_game'] ))
    {
        $result=1;
    }
    else
    {
        $result=0;
    }
}
if($result==1)
{
    echo "coming here<br>";
    
    //get result for puzzle game 
    if($row['Type']==1)
    {
        echo $timelimit=$row['time_limit'];
        echo $step=$row['Steps'];
        /*if(($timelimit==1) and ($step==1))
        {
            echo "both rules";
        }
        else 
        */
        
        if($timelimit==1)
        {
            echo "just timelimit<br>";
             echo $fetch="select * from game_history where game_id='".$row['id']."' and completed_in = (select min(completed_in) from game_history where game_id='".$row['id']."')";
         }  
         else if($step==1)
        {
            echo "step";
            echo $fetch="select * from game_history where game_id='".$row['id']."' and steps = (select min(steps) from game_history where game_id='".$row['id']."')";
         
        } 
            $fetch_rs=mysqli_query($db,$fetch) or die("Cannot Execute Query".mysqli_error($db));
            
    }
    //get result for quiz game 
    else if($row['Type']==3)
    {
       echo $quiz_rules=$row['Quiz_rules'];
       echo "<br>";
       if($quiz_rules==1)
       {
            echo $fetch="select * from game_history where game_id='".$row['id']."' and quiz_percentage = (select max(quiz_percentage) from game_history where game_id='".$row['id']."') order by id asc limit 1";
         
       }
       else if($quiz_rules==2)
       {
        echo $fetch="select * from game_history where game_id='".$row['id']."' and quiz_percentage = (select max(quiz_percentage) from game_history where game_id='".$row['id']."')";
         
       }
       else
       {
        echo $fetch="select * from game_history where game_id='".$row['id']."' and completed_in = (select min(completed_in) from game_history where game_id='".$row['id']."' and quiz_percentage = (select max(quiz_percentage) from game_history where game_id='".$row['id']."'))";
         
       }
       $fetch_rs=mysqli_query($db,$fetch) or die("Cannot Execute Query".mysqli_error($db));
    }
    //get result for 2048 game 
    else if($row['Type']==2)
    {
       echo $quiz_rules=$row['Quiz_rules'];
       echo "<br>";
       if($quiz_rules==2)
       {
        echo $fetch="select * from game_history where game_id='".$row['id']."' and Score = (select max(Score) from game_history where game_id='".$row['id']."')";
         
       }
       else
       {
        echo $fetch="select * from game_history where game_id='".$row['id']."' and completed_in = (select min(completed_in) from game_history where game_id='".$row['id']."' and 2048_won ='1')";
         
       }
       $fetch_rs=mysqli_query($db,$fetch) or die("Cannot Execute Query".mysqli_error($db));
    }

    
        echo $update="update game set Status='Completed' where id='".$row['id']."'";
        
        mysqli_query($db,$update) or die("Cannot Execute query");
        
        // createor charity
        $charity="select * from user_charity where game_id='".$row['id']."' and user_id='".$row['user_id']."'";
        $charity_rs=mysqli_query($db,$charity) or die("Cannot Execute query".mysqli_error($db).$charity);
        $charity_row=mysqli_fetch_array($charity_rs);
        $charityid=$charity_row['charity_id'];
        $charityname=$charity_row['name'];
        echo "<br> Creator charity id ".$charityid."<br>";
        
        if(mysqli_num_rows($fetch_rs)>1)
        {
            
           $j=0;
            while($fetch_row=mysqli_fetch_array($fetch_rs))
            {
                $winner_userid[$j]=$fetch_row['user_id'];
                $j=$j+1;
            }
            echo "<br> winner users ".print_r($winner_userid)."<br>";
            
            
            $total_winner=mysqli_num_rows($fetch_rs);
            echo $totalvalue=$row['value_of_the_game'];
            echo "<br>Total winner value=";
            echo $totalwinnervalue=$totalvalue*$winner_percentage;
            echo "<br> Per winner value=";
            echo $winnervalue=$totalwinnervalue/$total_winner;
            echo "<br>";
            echo $charityvalue=$totalvalue*$charity_percentage;
            echo "<br>";
            echo "<br> Creater and Winner Charity Value=";
            echo $percharity=$charityvalue/2;
            echo $winwin_value=$totalvalue*$winwin_percentage;
            echo "<br> Per winner charity value=";
            echo $perwinnercharity=$percharity/$total_winner;
            echo "<br>";
            echo $creator_value=$totalvalue*$creator_percentage;
            echo "<br>";
            
            
            
           
        
        //winner sql
        $status=$winnervalue." Credits get for game  ".$row['name'];
            $date = date('Y-m-d H:i:s');
            $userid12="";
        for($j=0;$j<count($winner_userid);$j=$j+1)
        {
            $userid12=$winner_userid[$j].",";
            $transaction=time().uniqid();
            $totalcreditsval=0;
            $totalcreditsval=gettotalcredits($winner_userid[$j])+$winnervalue;
            echo $insert_winner="INSERT INTO payments(Credits,User_ID,Date,Notes,Status,game_id,item_number,txn_id,payment_gross,currency_code,payment_status,total_credits) VALUES('".$winnervalue."','".$winner_userid[$j]."','".$date."','".$status."','1','".$row['id']."','','".$transaction."','0','','','".$totalcreditsval."')";
            $insert = mysqli_query($db,$insert_winner) or die("Cannot Execute query".mysqli_error($db).$q);
    
            $winner_notifictaion="insert into notification (User_ID,Notes,Date,game_id) values ('".$winner_userid[$j]."','".$status."',now(),'".$row['id']."') ";
            mysqli_query($db,$winner_notifictaion) or die("Cannot Execute Query".mysqli_error($db));
            
            echo "<br> winner charity <br>";
            
            $charity_winner="select * from user_charity where game_id='".$row['id']."' and user_id='".$winner_userid[$j]."'";
            $charitywin_rs=mysqli_query($db,$charity_winner) or die("Cannot Execute query".mysqli_error($db).$charity);
            $charitywin_row=mysqli_fetch_array($charitywin_rs);
            if(mysqli_num_rows($charitywin_rs)>0)
            {
                $winnercharityid=$charitywin_row['charity_id'];
                $winnercharityname=$charitywin_row['name'];
                echo "<br> Winner charity id ".$winnercharityid."<br>";
                
                $status=$perwinnercharity." Credits get for game ".$row['name']." as a winner charity";
                echo $insert_charity="insert into company_payment(Type,Credits,Notes,Date,Game_id,winner_id,creator_id,Charity_ID,Charity_Name,User_ID,Value) values 
                ('Charity','".$perwinnercharity."','".$status."','".$date."','".$row['id']."','".$winner_userid[$j]."','".$row['user_id']."','".$winnercharityid."','".$winnercharityname."','".$winner_userid[$j]."','winner')";
                mysqli_query($db,$insert_charity) or die("Cannot Execute Query".mysqli_error($db));
            }
            echo "<br>";
            
            
        }
        
    
    
    
    
    //creator sql
        $status=$creator_value." Credits get for game  ".$row['name'];
        
        $transaction=time().uniqid();
        $totalcreditsval=0;
         $totalcreditsval=gettotalcredits($row['user_id'])+$creator_value;
    echo $insert_creator="INSERT INTO payments(Credits,User_ID,Date,Notes,Status,game_id,item_number,txn_id,payment_gross,currency_code,payment_status,total_credits) VALUES
    ('".$creator_value."','".$row['user_id']."','".$date."','".$status."','1','".$row['id']."','','".$transaction."','0','','','".$totalcreditsval."')";
    $insert = mysqli_query($db,$insert_creator) or die("Cannot Execute query".mysqli_error($db).$q);
    
    
    $creator_notifictaion="insert into notification (User_ID,Notes,Date,game_id) values ('".$row['user_id']."','".$status."',now(),'".$row['id']."') ";
    mysqli_query($db,$winner_notifictaion) or die("Cannot Execute Query".mysqli_error($db));
    //charity sql
    
    $status=$percharity." Credits get for game ".$row['name']." as a creator charity";
    echo $insert_charity="insert into company_payment(Type,Credits,Notes,Date,Game_id,winner_id,creator_id,Charity_ID,Charity_Name,User_ID,Value) values 
    ('Charity','".$percharity."','".$status."','".$date."','".$row['id']."','".$userid12."','".$row['user_id']."','".$charityid."','".$charityname."','".$row['user_id']."','creator')";
    mysqli_query($db,$insert_charity) or die("Cannot Execute Query".mysqli_error($db));
    
    
    //winwin  sql
    
    $status=$winwin_value." Credits get for game ".$row['name']."";
    echo $insert_charity="insert into company_payment(Type,Credits,Notes,Date,Game_id,winner_id,creator_id) values 
    ('winwin','".$winwin_value."','".$status."','".$date."','".$row['id']."','".$userid12."','".$row['user_id']."')";
    mysqli_query($db,$insert_charity) or die("Cannot Execute Query".mysqli_error($db));
            
        }
        else if(mysqli_num_rows($fetch_rs)==1)
        {
            $fetch_row=mysqli_fetch_array($fetch_rs);
            echo "<br> winner user id".$fetch_row['user_id']."<br>";
            $winner_userid=$fetch_row['user_id'];
            echo $totalvalue=$row['value_of_the_game'];
            echo "<br>";
            echo $winnervalue=$totalvalue*$winner_percentage;
            echo "<br>";
            echo $charityvalue=$totalvalue*$charity_percentage;
            echo "<br> Per Charity Value=";
            echo $percharity=$charityvalue/2;
            echo "<br>";
            echo $winwin_value=$totalvalue*$winwin_percentage;
            echo "<br>";
            echo $creator_value=$totalvalue*$creator_percentage;
            echo "<br>";
            
            $charity_winner="select * from user_charity where game_id='".$row['id']."' and user_id='".$fetch_row['user_id']."'";
            $charitywin_rs=mysqli_query($db,$charity_winner) or die("Cannot Execute query".mysqli_error($db).$charity);
            $charitywin_row=mysqli_fetch_array($charitywin_rs);
            $winnercharityid=$charitywin_row['charity_id'];
            $winnercharityname=$charitywin_row['name'];
            echo "<br> Winner charity id ".$winnercharityid."<br>";
            
            $transaction=time().uniqid();
            
        
        //winner sql
        
        $status=$winnervalue." Credits get for game  ".$row['name'];
        $date = date('Y-m-d H:i:s');
        $totalcreditsval=0;
         $totalcreditsval=gettotalcredits($winner_userid)+$winnervalue;
    echo $insert_winner="INSERT INTO payments(Credits,User_ID,Date,Notes,Status,game_id,item_number,txn_id,payment_gross,currency_code,payment_status,total_credits) VALUES('".$winnervalue."','".$winner_userid."','".$date."','".$status."','1','".$row['id']."','','".$transaction."','0','','','".$totalcreditsval."')";
    $insert = mysqli_query($db,$insert_winner) or die("Cannot Execute query".mysqli_error($db).$q);
    
    
    $winner_notifictaion="insert into notification (User_ID,Notes,Date,game_id) values ('".$winner_userid."','".$status."',now(),'".$row['id']."') ";
    mysqli_query($db,$winner_notifictaion) or die("Cannot Execute Query".mysqli_error($db));
    
    //creator sql
        $status=$creator_value." Credits get for game  ".$row['name'];
        
        $transaction=time().uniqid();
        $totalcreditsval=0;
         $totalcreditsval=gettotalcredits($row['user_id'])+$creator_value;
    echo $insert_creator="INSERT INTO payments(Credits,User_ID,Date,Notes,Status,game_id,item_number,txn_id,payment_gross,currency_code,payment_status,total_credits) VALUES
    ('".$creator_value."','".$row['user_id']."','".$date."','".$status."','1','".$row['id']."','','".$transaction."','0','','','".$totalcreditsval."')";
    $insert = mysqli_query($db,$insert_creator) or die("Cannot Execute query".mysqli_error($db).$q);
    
    
    $creator_notifictaion="insert into notification (User_ID,Notes,Date,game_id) values ('".$row['user_id']."','".$status."',now(),'".$row['id']."') ";
    mysqli_query($db,$winner_notifictaion) or die("Cannot Execute Query".mysqli_error($db));
    //charity sql
    
    $status=$percharity." Credits get for game ".$row['name']." as a creator charity";
    echo $insert_charity="insert into company_payment(Type,Credits,Notes,Date,Game_id,winner_id,creator_id,Charity_ID,Charity_Name,User_ID,Value) values 
    ('Charity','".$percharity."','".$status."','".$date."','".$row['id']."','".$winner_userid."','".$row['user_id']."','".$charityid."','".$charityname."','".$row['user_id']."','creator')";
    mysqli_query($db,$insert_charity) or die("Cannot Execute Query".mysqli_error($db));
    
    
    
    $status=$percharity." Credits get for game ".$row['name']." as a winner charity";
    echo $insert_charity="insert into company_payment(Type,Credits,Notes,Date,Game_id,winner_id,creator_id,Charity_ID,Charity_Name,User_ID,Value) values 
    ('Charity','".$percharity."','".$status."','".$date."','".$row['id']."','".$winner_userid."','".$row['user_id']."','".$winnercharityid."','".$winnercharityname."','".$winner_userid."','winner')";
    mysqli_query($db,$insert_charity) or die("Cannot Execute Query".mysqli_error($db));
    
    
    //winwin  sql
    
    $status=$winwin_value." Credits get for game ".$row['name']."";
    echo $insert_charity="insert into company_payment(Type,Credits,Notes,Date,Game_id,winner_id,creator_id,Charity_ID,Charity_Name) values 
    ('winwin','".$winwin_value."','".$status."','".$date."','".$row['id']."','".$winner_userid."','".$row['user_id']."','','')";
    mysqli_query($db,$insert_charity) or die("Cannot Execute Query".mysqli_error($db));
    
    
    
    
            
        }
    }
    
    
}

function gettotalcredits($userid)
{
    $totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$userid."'";
            $cr_rs=mysqli_query($db,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($db));
            $cr_row=mysqli_fetch_array($cr_rs);
            $total_credit_cr=$cr_row['credits_cr'];

            $totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$userid."'";
            $db_rs=mysqli_query($db,$totalcredits_db) or die("Cannot Execute query".mysqli_error($db));
            $db_row=mysqli_fetch_array($db_rs);
            $total_credit_db=$db_row['credits_cr'];
            $mycredits=$total_credit_cr-$total_credit_db;
            $mycredits = round($mycredits,2);
            return $mycredits;
}
            
            ?>
?>