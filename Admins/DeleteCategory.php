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

    $sql = "DELETE FROM categories WHERE id='$ParamId'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = 'Category Successfully Deleted !';
        header("location: Categories.php");
        exit();


    } else {
        $_SESSION["ErrorMessage"] = 'Something went wrong , try again !';
        header("location: Categories.php");
        exit();

    }
}

?>