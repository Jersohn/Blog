<?php
require_once("Includes/Session.php");
?>
<?php
require_once("Includes/Functions.php");
?>


<?php
$_SESSION["UserId"] = null;
$_SESSION["UserName"] = null;
$_SESSION["AdminName"] = null;

session_destroy();
header("location: Login.php");
exit();
?>