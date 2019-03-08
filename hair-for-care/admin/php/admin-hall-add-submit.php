<?php

include('../../includes/connection.php');


    // Assign input data from form to variables
	$hall_no = $_POST['hall_no'];
	$floor = $_POST['floor'];
    $capacity = $_POST['capacity'];
    
   
        //Check if subject already exists
        $selecthall= "SELECT * FROM lecture_hall WHERE hall_no ='$hall_no' " ;
        $allhallquery = mysqli_query($connection, $selecthall) ;  
        $num = mysqli_num_rows($allhallquery);
    
        if($num > 0){
        $message = base64_encode(urlencode("Lecture Hall already exists"));
        header('Location:../admin-hall-add.php?msg=' . $message);
        exit();
        }
        
        //Insert to Database
        else {
            $hallQuery = "INSERT INTO lecture_hall (hall_no, floor, capacity) VALUES ('$hall_no', '$floor', '$capacity')";            

            
            if (mysqli_query($connection,$hallQuery) === TRUE) {
                $message = base64_encode(urlencode("Lecture Hall Added Successfully"));
				header('Location:../admin-hall-add.php?msg=' . $message);
				exit();
            } 
            
            else {
                $message = base64_encode(urlencode("SQL Error while Adding Lecture Hall"));
				header('Location:../admin-hall-add.php?msg=' . $message);
				exit();
            }
        }
        



mysqli_close($connection);
   


?>