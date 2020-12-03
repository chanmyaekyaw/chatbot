<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
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
<?php session_start();
if(!$_SESSION['id'])
{
	header("location:index.php");
}
include('db.php');
$sql=mysqli_query($conn,"SELECT * FROM user WHERE id='".$_SESSION['id']."'");
$row=mysqli_fetch_assoc($sql);
 ?>
<h1 class="text-center mt-5"><img class="rounded-circle border border-success" src="img/<?php echo $row['photo']; ?>" width="60">  <?php echo $row['name'];?> is Level-1 Passed!</h1><br>
<div class="text-center">
<button class="btn btn-info btn-sm">Go to Level-2</button>
<a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
</div>
</body>
</html>