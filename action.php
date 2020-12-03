<?php include('db.php');
if(isset($_POST['name']))
{
	$name=$_POST['name'];
	$sql=mysqli_query($conn,"SELECT * FROM user WHERE name='$name'");
	$row=mysqli_fetch_assoc($sql);
	echo json_encode($row);
}
?>