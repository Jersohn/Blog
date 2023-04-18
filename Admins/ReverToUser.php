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
    $sql = "UPDATE users SET isadmin = 'false',addedby ='Pending' WHERE id='$ParamId'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = 'user successfully disapproved !';
        header("location: Admins.php");
        exit();


    } else {
        $_SESSION["ErrorMessage"] = 'Something went wrong , try again !';
        header("location: Admins.php");
        exit();

    }
}

?>