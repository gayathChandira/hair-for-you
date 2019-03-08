<?php

include('includes/connection.php');
include('includes/session.php');

//Assign data from login form to variables
	$id = $_POST['id'];
	$password = sha1($_POST['password']);
    
    
         //Lecturer Login
         $result = substr($id, 0, 1);

         if ($result == "L" or $result == "l"){
            $userQuery = "SELECT * FROM lecturers WHERE lecturer_id ='$id' and password='$password'";
            $userResult= mysqli_query($connection, $userQuery);
        
             if (mysqli_num_rows($userResult) == 1) {
                $userRow = mysqli_fetch_array($userResult);

                //Creating Session
                checkSession();  
                $_SESSION["name"] = $userRow['first_name'];
                $_SESSION["userID"] = $userRow['lecturer_id'];
                $_SESSION["usertype"] = "lecturer";

                header("Location:lecturer/lecturer-dashboard.php");
             }
              else{
                $message = base64_encode(urlencode("Invalid ID or Password"));
                header('Location:index.php?msg=' . $message);
                exit();
            }
         }



        //Cashier Login
        elseif ($result == "C" or $result == "c"){
        $userQuery = "SELECT * FROM cashier WHERE cashier_id ='$id' and password='$password'";
        $userResult= mysqli_query($connection, $userQuery);
        //print_r($userResult);

        //User Exists
        if (mysqli_num_rows($userResult) == 1) {
                $userRow = mysqli_fetch_array($userResult);

                //Creating Session
                checkSession();  
                $_SESSION["name"] = $userRow['first_name'];
                $_SESSION["userID"] = $userRow['cashier_id'];
                $_SESSION["usertype"] = "cashier";

                header("Location:cashier/cashier-dashboard.php");
            }
            else{
                $message = base64_encode(urlencode("Invalid ID or Password"));
                header('Location:index.php?msg=' . $message);
                exit();
            }
        }



        //Tute Issuer Login
        elseif ($result == "T" or $result == "t"){
        $userQuery = "SELECT * FROM tute_issuer WHERE tute_issuer_id ='$id' and password='$password'";
        $userResult= mysqli_query($connection, $userQuery);
    
        //User Exists
            if (mysqli_num_rows($userResult) == 1) {
                    $userRow = mysqli_fetch_array($userResult);

                    //Creating Session
                    checkSession();  
                    $_SESSION["name"] = $userRow['first_name'];
                    $_SESSION["userID"] = $userRow['tute_issuer_id'];
                    $_SESSION["usertype"] = "tuter";  

                    header("Location:tute-issuer/tute-issuer-dashboard.php");    
                }
                else{
                    $message = base64_encode(urlencode("Invalid ID or Password"));
                    header('Location:index.php?msg=' . $message);
                    exit();
                }
        }
          


        //Admin Login
        elseif ($result == "A" or $result == "a"){
        $userQuery = "SELECT * FROM admin WHERE admin_id ='$id' and password='$password'";
        $userResult= mysqli_query($connection, $userQuery);
              
            //User Exists
            if (mysqli_num_rows($userResult) == 1) {
                $userRow = mysqli_fetch_array($userResult);

                //Creating Session
                checkSession();  
                $_SESSION["name"] = $userRow['first_name'];
                $_SESSION["userID"] = $userRow['admin_id'];
                $_SESSION["usertype"] = "admin";

                header("Location:admin/admin-dashboard.php");
            }
            else{
                $message = base64_encode(urlencode("Invalid ID or Password"));
                header('Location:index.php?msg=' . $message);
                exit();
            }
        }
         


        //Student Login
        $result = substr($id, 2, 1);
  
        
        if ($result == "E" or $result == "e"){       
            //Select User from database
            $userQuery = "SELECT * FROM students WHERE student_id ='$id' and password='$password'";
            $userResult= mysqli_query($connection, $userQuery);
            
            if(mysqli_num_rows($userResult) == 1){
                $userRow = mysqli_fetch_array($userResult);
            
                //Creating Session
                checkSession();  
                $_SESSION["name"] = $userRow['first_name'];
                $_SESSION["userID"] = $userRow['student_id'];
                $_SESSION["usertype"] = "student";

                header("Location:student/student-dashboard.php");
            }
            else{
                $message = base64_encode(urlencode("Invalid ID or Password"));
                header('Location:index.php?msg=' . $message);
                exit();
            }
           
        }
    
mysqli_close($connection);
   
    
?>