<?php

    if(isset($_POST['adminLogin'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
    }

    $file1 = "../abstracts/file1.txt";
    rename($file1, "../abstracts/file3.txt");

?>