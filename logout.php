<?php
include('db.php');
session_start();
unset($_SESSION['id']);
header("location:index.php");
?>