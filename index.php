<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Chat Bot</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<h3 class="text-center mt-5 text-dark"><b>AUTHENTICATION SYSTEM</b></h3>
	<div class="row mt-5">
		<div class="col-md-6">
			<fieldset class="border p-3">
				<legend  class="w-auto bg-info text-white pb-1 px-2 rounded">Registration Form</legend>
				<form method="POST" action="" enctype="multipart/form-data">
			<input type="text" placeholder="Enter Username" name="name" class="form-control" id="name" required>
			<span class="badge badge-warning name_warning"></span>		
			<br>

		<div class="row">
			<div class="col-md-6">
				<input type="password" name="password" placeholder="Enter Password" class="form-control" id="password" required>				
			</div>
		<div class="col-md-6">
				<input type="password" name="cpassword" placeholder="Enter Confirm Password" class="form-control" id="cpassword" required>
			</div>
		</div>
			<span class="password_warning badge badge-warning"></span>
			<br>

		<div class="row">
			<div class="col-md-6">
				<input type="number" placeholder="Enter Phone Number" required name="phone" class="form-control" id="phone">	
				<span class="phone_warning badge badge-warning"></span>			
			</div>
			<div class="col-md-6">
				<input type="email" placeholder="Enter Email" class="form-control" name="email" id="email" required>
			</div>
		</div>
			<br>
	
			Profile Photo: <input type="file" name="photo" id="photo"><p></p>
			<div class="row" required>
				<div class="col-md-6">
			<select class="form-control" id="country" name="country" required>
				<option>Choose Country</option>
				<option>Myanmar</option>
				<option>United State</option>
				<option>Singapore</option>
				<option>Japan</option>
			</select>
				</div>
				<div class="col-md-4">
			<select class="form-control" id="yrs" required>
				<?php for($i=1980;$i<2019;$i++) {  ?>
				<option value="<?php echo 2019-$i; ?>"><?php echo $i; ?></option>
			<?php } ?>
			</select>
				</div>
				<div class="col-md-2">
					<input type="text" id="age" class="form-control" name="age" readonly required>
				</div>
			</div>
			<br>
			<textarea class="form-control" id="address" name="address" placeholder="Enter Address" required></textarea><br>
			<button class="btn btn-info btn-sm register" name="register">Register</button>
		</form>
			</fieldset>
		</div>

		<!-- ...................login................. -->
		<div class="col-md-6 ">
  <div class="alert alert-danger alert-dismissible fade show login_alert" style="display: none;">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Successfully Registrated, </strong>Please Login!
  </div>
  <div class="alert alert-warning alert-dismissible fade show fail_alert" style="display: none;">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Login Failed, </strong>Try Again!
  </div>
<fieldset class="border p-3">
				<legend  class="w-auto bg-danger text-white pb-1 px-2 rounded">Login Form</legend>
				<form method="POST" action="">
			<input type="text" placeholder="Enter Username" id="user_name" name="name" class="form-control" required><br>
			<input type="password" placeholder="Enter Password" id="user_password" name="password" class="form-control" required><br>
			<button class="btn btn-danger btn-sm" name="login">Login</button>
			</fieldset>
		</div>
	</div>
</div>
<?php
include('db.php');
if(isset($_POST['register']))
{
	$name=$_POST['name'];
	$password=$_POST['password'];
	$cpassword=$_POST['cpassword'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$photo=$_FILES['photo']['name'];
	$tmp=$_FILES['photo']['tmp_name'];
	if($photo)
	{
		move_uploaded_file($tmp, "img/$photo");
	}
	$country=$_POST['country'];
	$age=$_POST['age'];
	$address=$_POST['address'];
	$query=mysqli_query($conn,"INSERT INTO user (name,password,cpassword,phone,email,photo,country,age,address,created_date,modified_date) VALUES ('$name','$password','$cpassword','$phone','$email','$photo','$country','$age','$address',now(),now())");
	if($query){ ?>
		<script>
			$('.login_alert').show('5000');
		</script>
	<?php	
	}
}
if(isset($_POST['login']))
{
	$name=$_POST['name'];
	$password=$_POST['password'];
	$sql=mysqli_query($conn,"SELECT * FROM user WHERE name='$name' AND password='$password'");
	if(mysqli_num_rows($sql)>0)
	{ 
		$row=mysqli_fetch_assoc($sql);
		$_SESSION['id']=$row['id'];
		?>
		<script type="text/javascript">
			window.location.href="home.php";
		</script>
	<?php }else{ ?>
		<script>
			$('.fail_alert').show('5000');
		</script>
	<?php
	}
}
?>

<script type="text/javascript">
$(document).ready(function(){	
	$('#yrs').click(function(){
		var age=$(this).val();
		$('#age').val(age);
	});

	$('#name').keyup(function(){
		var name=$(this).val();
		if(name=="")
		{
			$('.name_warning').html("");
			$('.register').attr("disabled",false);			 			
		}else{
			$.ajax({
			url:'action.php',
			type:'POST',
			data:{name:name},
			dataType:'json',
			success:function(data){
			$('.name_warning').html(data.name+" is already exist");
			$('.register').attr("disabled",true);
			 	}
			 });
			 }
		});	
	$('#cpassword,#password').keyup(function(){
		var cpassword=$('#cpassword').val();
		var password=$('#password').val();
		if(password!=cpassword)
		{
			$('.password_warning').html("Password and Confirm Password do not match, Try agian");
			$('.register').attr("disabled",true);
		}else{
			$('.password_warning').html("");
			$('.register').attr("disabled",false);
		}
	});

	$('#phone').keyup(function(){
		var phone=$(this).val();
		if(phone.length==11 || phone.length=="")
		{
			$('.phone_warning').html("");
			$('.register').attr("disabled",false);
		}else{
			$('.phone_warning').html("Invalid Number");
			$('.register').attr("disabled",true);
		}		
	});

	$('#user_name').focus(function(){
		$('.login_alert').hide('5000');
		$('.fail_alert').hide('5000');
	});

});

</script>

</body>
</html>