<?php

include('../../includes/connection.php');


    // Assign input data from form to variables
	$student_id = $_POST['student_id'];
	$first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
	$address = $_POST['address'];
    $dob = $_POST['dob'];
    $nic = $_POST['nic'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
               
        //Insert to Database
            $registrationQuery = "UPDATE `students` SET `student_id` = '$student_id', `first_name` = '$first_name', `last_name` = '$last_name', `address` = '$address', `dob` = '$dob', `nic` = '$nic', `phone` = '$phone', `email` = '$email', `password` = '$password' WHERE `students`.`student_id` = '$student_id';";

            
            if (mysqli_query($connection,$registrationQuery) === TRUE) {
                $message = base64_encode(urlencode("Student Updated Successfully"));
				header('Location:../admin-student-edit.php?msg=' . $message);
				exit();
            } 
            
            else {
                $message = base64_encode(urlencode("SQL Error while Registering"));
				header('Location:../admin-student-edit.php?msg=' . $message);
				exit();
            }
        



mysqli_close($connection);
   


?>