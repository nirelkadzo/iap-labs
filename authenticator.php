<?php
interface Authenticator{
    public function hashPassowrd();
    public function isPasswordCorrect($conn);
    public function login($conn);
    public function logout();
    public function createFormErrorSessions();
    
}
?>