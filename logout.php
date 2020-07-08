<?php
    include_once 'user.php';
    //$instance=User::create();
    $instance = new User("","","",$username,$password,"","");
    $instance->logout();

?>