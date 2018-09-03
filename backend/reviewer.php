<?php

    require_once('./dbcon.php');

    if(isset($_POST['reviewerValidation'])){
        $id = $_POST['id'];
        $password = $_POST['password']; 
    }

?>