<?php
$page_title = "Home";
$page_description = "Home-Page";
include("header.php");
?>
<style>
.img-div{position:relative; display: inline-block;}
.img-div:hover:after{
    content:'';
    position:absolute;
    left: 0px;
    top: 0px;
    bottom: 0px;
    width: 100%;
    background: url('assets/img/cam.png') center no-repeat;
    background-size: 50px;
}
.img-div{
	cursor:pointer;
}
.img-div:hover img{opacity: 0.4;}

#thank{
	padding:10px;position:absolute;top:35px;left:15px;color:red;
}

#pswd_info::before {
    content: "\25Bc";
    position: absolute;
    top: 154px;
    left: 41%;
    font-size: 14px;
    line-height: 14px;
    color: #ddd;
    text-shadow: none;
    display: block;
}

#profileUpMsg {
    position: absolute;
    right: 206px;
    width: 120px;
    padding: 15px;
    background: #fefefe;
    font-size: .875em;
    border-radius: 5px;
    box-shadow: 0 1px 3px #ccc;
    border: 1px solid #ddd;
    display: none;
    bottom: 290px;
}

#pswd_info {
    position: absolute;
    bottom: 130px;
    right: 206px;
    width: 250px;
    padding: 15px;
    background: #fefefe;
    font-size: .875em;
    border-radius: 5px;
    box-shadow: 0 1px 3px #ccc;
    border: 1px solid #ddd;
    display: none;
    bottom: 320px;
}

#pswd_info ul li {
	list-style-type:none;
}

#pswd_info1::before {
    content: "\25Bc";
    position: absolute;
    bottom: -13px;
    left: 41%;
    font-size: 14px;
    line-height: 14px;
    color: #ddd;
    text-shadow: none;
    display: block;
}
#pswd_info1 {
    position: absolute;
    bottom: 250px;
    right: 206px;
    width: 250px;
    padding: 15px;
    background: #fefefe;
    font-size: .675em;
    border-radius: 5px;
    box-shadow: 0 1px 3px #ccc;
    border: 1px solid #ddd;
    display: none;
    bottom: 320px;
}
#pswd_info1 ul li {
	list-style-type:none;
}

input.hidden {
    position: absolute;
    left: -9999px;
}
</style>

