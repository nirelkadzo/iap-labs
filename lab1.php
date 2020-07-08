<?php
include 'DBConnector.php';
include 'user.php';
include 'fileUploader.php';
session_start();
$_SESSION['style'] = "none";

if(isset($_POST['btn-save'])){
	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$city=$_POST['city_name'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	
	$utc_timestamp = $_POST['utc_timestamp'];
		$offset = $_POST['time_zone_offset'];
		$file_original_name = basename($_FILES['fileToUpload']['name']);
		$file_type = strtolower(pathinfo($file_original_name,PATHINFO_EXTENSION));
		$file_size = $_FILES['fileToUpload']['size'];
		$tmp_name = $_FILES["fileToUpload"]["tmp_name"];

	$user = new User($first_name,$last_name,$city,$username,$password,$utc_timestamp,$offset);
	// create object for file upload
	
	$db = new DBConnector;
	$conn = $db->openDatabase();

	
	$uploader = new FileUploader($file_original_name,$file_type,$file_size,$tmp_name);

	if(!$user->validateForm()){
		$user->createFormErrorSessions();
		header("Refresh:0");
		die();
	}
	//$res=$user->save($db->conn);
	$res = $user->checkUsername($conn,$username);
	$_SESSION['style'] = $res;
	$check = $uploader->moveFile();

	if($check == "")
		{
			$result = $user->save($conn,$res);
			$username = $user->getUsername();
			$file_upload_response = $uploader->uploadFile($conn,$username);
			if($res && $file_upload_response)
			{
				echo "Save operation was successful";
			}
		}
		else
		{
			echo $check;
		}

	//$result=$user->readAll();

	/*
	$file_upload_response=$uploader->uploadFile();
	//add on && $file_upload_response to $res to see if save operation was succesful
	if($res && $file_upload_response){
		echo "Save operation was succesful";
	}else{
		echo "An error occured!";
	}
	$result=$user->readAll();*/
}
?>

<html>
	<head>
		<title>Lab1</title>
		<script type="text/javascript" src="validate.js"></script>
		<link rel="stylesheet" type="text/css" href="validate.css">
	</head>
	<body>
	<!--removeed the action-->
		<form method="post" name="user_details" id="user_details" onsubmit="return validateForm()" >
			<table align="center">
				<tr>
				<td>
					<div id="form-errors">
						<?php
							
							if(!empty($_SESSION['form-errors]'])){
								echo " ". $_SESSION['form-errors'];
								unset($_SESSION['form_errors']);
							}
						?>
					</div>
				</td>
				</tr>
				<tr>
					<td><input type="text" name="first_name" required placeholder="First Name"/></td>
				</tr>
				<tr>
					<td><input type="text" name="last_name" required placeholder="Last Name"/></td>
				</tr>
				<tr>
					<td><input type="text" name="city_name" required placeholder="City"/></td>
				</tr>
				<tr>
					<td>Profile picture:<input type="file" name="fileToUpload" id="fileToUpload"></td>
				
				</tr>
				<tr>
					<td><input type="text" name="username" required placeholder="Username"/></td>
					<td><label style="display: <?php echo $_SESSION['style']?>">Username unavailable, try another one</label></td>
				</tr>
				<tr>
					<td><input type="password" name="password" required placeholder="Password"/></td>
				</tr>
				<input type="hidden" name="utc_timestamp" id="utc_timestamp" value="">
				<input type="hidden" name="time_zone_offset" id="time_zone_offset" value="">
				<tr>
					<td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
				</tr>
				<tr>
					<td><a href="login.php">Login</a></td>
				</tr>
			</table>
		</form>


	</body>

	
</html>

