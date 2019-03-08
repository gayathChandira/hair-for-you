<?php

include('../../includes/connection.php');


    // Assign input data from form to variables
	$subject_name = $_POST['name'];
	$subject_id = $_POST['id'];
    
   
        //Check if subject already exists
        $selectid= "SELECT * FROM subjects WHERE subject_id ='$subject_id' " ;
        $allidquery = mysqli_query($connection, $selectid) ;  
        $num = mysqli_num_rows($allidquery);
    
        if($num > 0){
        $message = base64_encode(urlencode("Subject ID already exists"));
        header('Location:../admin-subject-add.php?msg=' . $message);
        exit();
        }
        
        //Insert to Database
        else {
            $subjectQuery = "INSERT INTO subjects (subject_id, subject_name) VALUES ('$subject_id', '$subject_name')";            

            
            if (mysqli_query($connection,$subjectQuery) === TRUE) {
                $message = base64_encode(urlencode("Subject Added Successfully"));
				header('Location:../admin-subject-add.php?msg=' . $message);
				exit();
            } 
            
            else {
                $message = base64_encode(urlencode("SQL Error while Adding subject"));
				header('Location:../admin-subject-add.php?msg=' . $message);
				exit();
            }
        }
        



mysqli_close($connection);
   


?>