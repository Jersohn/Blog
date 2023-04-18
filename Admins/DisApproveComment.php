
<?php
require_once("../Includes/Session.php");
?>

<?php
require_once("../Includes/DB.php");
?>

<?php
require_once("../Includes/Functions.php");
?>
<?php

$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
ConfirmLogin();
?>

<?php
if (isset($_GET['id'])) {
    $ParamId = $_GET['id'];
    global $ConnectingDB;
    $Admin = $_SESSION['UserName'];
    $sql = "UPDATE comments SET status = 'OFF',approvedby ='Pending' WHERE id='$ParamId'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = 'Comment successfully disapproved !';
        header("location: Comments.php?page=1");
        exit();


    } else {
        $_SESSION["ErrorMessage"] = 'Something went wrong , try again !';
        header("location: Comments.php?page=1");
        exit();

    }
}

?>