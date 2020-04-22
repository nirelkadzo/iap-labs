<?php
include "crud.php";
include_once("DBConnector.php");

class User implements Crud{
  private $user_id;
  private $first_name;
  private $last_name;
  private $city_name;


  function __construct ($first_name,$last_name,$city_name){
  $this->first_name = $first_name;
  $this->last_name = $last_name;
  $this->city_name = $city_name;
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
	  $res = mysqli_query($db->conn,"INSERT INTO users (first_name,last_name,user_city) VALUES ('$fn','$ln','$city')") OR die("Error".mysqli_error($db->conn));
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

  }
?>