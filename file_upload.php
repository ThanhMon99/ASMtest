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
                <h4 align="center">Upload</h4>
                <p align="right">Hi - <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></p>
                <div id="user_details"></div>
                <div id="user_model_details"></div>

            </div>
            <br />
            <form method="post" action="file_upload.php" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <div class="panel-heading">Selecting</div>
                    <div class="panel-body">

                        <div class="form-group" id ="mainselection">

                            <input type="file"  size="60" style="width:300px" class="btn btn-info" name="file" ">                

                        </div>


                        <div class="form-group">
                            <input type="submit" class="btn btn-info" value="Upload" name="submit">

                        </div>

                    </div>
                </div>
            </form>
        </div>

    </body>  
</html>

<?php
$statusMsg = '';

if ((isset($_POST["submit"]) && !empty($_FILES["file"]["name"]))) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    

            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
                $url = $targetFilePath;
                $stmt = $conn->prepare("INSERT INTO upload (fileName, fileUrl) VALUE ('{$fileName}','{$url}')");
                $pdoResult = $stmt->execute();
            if($pdoResult){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
   

    echo $statusMsg;
}
?>

<?php
include('connect.php');

$stmt = $conn->prepare("SELECT fileUrl FROM upload");               
    $stmt->execute(); 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $imageURL = $row['fileUrl'];
?>
    <img src="<?php echo $imageURL; ?>" alt="" width="300" height="300"/>
<?php }?>
