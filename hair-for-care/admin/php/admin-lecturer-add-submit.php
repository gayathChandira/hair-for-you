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
   
        //Check if email already exists
        $selectmail= "SELECT * FROM lecturers WHERE email ='$email' " ;
        $allmailquery = mysqli_query($connection, $selectmail ) ;  
        $num = mysqli_num_rows($allmailquery);
    
        if($num > 0){
        $message = base64_encode(urlencode("Lecturer already exists"));
        header('Location:../admin-lecturer-add.php?msg=' . $message);
        exit();
        }
        
        //Insert to Database
        else {
            $registrationQuery = "INSERT INTO lecturers (lecturer_id, first_name, last_name, address, nic, phone, email, password) VALUES ('$lecturer_id', '$first_name', '$last_name', '$address', '$nic', '$phone', '$email', '$password')";
            

            
            if (mysqli_query($connection,$registrationQuery) === TRUE) {
                $message = base64_encode(urlencode("Lecturer Added Successfully"));
				header('Location:../admin-lecturer-add.php?msg=' . $message);
				exit();
            } 
            
            else {
                $message = base64_encode(urlencode("SQL Error while Registering"));
				header('Location:../admin-lecturer-add.php?msg=' . $message);
				exit();
            }
        }
        



mysqli_close($connection);
   


?>