<?php

    require_once('./dbcon.php');

    if (isset($_POST['submitAbstract'])){
        $fullName = $_POST['title']." ".$_POST['fullname'];
        $sex = $_POST['sex'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phoneNumber = $_POST['phoneNumber'];
        $sex = $_POST['sex'];
        $abstract_title = $_POST['abstractTitle'];
        $abstract = $_FILES['abstract'];
        $image = $_FILES['image'];

        $uploadDirectory = '../abstracts/';

        //Check if abstract does not exist
        $checkAbstract = $conn -> prepare("SELECT abstractTitle FROM abstract WHERE abstractTitle = :title");
        $checkAbstract->bindParam(':title', $abstract_title);
        $checkAbstract->execute();

        //if the number of result returned is more than 0, then abstract exists already
        if ($checkAbstract->rowCount()>0){
            echo "Abstract exists";
        }
        else{

            $tmp_name_abstract = $_FILES['abstract']['tmp_name'];
            $tmp_name_image = $_FILES['image']['tmp_name'];

            $uniqueID = generateUniqueID();

            $saveInfo = $conn -> prepare("INSERT INTO users SET fullName = :fn, sex = :sex, userImage = :img, address = :addy, email = :email, phoneNumber = :pnum, uniqueID = :uniqueID");
            
            $imageExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newImageName = $uniqueID.".".$imageExtension;

            $saveInfo -> bindParam(':fn', $fullName);
            $saveInfo -> bindParam(':sex', $sex);
            $saveInfo -> bindParam(':img', $newImageName);
            $saveInfo -> bindParam(':addy', $address);
            $saveInfo -> bindParam(':email', $email);
            $saveInfo -> bindParam(':pnum', $phoneNumber);
            $saveInfo -> bindParam(':uniqueID', $uniqueID);

            $saveAbstractInfo = $conn -> prepare("INSERT INTO abstract SET userID = :userID, abstractTitle = :abstractTitle, filePath = :abstractPath");

            $abstractExtension = pathinfo($_FILES['abstract']['name'], PATHINFO_EXTENSION);
            $newAbstractName = $uniqueID.".".$abstractExtension;

            $saveAbstractInfo->bindParam(':userID', $uniqueID);
            $saveAbstractInfo->bindParam(':abstractTitle', $abstract_title);
            $saveAbstractInfo->bindParam(':abstractPath', $newAbstractName);

            try{
                $conn -> beginTransaction();
                $saveInfo->execute();
                $saveAbstractInfo->execute();
                move_uploaded_file($tmp_name_abstract, "../abstracts/$newAbstractName");
                move_uploaded_file($tmp_name_image, "../userImages/$newImageName");
                $conn->commit();
                header('location: '.$_SERVER['HTTP_REFERER']);
            }catch(PDOException $e){
                $conn->rollback();
                echo $e->getMessage();
            }

        }

    }

    function generateUniqueID(){
        try{
            $conn = new PDO('mysql:host=localhost; dbname=abstractmanagement','root','');
            $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        $randomString = '';
        do{
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $exists = false;
            for ($i = 0; $i < 5; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $check = $conn -> prepare ("SELECT uniqueID FROM users WHERE uniqueID = :id");
            $check -> bindParam(':id', $randomString);

            if ($check->rowCount()>0){
                $exists = true;
            }
        }while($exists);
        return $randomString;
    }

?>