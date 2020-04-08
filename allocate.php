<?php
session_start();
include('connect.php');
include('checkLogin.php');
?>
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
            <div class="table-responsive">
                <h4 align="center">Allocate</h4>
                <p align="right">Hi - <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></p>
                <div id="user_details"></div>
                <div id="user_model_details"></div>
            </div>
            <br />
            <div class="panel panel-default">
                <div class="panel-heading">Selecting</div>
                <div class="panel-body">
                    <form method="post">
                        <div class="form-group" id ="mainselection">
                            <label>Select Tutor</label>
                            <select name="Tutor">
                                <option value="">Select...</option>
                                <?php
                                $query = "SELECT * FROM account WHERE role = 'tutor'";

                                $statement = $conn->prepare($query);

                                $statement->execute();

                                $result = $statement->fetchAll();
                                foreach ($result as $row) {
                                    $Tutorid = $row['id'];
                                    $Tutorname = $row['username'];
                                    echo "<option value='$Tutorid'>$Tutorname</option>";
                                }
                                ?>
                            </select>    
                        </div>
                        <div class="form-group">
                            <label>Select Student</label>
                            <select name="Student">
                                <option value="">Select...</option>
                                <?php
                                $query = "SELECT * FROM account WHERE role = 'student'";

                                $statement = $conn->prepare($query);

                                $statement->execute();

                                $result = $statement->fetchAll();
                                foreach ($result as $row) {
                                    $Studentid = $row['id'];
                                    $Studentname = $row['username'];
                                    echo "<option value='$Studentid'>$Studentname</option>";
                                }
                                ?>
                            </select>    
                        </div>


                        <div class="form-group">
                            <input type="submit" name="add" class="btn btn-info" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>  
</html>
<?php
if (isset($_POST['Tutor']) && isset($_POST['Student'])) {
    include('connect.php');
    $Studentid = $_POST['Student'];
    $Tutorid = $_POST['Tutor'];


    $statement1 = $conn->prepare("SELECT * FROM allocate WHERE studentid = '$Studentid' and tutorid = '$Tutorid' ");

    $statement1->execute();
    $check = 'yes';
    if ($statement1->rowCount() > 0) {
        $check = 'no';
    }


    if ($check == 'yes') {
        $stmt = $conn->prepare("INSERT INTO allocate (studentid, tutorid) VALUE ('{$Studentid}', '{$Tutorid}')");
        $pdoResult = $stmt->execute();
        if ($pdoResult)
            echo "Adding success";
        else
            echo "error";
    }
    else {
        echo"Already have this allocate";
    }
}

$query1 = "SELECT * FROM allocate";

$statement = $conn->prepare($query1);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
 <tr>
  <th width="30%">Allocate Id</td>
  <th width="30%">Tutor</td>
  <th width="30%">student</td>
  <th width="10%">Option</td>
 </tr>
';

foreach ($result as $row) {
// get student name
    $stmt = $conn->prepare("SELECT * FROM account where id = '" . $row['studentid'] . "'");
    $stmt->execute();
    $row1 = $stmt->fetch(PDO::FETCH_ASSOC);

/// get tutor name

    $stmt1 = $conn->prepare("SELECT * FROM account where id = '" . $row['tutorid'] . "'");
    $stmt1->execute();
    $row2 = $stmt1->fetch(PDO::FETCH_ASSOC);

    $output .= '
 <tr>
  <td>' . $row['acid'] . ' </td>
  <td>' . $row2['username'] . ' </td>
  <td>' . $row1['username'] . ' </td>
  <td>
            <form action="DeleteAllocate.php" method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="acid" value= ' . $row['acid'] . '/>
                <input type="submit" value="Delete" />
            </form>
        </td>
</tr>
 ';
}

$output .= '</table>';

echo $output;
?>

