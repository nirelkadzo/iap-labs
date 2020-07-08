<?php
   interface Crud{
   //add $con to save($con)
    public function save($conn,$res);
    public function readAll();
    public function readUnique();
    public function search();
    public function update();
    public function removeOne();
    public function removeAll();

    public function validateForm();
    public function createFormErrorSessions();
    public function checkUsername($conn,$username);

 
   }



 ?>


