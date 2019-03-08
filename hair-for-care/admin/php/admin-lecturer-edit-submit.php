<?php

include('../../includes/connection.php');


    // Assign input data from form to variables
	$lecturer_id = $_POST['lecturer_id'];
	$first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
	$address = $_POST['address'];
    $nic = $_POST['nic'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
               
        //Insert to Database
            $registrationQuery = "UPDATE `lecturers` SET `lecturer_id` = '$lecturer_id', `first_name` = '$first_name', `last_name` = '$last_name', `address` = '$address', `nic` = '$nic', `phone` = '$phone', `email` = '$email', `password` = '$password' WHERE `lecturers`.`lecturer_id` = '$lecturer_id';";

            
            if (mysqli_query($connection,$registrationQuery) === TRUE) {
                $message = base64_encode(urlencode("Lecturer Updated Successfully"));
				header('Location:../admin-lecturer-edit.php?msg=' . $message);
				exit();
            } 
            
            else {
                $message = base64_encode(urlencode("SQL Error while Registering"));
				header('Location:../admin-lecturer-edit.php?msg=' . $message);
				exit();
            }
        



mysqli_close($connection);
   


?>