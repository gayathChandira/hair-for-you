<?php

include('../../includes/connection.php');


    // Assign input data from form to variables
	$tute_issuer_id = $_POST['tute-issuer_id'];
	$first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
	$email = $_POST['email'];
    $password = sha1($_POST['password']);
   
   
        //Check if email already exists
        $selectmail= "SELECT * FROM tute_issuer WHERE email ='$email' " ;
        $allmailquery = mysqli_query($connection, $selectmail ) ;  
        $num = mysqli_num_rows($allmailquery);
    
        if($num > 0){
        $message = base64_encode(urlencode("tute-issuer already exists"));
        header('Location:../admin-tute-issuer-add.php?msg=' . $message);
        exit();
        }
        
        //Insert to Database
        else {
            $registrationQuery = "INSERT INTO tute_issuer (tute_issuer_id, first_name, last_name, email, password) VALUES ('$tute_issuer_id', '$first_name', '$last_name', '$email', '$password')";
            

            
            if (mysqli_query($connection,$registrationQuery) === TRUE) {
                $message = base64_encode(urlencode("tute-issuer Added Successfully"));
				header('Location:../admin-tute-issuer-add.php?msg=' . $message);
				exit();
            } 
            
            else {
                $message = base64_encode(urlencode("SQL Error while Registering"));
				header('Location:../admin-tute-issuer-add.php?msg=' . $message);
				exit();
            }
        }
        



mysqli_close($connection);
   


?>