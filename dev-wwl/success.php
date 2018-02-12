<?php
session_start();
include 'dbConfig.php';

//Get payment information from PayPal
$item_number = $_GET['item_number']; 
$txn_id = $_GET['tx'];
$payment_gross = $_GET['amt'];
$currency_code = $_GET['cc'];
$payment_status = $_GET['st'];


//Get product price from database
$productResult = $db->query("SELECT * FROM products WHERE id = 1") or die("Cannot Execute query".mysqli_error($db));

$productRow = $productResult->fetch_assoc();
 $productPrice = $productRow['price'];
 $productcredit=trim($productRow['name']);

if(!empty($txn_id)){
	//Check if payment data exists with the same TXN ID.
    $prevPaymentResult = $db->query("SELECT payment_id FROM payments WHERE txn_id = '".$txn_id."'")or die("Cannot Execute query2".mysqli_error($db));

    if($prevPaymentResult->num_rows > 0){
        $paymentRow = $prevPaymentResult->fetch_assoc();
        $last_insert_id = $paymentRow['payment_id'];
        
    }else{
        
        //Insert tansaction data into the database
        //users total credit
        $totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$_SESSION['userSession']."'";
            $cr_rs=mysqli_query($db,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($db));
            $cr_row=mysqli_fetch_array($cr_rs);
            $total_credit_cr=$cr_row['credits_cr'];
            
            $totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$_SESSION['userSession']."'";
            $db_rs=mysqli_query($db,$totalcredits_db) or die("Cannot Execute query".mysqli_error($db));
            $db_row=mysqli_fetch_array($db_rs);
            $total_credit_db=$db_row['credits_cr'];
            $mycredits=$total_credit_cr-$total_credit_db;
        //get the exact credit 
        $totalcredits=$payment_gross*$productcredit;
        
        //sum of credits
        $totalsumofcredits=$totalcredits+$mycredits;
        
        $date=date('Y-m-d H:i:s',time());
        $q="INSERT INTO payments(Credits,User_ID,item_number,txn_id,payment_gross,currency_code,payment_status,Date,Notes,Status,game_id,total_credits) VALUES('".$totalcredits."','".$_SESSION['userSession']."','".$item_number."','".$txn_id."','".$payment_gross."','".$currency_code."','".$payment_status."',".$date.",'Buy credits from paypal','1','0',".$totalsumofcredits.")";
        $insert = $db->query($q) or die("Cannot Execute query".mysqli_error($db).$q);
        $last_insert_id = $db->insert_id;
    }
?>
	<h1>Your payment has been successful.</h1>
    
    <h1>Your Payment ID - <?php echo $last_insert_id; ?>.</h1><a href="http://winwinlabs.com/developer/winwinlabs/index.php">Back to WinWinLabs</a>
<?php }else{ ?>
	<h1>Your payment has failed.</h1>
<?php } ?>
<script>
/*
if( window !== top ) 
{
    document.getElementById("but").style.display="block";
}

    
function closeAndRefresh(){
  opener.location.reload(); // or opener.location.href = opener.location.href;
  window.close(); // or self.close();
}*/
</script>