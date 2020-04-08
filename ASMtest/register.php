<?php session_start(); ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
    </head>
    <body>
        <?php 
       if (isset($_SESSION['username'])){
           echo 'Log in as '.$_SESSION['username']."<br>";
           echo '<a href="logout.php">Logout</a>';
       }
       
       ?>
        <h1 align='center'>Create Account</h1>
        <form action="register.php" method="POST" align='center'>
            <table align='center'>
                
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
                        Fullname :
                    </td>
                    <td>
                        <input type="text" name="txtFullname" size="50" />
                    </td>
                </tr>
                <tr>
                    <td>
                        Role :
                    </td>
                    <td>
                        <select name="formRole">
                            <option value="">Select...</option>
                            <option value="Admin">Admin</option>
                            <option value="Tutor">Trainer</option>
                            <option value="Student">Trainee</option>
                            <option value="Staff">Staff</option>
                        </select>                        
                    </td>
                </tr>
                <td><input type="submit" value="Register" /></td>
                <td><input type="reset" value="Reset" /></td>
            </table>
            
        </form>
    </body>
</html>
<?php
 
    
    if (!isset($_POST['txtUsername'])){
        die('');
    }    
    
    include('connect.php');          
    
    $username   = $_POST['txtUsername'];
    $password   = $_POST['txtPassword'];    
    $fullname   = $_POST['txtFullname'];
    $role       = $_POST['formRole'];
    
    
          
    
    if (!$username || !$password ||  !$fullname)
    {
        echo "Enter the space. <a href='javascript: history.go(-1)'>back</a>";
        exit;
    }          
        
        $password = md5($password);          
    
        $stmt = $conn->prepare("SELECT username FROM account WHERE username='$username'");
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
        echo "Username exist.";
        exit;
        } 
         
       
    
    if(empty($role))
        {
          echo"You forgot to select the role!.";
          exit;
        }    
          
    
    $stmt = $conn->prepare("INSERT INTO account (username,password,role,fullname) VALUE ('{$username}','{$password}','{$role}','{$fullname}')");
    $pdoResult = $stmt->execute();
                          
    
    if ($pdoResult)
        echo "Successfully. <a href='login.php'>Go to LogIn</a>";
    else
        echo "error. <a href='register.php'>Back</a>";
?>