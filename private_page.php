<?php
session_start();
include_once 'DBConnector.php';

if(!isset($_SESSION['username'])){
    header("Location:login.php");
}
//api key
/*
	function fetchUserApiKey()
	{
		$username = $_SESSION['username'];
		$key = "";
		$db = new DBConnector;
		$conn = $db->openDatabase();
		$re = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
		while($row = mysqli_fetch_array($re))
		{
			$id = $row['id'];
		}
		$res = mysqli_query($conn, "SELECT api_key FROM api_keys WHERE user_id = '$id'");
		while($row = mysqli_fetch_array($res))
 		{
 			$key = $row['api_key'];
 		}
 		return $key;
	}
 */
?>
<html>
    <head>
    <!--details of java script to be added to the private page????-->
        <title>Private Page</title>
        <script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">
    </head>
    <body>
        <p>This is a private page</p>
        <p>We want tp protect it</p>
        <p><a href="logout.php">LOGOUT</a></p>
    </body>
</html>