<!-- dashboard -->
		<div class="dashboard-container" >	
			<div id="profileUpMsg" style="color:black;">
				<h3>Uploading Picture</h4>
				<img src="assets/img/loader.gif" width="100px" />
			</div>			
			<div class="container" style="background-color:rgba(0, 0, 0, 0.2);height:80vh;border-radius:10px;">
			<style></style>
			<hr>
			
				<div class="row">
					<div class="col-sm-10"><h1 class="uname">Username</h1></div>
					<div class="col-sm-2 img-div"><a href="#" class="pull-right"><img id="imgUp" style=";height:110px;margin-right:30px;" title="profile image" width="110px" class="imgUp img-circle img-responsive" src="<?php echo $_SESSION['userImage']; ?>" alt="user Image" onerror="this.src ='https://res.cloudinary.com/closebrace/image/upload/w_400/v1491315007/usericon_id76rb.png'"></a></div>
				</div>
				<div class="row">
					<div class="col-sm-3"><!--left col-->
						  
					  <ul class="list-group panel panel-default" style="color:black;">
						<li class="list-group-item text-muted panel-heading">Profile</li>
						<li class="list-group-item text-right" >
							<span class="pull-left"><strong>First Name</strong></span><span class="fname">Firstname</span></li>
						<li class="list-group-item text-right">
							<span class="pull-left"><strong>Last Name</strong></span><span  class="lname">Lastname</span></li>
						<li class="list-group-item text-right">
							<span class="pull-left"><strong>Username</strong></span><span  class="uname">Username</span></li>
						<li class="list-group-item text-right" >
							<span class="pull-left"><strong>Email</strong></span><span class="emailSignUp">Email</span></li>
						
					  </ul> 
						   
					  <div class="panel panel-default">
						<div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
						<div class="panel-body"><a href="#">WinWinLabs</a></div>
					  </div>
					  
					</div><!--/col-3-->
					<div class="col-sm-9">
					  
					  <ul class="nav nav-tabs" id="myTab">
						<li class="active"><a href="#recent" data-toggle="tab">Recent Games</a></li>
						<li><a href="#profile" data-toggle="tab">Update Profile</a></li>
						<li><a href="#password" data-toggle="tab">Update Password</a></li>
					  </ul>
						  
					  <div class="tab-content">
						 <div class="tab-pane active" id="recent">
						   
						<div class="panel panel-default">

							<div class="panel-body">
								<div class="row" style="padding-top:8px;">
									<div class="col-md-4" >
										<div class="thumbnail">
										<img alt="300x200" src="assets/img/user_photo.png">
											<div class="caption">
												<h2>Quiz Games</h2>
												<p>Cocker Spaniel who loves treats.</p>
												<button type="button" class="btn btn-success">Play Again</button>  											
											</div>
										</div>
									</div>	
									<div class="col-md-4">
										<div class="thumbnail">
										<img alt="300x200" src="assets/img/user_photo.png">
											<div class="caption">
												<h2>Free Game</h2>
												<p>Cocker Spaniel who loves treats.</p>
												<button type="button" class="btn btn-success">Play Again</button>  												
											</div>
										</div>
									</div>	
									<div class="col-md-4">
										<div class="thumbnail">
										<img alt="300x200" src="assets/img/user_photo.png">
											<div class="caption">
												<h2>Action Game</h2>
												<p>Coc	ker Spaniel who loves treats.</p>
												<button type="button" class="btn btn-success">Play Again</button>  
											</div>
										</div>
									</div>							 
								</div>

							</div>

						</div>
						   
						 </div><!--/tab-pane-->
						 
						 <div class="tab-pane" id="profile">
							  <form class="form" method="post" id="updateProfile" onsubmit="return updateProfile();">
							<center><div id="thank" align="center" ></div></center>						 
								  <div class="form-group">
									  
									  <div class="col-xs-6">
										  <label for="first_name"><h4>First name</h4></label>
										  <input type="text" class="form-control fname" name="firstname" required id="firstname" placeholder="first name" title="enter your first name if any.">
									  </div>
								  </div>
								  <div class="form-group">
									  
									  <div class="col-xs-6">
										<label for="last_name"><h4>Last name</h4></label>
										  <input type="text" class="form-control lname" name="lastname" required id="lastname" placeholder="last name" title="enter your last name if any.">
									  </div>
								  </div>
					  
								  <div class="form-group">
									  
									  <div class="col-xs-6">
										  <label for="phone"><h4>Username</h4></label>
										  <input type="text" class="form-control uname" name="username" required  id="username" placeholder="enter phone" title="enter your phone number if any.">
									  </div>
								  </div>
					  
								  <div class="form-group">
									  
									  <div class="col-xs-6">
										  <label for="email"><h4>Email</h4></label>
										  <input type="email" class="form-control emailSignUp" required name="email" id="emailSignUp" placeholder="you@email.com" title="enter your email.">
									  </div>
								  </div>
								  <div class="form-group">
								   <div class="col-xs-12">
										<br>
										<button class="btn btn-lg btn-success" id="upPro" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>
									</div>
								  </div>
							</form>
						   
						 </div><!--/tab-pane-->
						 <div class="tab-pane" id="password">
									
							  <form class="form" method="post" id="passChange" onsubmit="return updatePassword();">								  
								  
								  <div class="form-group">
									  
									  <div class="col-xs-12">
										  <label for="password"><h4>Current Password</h4></label>
										  <input type="password" class="form-control" required name="changePassword" id="changePassword" placeholder="enter your current password" title="enter your current password.">
									  </div>
								  </div>
								  
								  <div class="form-group">
									  
									  <div class="col-xs-6">
										  <label for="password"><h4>New Password</h4></label>
										  <input type="password" class="form-control" required name="newPassword" id="newPassword" placeholder="enter new password." title="enter new password.">
									  </div>
								  </div>
								  <div class="form-group">
									  
									  <div class="col-xs-6">
										<label for="password2"><h4>Verify Password</h4></label>
										  <input type="password" class="form-control" required name="newVerifyPassword" id="newVerifyPassword" placeholder="enter new password again." title="enter new password again.">
									  </div>
								  </div>
								  <div class="form-group">
									   <div class="col-xs-12">
											<br>
											<button class="btn btn-lg btn-success" id="pasAct" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>
										</div>
								  </div>
							</form>		
							
								<div id="pswd_info">
								    <h4>Password must contain:</h4>
								    <ul>
								      <li id="letter" class="valid">At least <strong>one letter</strong></li>
								      <li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
								      <li id="number" class="invalid">At least <strong>one number</strong></li>
								      <li id="length" class="invalid">At least <strong>8 characters</strong></li>
								    </ul>
								</div>
								<div id="pswd_info1">
									<h4 style="color:black;">Password Verification:</h4>
								<ul>
								  <li id="replica" class="invalid"><strong>Password Match</strong></li>
								</ul>
							  </div>								
						  </div>
						   
						  </div><!--/tab-pane-->
					  </div><!--/tab-content-->

					</div><!--/col-9-->
				</div><!--/row-->
						
			
		</div>	<!-- dashboard ends -->
	</div>

        <form method="post" enctype="multipart/form-data" id="myform">
			<input id="file-input" type="file" class="hidden" name="file"/>	
        </form>	
 <script>
 
	showUpdate();
	
	$(".img-div").on("click", function(){
		$("#file-input").click();
	});
	
	$("#file-input").change(function(){
		$("#profileUpMsg").show("slow");
		var fd = new FormData();

		var files = $('#file-input')[0].files[0];

		fd.append('file-input',files);

		$.ajax({
			url:'login_check.php?p=updateImage',
			type:'post',
			data:fd,
			contentType: false,
			processData: false,
			success:function(response){
				if(response != 0){
					
					$("#profileUpMsg img").replaceWith('<center id="tempH3"><img src="assets/img/check.png" width="50px" /></center>');
					setInterval(function(){
					 	$("#profileUpMsg").hide("slow");
					$("#tempH3").replaceWith('<img src="assets/img/loader.gif" width="100px" />');						
					}, 2000);
					$(".imgUp").attr("src",response + '?' + (new Date()).getTime());
					
				}
				return false;
			},
			error:function(response){
				alert('error : ' + JSON.stringify(response));
			}
		});
		return false;
	});
	
	
  //you have to use keyup, because keydown will not catch the currently entered value
  $('input[type=password]').keyup(function() {

    // set password variable
    var pswd = $(this).val();
	var check = 0;
    //validate the length
    if (pswd.length < 8) {
      $('#length').removeClass('valid').addClass('invalid');
    } else {
      $('#length').removeClass('invalid').addClass('valid');
    }

    //validate letter
    if (pswd.match(/[A-z]/)) {
      $('#letter').removeClass('invalid').addClass('valid');
    } else {
      $('#letter').removeClass('valid').addClass('invalid');
    }

    //validate uppercase letter
    if (pswd.match(/[A-Z]/)) {		
      $('#capital').removeClass('invalid').addClass('valid');
    } else {
      $('#capital').removeClass('valid').addClass('invalid');
    }

    //validate number
    if (pswd.match(/\d/)) {
      $('#number').removeClass('invalid').addClass('valid');
    } else {
      $('#number').removeClass('valid').addClass('invalid');
    }

  }).focus(function() {
    $('#pswd_info1').hide();
    $('#pswd_info').show();
  }).blur(function() {
    $('#pswd_info').hide();
  });


  $('#newVerifyPassword').keyup(function() {

    // set password variable
    var pswrdVerify = $(this).val();

    //validate the same password
    if ($("#newPassword").val() != $("#newVerifyPassword").val()) {
		$("#pasAct").prop('disabled', true);		  		
      $('#replica').removeClass('valid').addClass('invalid');
    } else {
      $('#replica').removeClass('invalid').addClass('valid');
		$("#pasAct").prop('disabled', false);		  	  
    }


	
  }).focus(function() {
    $('#pswd_info').hide();
    $('#pswd_info1').show();
  }).blur(function() {
    $('#pswd_info1').hide();
  });
  
	 $('#username').focus(function() {
		if($("#firstname").val() != "" || $("#lastname").val() != ""){
			var str = $("#firstname").val().toUpperCase() +" "+ $("#lastname").val().toUpperCase() + " " + $("#firstname").val().toUpperCase() +""+ $("#lastname").val().toUpperCase();
			var patt = new RegExp($(this).val().toUpperCase());
			var res = patt.test(str);
			if(res == true){
				$("#thank").text('First or Last name cannot be username');
				$("#upPro").prop('disabled', true);
			}else{
				$("#thank").replaceWith('<div id="thank" align="center" ></div>');
				$("#upPro").prop('disabled', false);
			}		
		}
	 });
	 

	  $('#username').keyup(function() {
		var str = $("#firstname").val().toUpperCase() +" "+ $("#lastname").val().toUpperCase() + " " + $("#firstname").val().toUpperCase() +""+ $("#lastname").val().toUpperCase();
		var patt = new RegExp($(this).val().toUpperCase());
		var res = patt.test(str);
		if(res == true){
			$("#thank").text('First or Last name cannot be username');
			$("#upPro").prop('disabled', true);
		}else{
			$("#thank").replaceWith('<div id="thank" align="center" ></div>');
			$("#upPro").prop('disabled', false);
		}
		// $('#pswd_info').hide();
	  });
	  
	function updatePassword(){
		$("#pasAct").text('Changing in progress!');			
		var passData = $("#passChange").serialize();
		
		$.ajax({
			type:"POST",
			data :{pData:passData},
			url:"login_check.php?p=updatePass",
			dataType:"JSON",
			success:function(pa)
			{
				console.log(pa);
				
					if(pa.done == "1"){
						$("#pasAct").text('Successfully Changed!');
						document.getElementById("passChange").reset();						
						setTimeout(logOutMsg, 2000);										
					}

					if(pa.done == "2"){
						$("#pasAct").text('Failed Changing!');
						document.getElementById("passChange").reset();							
						setTimeout(hideLoginMsg, 2000);				
					}
					
					if(pa.done == "3"){
						$("#pasAct").text('Password not match!');
						document.getElementById("passChange").reset();							
						setTimeout(hideLoginMsg, 2000);				
					}

					if(pa.done == "4"){
						$("#pasAct").text('Current Password is invalid!');
						document.getElementById("passChange").reset();							
						setTimeout(hideLoginMsg, 2000);				
					}

					if(pa.done == "5"){
						$("#pasAct").text('Same Password!');
						document.getElementById("passChange").reset();							
						setTimeout(hideLoginMsg, 2000);			
					}
							
				return false;
			}
		});		

		
		return false;
	}
	
	
	function logOutMsg(){
		$("#pasAct").replaceWith('<div id="abc"><button formnovalidate class="btn btn-lg btn-success" onclick="logoutInt();" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Do You want to stay login? Yes!</button><button formnovalidate class="btn btn-lg btn-danger" onclick="logoutExa();" id="abcde" type="submit"><i class="glyphicon glyphicon-cross"></i> No, Log me out!</button></div>');			
		// $("#pasAct").text('Now Logging you Out!');
		// setTimeout(logoutExa, 2000);
	}	
	function logoutInt(){
		$("#abc").replaceWith('<button class="btn btn-lg btn-success" id="pasAct" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>');
		return false;		
	}
	
	function logoutExa(){				
		window.location.href = 'logout.php?logout';				
	}
	function hideLoginMsg(){
		$("#pasAct").replaceWith('<button class="btn btn-lg btn-success" id="pasAct" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>');		
	}
	
	function updateProfile(){
		$("#upPro").text('Changing in progress!');			
		$.ajax({
			type:"POST",
			url:"login_check.php?p=updateProfile",
			dataType:"JSON",
			success:function(p)
			{
				// alert(p);
				var a1 = p.fname;
				var a2 = p.lname;
				var a3 = p.uname;
				var a4 = p.email;
				var b1 = $("#firstname").val();
				var b2 = $("#lastname").val();
				var b3 = $("#username").val();
				var b4 = $("#emailSignUp").val();
				
				if(b1 == a1 && b2 == a2 && b3 == a3 && b4 == a4){
					$("#upPro").text('Nothing Changed');
					setTimeout(hideUpdateMsg, 3000);
					return false;
				}else{
					var customData = $("#updateProfile").serialize();
					
					$.ajax({
						type:"POST",
						data:{rData:customData},
						url:"login_check.php?p=insertProfile",
						dataType:"JSON",
						success:function(e)
						{
							if(e.done == 1){
								showUpdate();
								$("#upPro").text('Successfully Changed!');
								setTimeout(hideUpdateMsg, 3000);								
								return false;
							}else{
								$("#upPro").text('Cannot Change!');
								setTimeout(hideUpdateMsg, 3000);	
								return false;
							}
						}
						
					});		
					
					return false;
					
				}
				
				return false;
			}
		});		

		
		return false;
	}
	
	function hideUpdateMsg(){
		$("#upPro").replaceWith('<button class="btn btn-lg btn-success" id="upPro" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>');
	}
	
	function showUpdate(){
		
		$.ajax({
			type:"POST",
			url:"login_check.php?p=updateProfile",
			dataType:"JSON",
			success:function(p)
			{
				$(".fname").text(p.fname).val(p.fname);
				$(".lname").text(p.lname).val(p.lname);
				$(".uname").text(p.uname).val(p.uname);
				$(".emailSignUp").text(p.email).val(p.email);
				return false;
			}
		});	
				
		$.ajax({
			type:"POST",
			url:"login_check.php?p=getImage",
			dataType:"JSON",
			success:function(pp)
			{
				$(".imgUp").attr("src",pp.picUp);
				return false;
			}
		});	
		
	}
 
 </script>

		<!--== Footer Area==-->
		<?php include("footer.php"); ?>
