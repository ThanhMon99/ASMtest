<?php session_start(); ?>
<html>  
    <head> 
        <style>
            select {
                border: 1px solid;
                overflow: hidden; 
                width: 135px; 
                border-radius: 5px;
            }
        </style>
        <title>Application</title>  
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <?php
        if (isset($_SESSION['username'])) {
            echo 'Log in as ' . $_SESSION['username'] . "<br>";
            echo '<a href="logout.php">Logout</a>';
        }
        ?>
        <div class="container">
            <br />

            <h3 align="center">Register</a></h3><br />
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">Create Account</div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Enter Username</label>
                            <input type="text" name="txtUsername" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Enter Password</label>
                            <input type="password" name="txtPassword" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="txtFullname" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="txtAddress" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="txtEmail" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            </br>
                            <div class="select">
                                <select name="formRole">
                                    <option value="">Select...</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Tutor">Tutor</option>
                                    <option value="Student">Student</option>
                                    <option value="Staff">Staff</option>
                                </select>                        
                            </div>
                        </div>

                        <div class="form-group" align="center">
                            <input type="submit" name="register" class="btn btn-info" value="Register" />
                        </div>
                        <div align="center" >
                            <a href="login.php" class="btn btn-info">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>  
</html>



<?php
if (!isset($_POST['txtUsername'])) {
    die('');
}

include('connect.php');

$username = $_POST['txtUsername'];
$password = $_POST['txtPassword'];
$fullname = $_POST['txtFullname'];
$role = $_POST['formRole'];
$Address = $_POST['txtAddress'];
$Email = $_POST['txtEmail'];



if (!$username || !$password || !$fullname) {
    echo "Enter the space. <a href='javascript: history.go(-1)'>back</a>";
    exit;
}

$password = md5($password);

$stmt = $conn->prepare("SELECT username FROM account WHERE username='$username'");
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "Username exist.";
    exit;
}



if (empty($role)) {
    echo"You forgot to select the role!.";
    exit;
}


$stmt = $conn->prepare("INSERT INTO account (username,password,role,fullname,address,email) VALUE ('{$username}','{$password}','{$role}','{$fullname}','{$Address}','{$Email}')");
$pdoResult = $stmt->execute();


if ($pdoResult) {
    echo "Successfully";
} else
    echo "error. <a href='register.php'>Back</a>";
?>