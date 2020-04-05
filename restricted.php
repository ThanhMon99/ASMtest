<?php
session_start();
$role = $_SESSION['role'];

switch ($role) {
     case 'Admin':
         $_SESSION['role'] = 'Admin';

         header( 'Location: Register.php');
         break;
     case 'Staff':
         $_SESSION['role'] = 'Staff';

         header( 'Location: managecourse.php');
         break;
      
        }
            
       

?>