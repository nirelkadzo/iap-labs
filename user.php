<?php
include 'crud.php';
//include_once("DBConnector.php");
include 'authenticator.php';

// $db=new DBConnnector;
abstract class User implements Crud, Authenticator{
  private $user_id;
  private $first_name;
  private $last_name;
  private $city_name;

  private $username;
  private $password;

  private $utc_timestamp;
  private $offset;
//insert the utc timestamp to the function construct
  public function __construct ($first_name,$last_name,$city_name,$username,$password,$utc_timestamp,$offset){
  $this->first_name = $first_name;
  $this->last_name = $last_name;
  $this->city_name = $city_name;
  $this->username=$username;
  $this->password=$password;
  $this->utc_timestamp = $utc_timestamp;
  $this->offset = $offset;
}

  public function checkUsername($conn,$username)
  {
	  $uname = $this->username;
	  $res = mysqli_query($conn,"SELECT username FROM user WHERE username LIKE '$username'");
	  if($res->num_rows == 0)
	  {
		  $style = "none";
	  }
	  else
	  {
		  $style = "";
	  }
	  return $style;
  }

  public function setUsername($username)
  {
	  $this->username = $username;
  }

  public function getUsername()
  {
	  return $this->username;
  }

  public function setPassword($password)
  {
	  $this->password = $password;
  }

  public function getPassword()
  {
	  return $this->password;
  }

  public function setUserId($user_id)
  {
	  $this->user_id = $user_id;
  }

  public function getUserId()
  {
	  return $this->user_id;
  }

  public function setTimeStamp($utc_timestamp)
  {
	  $this->utc_timestamp = $utc_timestamp;
  }

  public function getTimeStamp()
  {
	  return $this->utc_timestamp;
  }

  public function setOffset($offset)
  {
	  $this->offset = $offset;
  }

  public function getOffset()
  {
	  return $offset;
  }



	  public function save($conn,$res){
	  //$db= new DBConnector();
	  $fn = $this->first_name;
	  $ln = $this->last_name;
	  $city = $this->city_name;

	  $uname=$this->username;
	  $this->hashPassword();
	  $pass=$this->password;
	 
	  //time stamppps???
	  $timestamp = $this->utc_timestamp;
	  $off = $this->offset;
	  /* ecess
	  $res = mysqli_query($db->conn,"INSERT INTO users (first_name,last_name,user_city,username,password) VALUES ('$fn','$ln','$city','$uname','$pass')") OR die("Error".mysqli_error($db->conn));
	  // ecess$db->closeDatabase(); 
	  return $res;*/
	  if($res == "none")
			{
				$result = mysqli_query($conn,"INSERT INTO user(first_name,last_name,user_city,username,password,utctimestamp,offset) VALUES ('$fn','$ln','$city','$uname','$pass','$timestamp','$off')");
				$re = mysqli_query($conn,"SELECT id FROM user WHERE username = '$uname'");
				while($row = mysqli_fetch_array($re))
				{
					$id = $row['id'];
				}
				$r = mysqli_query($conn,"INSERT INTO api_keys (user_id) VALUES('$id')");
				return $result;
			}
	  }

	  public function readAll(){
		  $db=new DBConnector();
		  $res=mysqli_query($db->conn,"SELECT * FROM users");

		  if(mysqli_num_rows($res)>0){
			  while($row=mysqli_fetch_assoc($res)){
				  echo "<br>".$row['id']. " | ".$row['first_name']." | ".$row['last_name']." | ".$row['user_city']."<br>";
			  }
		  }else{
			  echo "The database is empty";
		  }

		  $db->closeDatabase();
	  
	  }
	  //constructors
	  /*
	  public function create(){
		  $instance=new self();
		  return $instance;
	  }*/
	  /*username setter
	  public function setUsername($username){
		  $this->username=$username;
	  }
	  public function getUsername(){
		  return $this->username;
	  }
	  //password setter
	  public function setPassword($password){
		  $this->password=$password;
	  }
	  public function getPassword(){
		  return $this->password;
	  }
	  public function hashPassword(){
		  $this->password=password_hash($this->password,PASSWORD_DEFAULT);
	  }

	  public function isPasswordCorrect(){
		  //check db connector
		  $db= new DBConnector;
		  $found=false;
		  $res=mysqli_query($db,"SELECT* FROM users") or die("Error ".mysqli_error());
//check language for writing the fech
		  while($row=mysqli_fetch_array($res)){
			  if(password_verify($this->getPassword(), $row['password'])&& $this->getUsername()==$row['username']){
				  $found=true;
			  }
		  }
		  $db->closeDatabase();
		  return $found;

	  }
	  public function login(){
		  if($this->isPasswordCorrect()){
			  //password in correct, so we load the protected page
			  header("Location:private_page.php");
		  }
	  }
	  public function createUserSession(){
		  session_start();
		  $_SESSION['username']=$this->getUsername();
	  }
	  public function logout(){
		  session_start();
		  unset($_SESSION['username']);
		  session_destroy();
		  header("Location:lab1.php");
	  }
*/


	

		public function hashPassword()
		{
			$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		}

		public function isPasswordCorrect($conn)
		{
			$found = false;
			$result = mysqli_query($conn,"SELECT * FROM user") or die("Error" . mysqli_error());

			while($row = mysqli_fetch_array($result))
			{
				if(password_verify($this->password, $row['password']) && $this->getUsername() == $row['username'])
				{
					$found = true;
				}
			}
			return $found;
		}

		public function login($conn)
		{
				header("Location:private_page.php");
		}

		public function createUserSession()
		{
			session_start();
			$_SESSION['username'] = $this->getUsername();
		}

		public function logout()
		{
			session_start();
			unset($_SESSION['username']);
			session_destroy();
			header("Location:lab1.php");
		}
	  public function readUnique(){
	          return null;
	  }

	  public function search(){
	       return null;
	  }

	  public function update(){
	  return null;
	  }

	  public function removeOne(){
	      return null;
	  }

	  public function removeAll(){
	      return null;
	  }
	  public function validateForm(){
		$fn=$this->first_name;
		$ln=$this->last_name;
		$city=$this->city_name;
		if($fn==""||$ln==""||$city=""){
			return false;
		}
		return true;
	}

	public function createFormErrorSessions(){
		session_start();
		$_SESSION['form_errors']="All fields are required";
	}

  }
?>