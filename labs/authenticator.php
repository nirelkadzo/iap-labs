<?php
interface Authenticator{
    public function hashPassowrd();
    public function isPasswordCorrect();
    public function login();
    public function logout();
    public function createFormErrorSessions();
    
}
?>