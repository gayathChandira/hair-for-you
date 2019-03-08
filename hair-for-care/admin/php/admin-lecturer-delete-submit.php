<?php

include('../../includes/connection.php');

    $id=$_POST['lecturer_id'];

    $delQuery= "DELETE FROM lecturers WHERE lecturer_id = '$id' ";

    $delResult = mysqli_query ($connection, $delQuery);
    $message = base64_encode(urlencode("Lecturer Removed Successfully"));
    header('Location:../admin-lecturer-delete.php?msg=' . $message);
    exit();


mysqli_close($connection);
    
    
?>