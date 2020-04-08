<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
    </head>
    <body>
        <h1 align='center'>Log In</h1>
        <form  action="login.php" method="POST">
            <table align='center' >
                <tr>
                    <td>
                        Username : 
                    </td>
                    <td>
                        <input type="text" name="txtUsername" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Password :
                    </td>
                    <td>
                        <input type="password" name="txtPassword" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Log In" />
                        <input type="reset" value="Reset" />
                        <button><a href='register.php'>Register</a></button>
                    </td>
                    
                </tr>
                
            </table>
            
        </form>
    </body>
</html>
<?php
session_start();
if (isset($_POST['txtUsername'])){
    
        $username   = $_POST['txtUsername'];
        $password   = $_POST['txtPassword'];
    
        include('connect.php'); 
        
        $stmt = $conn->prepare("SELECT username, password, role FROM account WHERE username='$username'");
        $stmt->execute();
        if($stmt->rowCount() == 0){
        echo "Username not exist. ";
        exit;
        }
        
        $password = md5($password);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($password != $row['password']) {
        echo "Wrong password. ";
        exit;     
        }
        $role = $row['role'];
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $username;
        echo "Hello " . $username . ". You login successfully. <a href='restricted.php'>Continue</a>";
        die();
        
    
    }
?>

