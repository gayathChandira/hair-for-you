<?php

include('../../includes/connection.php');


    // Assign input data from form to variables
	$student_id = $_POST['cashier_id'];
	$first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
	$address = $_POST['address'];
   $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
   
   
        //Check if email already exists
        $selectmail= "SELECT * FROM cashier WHERE email ='$email' " ;
        $allmailquery = mysqli_query($connection, $selectmail ) ;  
        $num = mysqli_num_rows($allmailquery);
    
        if($num > 0){
        $message = base64_encode(urlencode("cashier already exists"));
        header('Location:../admin-cashiert-add.php?msg=' . $message);
        exit();
        }
        
        //Insert to Database
        else {
            $registrationQuery = "INSERT INTO cashier (cashier_id, first_name, last_name, address, phone, email, password) VALUES ('$student_id', '$first_name', '$last_name', '$address', '$phone', '$email', '$password')";
            

            
            if (mysqli_query($connection,$registrationQuery) === TRUE) {
                $message = base64_encode(urlencode("cashier Added Successfully"));
				header('Location:../admin-cashier-add.php?msg=' . $message);
				exit();
            } 
            
            else {
                $message = base64_encode(urlencode("SQL Error while Registering"));
				header('Location:../admin-cashiert-add.php?msg=' . $message);
				exit();
            }
        }
        



mysqli_close($connection);
   


?>