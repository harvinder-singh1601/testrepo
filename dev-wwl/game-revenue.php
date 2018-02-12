<?php
include 'dbConfig.php';
$page_title = "Credit-Transaction";
$page_description = "Credit Transaction Page";
include("header.php");
?>



			<!--==Revenue Page==-->
			<div class="revenue-area">
				<div class="revenue-content">
					<div class="rcHead">
            <?php
            $totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$_SESSION['userSession']."'";
            $cr_rs=mysqli_query($db,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($db));
            $cr_row=mysqli_fetch_array($cr_rs);
            $total_credit_cr=$cr_row['credits_cr'];

            $totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$_SESSION['userSession']."'";
            $db_rs=mysqli_query($db,$totalcredits_db) or die("Cannot Execute query".mysqli_error($db));
            $db_row=mysqli_fetch_array($db_rs);
            $total_credit_db=$db_row['credits_cr'];
            $mycredits=$total_credit_cr-$total_credit_db;
            $mycredits = round($mycredits,2);
            echo date('Y-m-d H:i:s',time());
            ?>
            <input type="hidden" name="mycredits_value" id="mycredits_value" value="<?php echo $mycredits;?>">
						<!-- <h2>Credit Balance:<span class="revTotal"><?php echo $mycredits;?></span></h2> -->
						<h2>Balance: <span class="revTotal"><?php echo $mycredits;?></span></h2>
						<button type="submit" id="credit_btn">View in Credits</button>
						<button type="submit" id="usd_btn">View in USD</button>
						<button type="button" data-toggle="modal" data-target="#paypalWithdraw">Withdraw Credits</button>
					</div>
					<div class="revenue-table">
						<table class="rvt scroll" id="test-table">
							<thead>
							  <tr>
									<th id = 'date'>Date</th>
									<th id = 'desc'>Description</th>
									<th id = 'de'>Debit</th>
									<th id = 'cr'>Credit</th>
	                				<th id = 'tot'>Total Balance</th>
	                				<th id = 'chr'>Charity</th>
							  </tr>
							</thead>

						   <tbody>
							<?php
							$user_id= $_SESSION['userSession'];
 							$sql = "SELECT * from payments where User_ID='".$user_id."' order by Date desc";
 							$creditrs=mysqli_query($DBcon,$sql) or die("Cannot Execute query".mysqli_error($DBcon));
							while($credit_row=mysqli_fetch_array($creditrs)) {
    						if($credit_row['item_number']!="") {
        					$result = $DBcon->query("SELECT * FROM products WHERE id = ".$credit_row['item_number']);
    						$row = $result->fetch_assoc(); }
    						?>
							<tr>
								<td id='date'><?php echo date("m-d-y H:i:s",strtotime($credit_row['Date']))?></td>
								<td id='desc'><?php echo $credit_row['Notes']?></td>
								
								<td id='de' class="crd" style="color:blue">
									<?php if($credit_row['Status']!=1){
									echo round($credit_row['Credits'],2);}
									?>
								</td>
								<td id='cr' class="crd" style="color:green">
									<?php if($credit_row['Status']==1){
									echo round($credit_row['Credits'],2);}
									?>
								</td>

                				<td id='tot' class="crd"><?php echo round($credit_row['total_credits'],2)?></td>

                				<?php 
        						//$chr_res = mysqli_query($DBcon,"SELECT * FROM company_payment WHERE (winner_id = '".$credit_row['User_ID'] ."' or creator_id='".$credit_row['User_ID']."') AND  Game_id ='" .$credit_row['game_id'] ."' AND Type='Charity' AND Charity_Name!=''") or die("Cannot execute query".mysqli_error($DBcon)); 
    							$chr_res = mysqli_query($DBcon,"SELECT * from company_payment where User_ID='".$credit_row['User_ID']."' and Game_id ='" .$credit_row['game_id'] ."'") or die("Cannot execute".mysqli_error($DBcon));
                                $chr = $chr_res->fetch_assoc(); 
    							?>
    							
                				<td id='chr' class="crd" style="font-size: 15px;">
                				<sup data-toggle="popover" data-trigger="hover" data-content="
                				Name: <?php echo $chr['Charity_Name'] ?>
                				notes: <?php echo $chr['Notes'] ?>
                				Donation: <?php echo $chr['Credits'] ?>"
                			    data-dismiss="modal" aria-hidden="true" data-original-title="" title="" class="pop">
                			    <?php if($credit_row['Status']==1 && $chr['Charity_Name']!=''){
                			    	$donation = $chr['Credits'];
                			    	$c_name = $chr['Charity_Name'];
									echo $c_name . " <br>\n " . $donation ." credits" ;
								}
								?>
										
								</sup>
                				</td>
							</tr>

							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$(".crd").each(function(){
		             if ($(this).html() == 0) {
 						 $(this).html('');
					}

				});
		</script>


		<script>
		$(document).ready(function() {
			function roundToTwo(num) {    
    			return +(Math.round(num + "e+4")  + "e-4");
			}
			$('#credit_btn').prop('disabled', true);

		    $("#usd_btn").click(function() {
		      
              var vn=$(".revTotal").text()/100;
		    $(".revTotal").html('$ ' + roundToTwo(vn));
		      
              var table = $('#test-table').DataTable();
              var rows1=table.rows().count();
              //alert(rows1);
              //table.row[1][1]='dash';
             
              for(var m=0;m<rows1;m=m+1)
              {
                var data = table.row(m).data();
                //alert(data[2]);
                //for debit column 
                var v=(data[2])/100;
                var data1='$ ' + roundToTwo(v);
                if (data1 == '$ 0' || data1 == '$ NaN' ) {
 						  table.cell(m,2).data('');
					}
                    else  table.cell(m,2).data(data1);
                    
              //for Credit column 
                var v=(data[3])/100;
                var data1='$ ' + roundToTwo(v);
                if (data1 == '$ 0' || data1 == '$ NaN') {
 						  table.cell(m,3).data('');
					}
                    else  table.cell(m,3).data(data1);
                    
             
             //for total balance column 
                var v=(data[4])/100;
                var data1='$ ' + roundToTwo(v);
                if (data1 == '$ 0' || data1 == '$ NaN') {
 						  table.cell(m,4).data('');
					}
                    else  table.cell(m,4).data(data1);
					
                
              
              
              //for Charity column
              if((data[5]!="") && (data[5].search("credits")>0))
              {
                
               
              var res = data[5].split("<br>");
              var val1=res[1].split("credits");
              //alert(val1[0]);
                var v=(val1[0])/100;
                
                
                var data1='$ ' + roundToTwo(v);
                if (data1 == '$ 0' || data1 == '$ NaN') {
 						  table.cell(m,5).data('');
					}
                    else  table.cell(m,5).data(res[0]+"<br>"+data1+" credits "+val1[1]);
                    }
                   // alert(res[0]+"<br>"+data1+" credits "+val1[1]);
               }     
               
                    $('#usd_btn').prop('disabled', true);
		            $('#credit_btn').prop('disabled', false);
    
		      
			/*	var vn=$(".revTotal").text()/100;
		    $(".revTotal").html('$ ' + roundToTwo(vn));

		        $(".crd").each(function(){
		        	var v=$(this).text()/100;
					$(this).html('$ ' + roundToTwo(v));
		            if ($(this).html() == '$ 0' && $(this).html() == '$ NaN') {
 						 $(this).html('');
					}
		        
		            $('#usd_btn').prop('disabled', true);
		            $('#credit_btn').prop('disabled', false);
		        	

		        });
                */
		    });

		});
		</script>

		<script type="text/javascript">
			$(document).ready(function() {
			 $("#credit_btn").click(function() {
			 	var usd = $(".revTotal").text().replace("$", "")*100;
				$(".revTotal").text(usd);
                
                 var table = $('#test-table').DataTable();
              var rows1=table.rows().count();
              //alert(rows1);
              //table.row[1][1]='deepti';
             
              for(var m=0;m<rows1;m=m+1)
              {
                var data = table.row(m).data();
                //alert(data[2]);
                //for debit column 
                if(data[2]!="")
                {
                var data1=(data[2]).replace("$", "")*100;
                  table.cell(m,2).data(data1.toFixed(2));
                 }   
              //for Credit column 
              if(data[3]!="")
                {
                var data1=(data[3]).replace("$", "")*100;
                  table.cell(m,3).data(data1.toFixed(2));
                }
                    
             
             //for total balance column 
             if(data[4]!="")
                {
                var data1=(data[4]).replace("$", "")*100;
                  table.cell(m,4).data(data1.toFixed(2));
				}	
                
              
              
              //for Charity column
              if((data[5]!="") && (data[5].search("credits")>0))
              {
                
               
              var res = data[5].split("<br>");
              var val1=res[1].split("credits");
              //alert(val1[0]);
                
                var data1=(val1[0]).replace("$", "")*100;
                  table.cell(m,5).data(res[0]+"<br>"+data1+" credits "+val1[1]);
                }
                
                
                   // alert(res[0]+"<br>"+data1+" credits "+val1[1]);
               }     
                $('#usd_btn').prop('disabled', false);
		            $('#credit_btn').prop('disabled', true);

		       /* $(".crd").each(function(){

		        	if ($(this).text()!=''){
		        	$(this).html($(this).text().replace("$", "")*100);
		            $('#usd_btn').prop('disabled', false);
		            $('#credit_btn').prop('disabled', true);
		        	}
                    
		        });
                */
		    });
		});
        
		</script>

		


		<?php
		$totalcredits_cr="select sum(Credits) as credits_cr from payments where status=1 and User_ID='".$_SESSION['userSession']."'";
		$cr_rs=mysqli_query($DBcon,$totalcredits_cr) or die("Cannot Execute query".mysqli_error($DBcon));
		$cr_row=mysqli_fetch_array($cr_rs);
		$total_credit_cr=$cr_row['credits_cr'];

		$totalcredits_db="select sum(Credits) as credits_cr from payments where status=2 and User_ID='".$_SESSION['userSession']."'";
		$db_rs=mysqli_query($DBcon,$totalcredits_db) or die("Cannot Execute query".mysqli_error($DBcon));
		$db_row=mysqli_fetch_array($db_rs);
		$total_credit_db=$db_row['credits_cr'];
		$mycredits=$total_credit_cr-$total_credit_db;
		?>
		<!--Play Game Popup-->
		 <?php
        if($mycredits>0)
        {
        ?>
			<div class="paypalWithdraw" id="paypalWithdraw-area">
				<div class="modal fade"  id="paypalWithdraw">
					<div class="modal-dialog">
						<div class="paywithdraw-Content">
							<div class="pw-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h2 class="modal-title">Withdraw Credits To Your Paypal Account</h2>
						    </div>

					      <div class="pw-form">
					      	<div class="efItem">
						        <label>Available Credits :</label>
						        <p><?php echo $mycredits ?></p>
					        </div>
					        <div class="efItem">
						        <label>Withdraw Credits :</label>
						        <input type="number" name="withdraw" id="withdraw" value="" min="5" onchange="changeamount()" required >
					        </div>
					        <div class="efItem">
						        <label>Amount :</label>
						        <p id="creditamount"></p>
					        </div>

					        <div class="efItem">
						        <label>Paypal Email :</label>
						        <input type="email" required name="paypal" id="paypal">
						        <span>(Note : In Which you want to send money)</span>
					        </div>
					        <div class="efItem">
						        <label>First Name :</label>
						        <input type="text" required name="fname" id="fname">
					        </div>
					        <div class="efItem">
						        <label>Last Name :</label>
						        <input type="text" required name="lname" id="lname">
					        </div>
					        <button type="submit" name="moneytransfer" id="moneytransfer">Send Payment</button>
					      </div>
                        <center><div id="imagediv" style="display: none;"> <img width="50%"  src="images/loading.gif" ></div></center>
						</div>
					</div>
				</div>
			</div>
		<?php
        }
        else
        {
            echo "<h3><font color='red'>You have not sufficient balance for withdrawl</h3></font>";
        }
        ?>

        <script>
		$(document).ready(function() {
     		$('#moneytransfer').click(function() {


	         var mycredits=parseInt(document.getElementById("mycredits_value").value);
	         var withdraw=parseInt(document.getElementById("withdraw").value);
	         var email=document.getElementById("paypal").value;
	         var fname=document.getElementById("fname").value;
	         var lname=document.getElementById("lname").value;

	         if((document.getElementById("withdraw").value=="") || (document.getElementById("withdraw").value<=0))
	         {
	            alert("Please Enter the credit amount you would like to withdraw");
	            document.getElementById("withdraw").focus();
	            return false;
	         }
	         else if (withdraw>mycredits)
	         {
	            alert("Credits withdrawn can't be greater than Total Credits");
	         }
	         else if(email=="")
	         {
	            alert("Please Enter your Paypal Email");
	            document.getElementById("paypal").focus();
	         }
	         else if(fname=="")
	         {
	            alert("Please Enter your First Name");
	            document.getElementById("fname").focus();
	         }
	         else if(lname=="")
	         {
	            alert("Please Enter your Last Name");
	            document.getElementById("lname").focus();
	         }
	         else
	         {
	            document.getElementById("moneytransfer").style.display="none";
	        document.getElementById("imagediv").style.display="block";
	            $.ajax({
	        type: "POST",
	        url: "paid.php",
	        data:{withdraw:withdraw,email:email,fname:fname,lname:lname},
	        success: function(data){
	            document.getElementById("moneytransfer").style.display="block";
	        document.getElementById("imagediv").style.display="none";
	            var res = data.split(":");
	         if(res[0]==2)
	         {
	            alert(res[1]);
	            document.location="game-revenue.php";
	         }
	         else if(res[0]==1)
	         {
	            alert(res[1]);
	         }
	         else
	         {
	            alert(data);
	         }


	        }
	      });
	         }
	     });
	});

   </script>

   <script>
	function changeamount()
	{
	    var val=parseInt(document.getElementById("withdraw").value);
	    var amount=1/100*val;
	    document.getElementById("creditamount").innerHTML='$ ' + amount;
	}
   </script>

 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>




<script type="text/javascript">

	//jQuery.noConflict()
		jQuery("table").DataTable(
			{

				// "paging": false
				"order": [[ 0, 'desc' ], [ 1, 'desc' ],[ 2, 'desc' ], [ 3, 'desc' ], [ 4, 'desc' ]]

			
        		
			}); 
		
</script>
<script type="text/javascript">
	
	$(".pop").popover({ trigger: "manual" , html: true, animation:false})
    .on("mouseenter", function () {
        var _this = this;
        $(this).popover("show");
        $(".popover").on("mouseleave", function () {
            $(_this).popover('hide');
        });
    }).on("mouseleave", function () {
        var _this = this;
        setTimeout(function () {
            if (!$(".popover:hover").length) {
                $(_this).popover("hide");
            }
        }, 300);
});
</script>

<?php include("footer.php"); ?>
