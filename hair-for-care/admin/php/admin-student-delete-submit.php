<?php

include('../../includes/connection.php');

    $id=$_POST['student_id'];

    $delQuery= "DELETE FROM students WHERE student_id = '$id' ";

    $delResult = mysqli_query ($connection, $delQuery);
    $message = base64_encode(urlencode("Student Removed Successfully"));
    header('Location:../admin-student-delete.php?msg=' . $message);
    exit();


mysqli_close($connection);
    
    
?>