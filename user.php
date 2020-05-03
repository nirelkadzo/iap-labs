<?php
include "crud.php";
include_once("DBConnector.php");
include "authenticate.php";

// $db=new DBConnnector;

class User implements Crud{
  private $user_id;
  private $first_name;
  private $last_name;
  private $city_name;

  private $username;
  private $password;


  function __construct ($first_name,$last_name,$city_name,$username,$password){
  $this->first_name = $first_name;
  $this->last_name = $last_name;
  $this->city_name = $city_name;
  $this->username=$username;
  $this->password=$password;
  /*$db= new DBConnector();*/
  }

	  public function setUserId($user_id){
	  $this->user_id = $user_id;
	  }
	     
	  public function getUserId($user_id){
	  $this->user_id = $user_id;
	  }

	  public function save(){
	  $db= new DBConnector();
	  $fn = $this->first_name;
	  $ln = $this->last_name;
	  $city = $this->city_name;
	  $uname=$this->username;
	  $this->hashPassword();
	  $pass=$this->password;
     
	  $res = mysqli_query($db->conn,"INSERT INTO users (first_name,last_name,user_city,username,password) VALUES ('$fn','$ln','$city','$uname','$pass')") OR die("Error".mysqli_error($db->conn));
	  $db->closeDatabase(); 
	  return $res;
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
	  public function create(){
		  $instance=new self();
		  return $instance;
	  }
	  //username setter
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
		  $res=mysqli_query("SELECT* FROM users") or die("Error ".mysqli_error());
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