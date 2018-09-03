<?php
    require_once('dbcon.php');
    if(isset($_POST['review'])){
        $reviewerID = $_POST['reviewerID'];
        $abstractID = $_POST['abstractID'];
        $reviewScore = $_POST['reviewScore'];
        //check if the reviewer has reviewed already
        $stmt = $conn->prepare("SELECT * FROM reviews WHERE abstractID = :abID AND reviewerID = :reID");
        $stmt -> bindParam(':abID', $abstractID);
        $stmt -> bindParam(':reID', $reviewID);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['reviewScore'] != null){
            //Abstract has already been reviewed...
            echo "Abstract score has already been recorded";
        }else{
            //Submit abstract score..
            $stmt = $conn -> prepare("INSERT INTO reviews SET abstractID = :abstractID, reviewerID = :reviewerID, reviewScore = :reviewScore");
            $stmt->bindParam(':abstractID', $abstractID);
            $stmt->bindParam(':reviewerID', $reviewID);
            $stmt->bindParam(':reviewScore', $reviewScore);

            echo $stmt->execute() ? "Saved" : "Error";
        }

        // echo $reviewerID."=>".$abstractID."=>".$reviewScore;
        

    }
?>