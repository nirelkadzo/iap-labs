<?php
/*include_once 'DBConnector.php';*/
include_once 'user.php';
$conn= new DBConnector;

if(isset($_POST['btn-save'])){
	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$city=$_POST['city_name'];

	$user= new User($first_name, $last_name, $city);
	if($user->validateForm()){
		$user->createFormErrorSessions();
		header("Refresh :o");
		die();
	}
	$res=$user->save();

	if($res){
		echo "Save operation was succesful";
	}else{
		echo "An error occured!";
	}
	$user->readAll();
}
?>

<html>
	<head>
		<title>Lab1</title>
		<script type="text/javascript" src="validate.js"></script>
		<link rel="stylesheet" type="text/css" href="validate.css">
	</head>
	<body>
		<form method="post">
			<table align="center">
				<tr>
				<td>
					<div id="form-errors">
						<?php
							session_start();
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
					<td><button type="submit" name="btn-save" id="btn_save" onsubmit="return validateForm()" action=<?=$_SERVER['PHP_SELF']?>><strong>SAVE</strong></button></td>
				</tr>
			</table>
		</form>


	</body>
</html>

