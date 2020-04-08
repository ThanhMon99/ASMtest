<html>  
    <head>  
        <title>Application</title>  
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container">
            <br />

            <h3 align="center"> Application </a></h3><br />
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group">
                            <label>Enter Username</label>
                            <input type="text" name="txtUsername" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Enter Password</label>
                            <input type="password" name="txtPassword" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" class="btn btn-info" value="Login" />
                            <button class="btn btn-info"><a href='register.php'>Register</a></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>  
</html>


<?php
session_start();
if (isset($_POST['txtUsername'])) {

    $username = $_POST['txtUsername'];
    $password = $_POST['txtPassword'];

    include('connect.php');

    $stmt = $conn->prepare("SELECT id, username, password, role FROM account WHERE username='$username'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
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
    $id = $row['id'];
    $_SESSION['role'] = $role;
    $_SESSION['username'] = $username;
    $_SESSION['id'] = $id;
    $statement = $conn->prepare("INSERT INTO login_details (user_id) VALUES ('{$id}')");
    $statement->execute();
    $_SESSION['login_details_id'] = $conn->lastInsertId();

    echo "Hello " . $username . ". You login successfully. <a href='restricted.php'>Continue</a>";
    //echo "</br><a href='chatIndex.php'>chat</a>";
    echo "</br><a href='chat.php'>Chat</a>";
    die();
}
?>

