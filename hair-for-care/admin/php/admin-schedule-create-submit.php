<?php

include('../../includes/connection.php');


    // Assign input data from form to variables
	$lecturer_id = $_POST['lecturer_id'];
	$hall_no = $_POST['hall_no'];
    $subject_id = $_POST['subject_id'];
    $time = $_POST['time'];
    $day = $_POST['day'];

        
        //Insert to Database
        $scheduleQuery = "INSERT INTO lecture_schedule (lecturer_id, hall_no, subject_id, time, day) VALUES ('$lecturer_id', '$hall_no', '$subject_id', '$time', '$day')";            

            
            if (mysqli_query($connection,$scheduleQuery) === TRUE) {
                $message = base64_encode(urlencode("Lecture Schedule Added Successfully"));
				header('Location:../admin-schedule-create.php?msg=' . $message);
				exit();
            } 
            
            else {
                $message = base64_encode(urlencode("SQL Error while Adding Lecture Schedule"));
				header('Location:../admin-schedule-create.php?msg=' . $message);
				exit();
            }
        
        



mysqli_close($connection);
   


?>