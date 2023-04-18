<?php
require_once("DB.php");
?>

<?php
function CheckUserExist($UserName)
{
    global $ConnectingDB;

    $sql = "SELECT username FROM admins WHERE username =:userName";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName', $UserName);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ($Result > 0) {
        return true;
    } else {
        return false;
    }

}

function LoginAttempt($UserName, $Password)
{
    global $ConnectingDB;
    $sql = "SELECT* FROM users WHERE username =:userName AND password=:passWord LIMIT 1";

    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName', $UserName);
    $stmt->bindValue(':passWord', $Password);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ($Result > 0) {
        return $FoundAccount = $stmt->fetch();
    } else {
        return null;
    }
}


function ConfirmLogin()
{
    if (isset($_SESSION["UserId"])) {
        return true;
    } else {
        $_SESSION["ErrorMessage"] = "Login Required !";
        header("location:./Login.php");
        exit();
    }
}
// function ConfirmAdminLogin()
// {
//     if (isset($_SESSION["Isadmin"]) && ($_SESSION["Isadmin"]) == true) {
//         return true;
//     } else {
//         $_SESSION["ErrorMessage"] = "Admin Login Required !";
//         header("location:./Login.php");
//         exit();
//     }
// }
function ErrorMessage()
{
    if (isset($_SESSION["ErrorMessage"])) {
        $Output = "<div class=\"alert alert-danger\">";
        $Output .= htmlentities($_SESSION["ErrorMessage"]);
        $Output .= "</div>";
        $_SESSION["ErrorMessage"] = null;
        return $Output;
    }
}

function SuccessMessage()
{
    if (isset($_SESSION["SuccessMessage"])) {
        $Output = " <div class=\"alert alert-success\">";
        $Output .= htmlentities($_SESSION["SuccessMessage"]);
        $Output .= "</div>";
        $_SESSION["SuccessMessage"] = null;
        return $Output;
    }
}


function TotalUsers()
{
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM users';
    $stmt = $ConnectingDB->query($sql);
    $Total = $stmt->fetch();
    $TotalUsers = array_shift($Total);
    echo $TotalUsers;
}
function TotalPosts()
{
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM posts';
    $stmt = $ConnectingDB->query($sql);
    $Total = $stmt->fetch();
    $TotalPosts = array_shift($Total);
    echo $TotalPosts;
}
function TotalCategories()
{
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM categories';
    $stmt = $ConnectingDB->query($sql);
    $Total = $stmt->fetch();
    $TotalCategories = array_shift($Total);
    echo $TotalCategories;
}
function TotalComments()
{
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM comments';
    $stmt = $ConnectingDB->query($sql);
    $Total = $stmt->fetch();
    $TotalComments = array_shift($Total);
    echo $TotalComments;
}
function TotalMessage()
{
    global $ConnectingDB;
    $sql = 'SELECT COUNT(*) FROM message';
    $stmt = $ConnectingDB->query($sql);
    $Total = $stmt->fetch();
    $TotalMessage = array_shift($Total);
    echo $TotalMessage;
}

function ApprovedPostComment($PostId)
{
    global $ConnectingDB;
    $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id ='$PostId' AND status='ON'";
    $stmtApprove = $ConnectingDB->query($sqlApprove);
    $TotalRow = $stmtApprove->fetch();
    $ApprovedComments = array_shift($TotalRow);
    return $ApprovedComments;
}
function DisApprovedPostComment($PostId)
{
    global $ConnectingDB;
    $sqlDisapprove = "SELECT COUNT(*) FROM comments WHERE post_id ='$PostId' AND status='OFF'";
    $stmtDisapprove = $ConnectingDB->query($sqlDisapprove);
    $TotalRow = $stmtDisapprove->fetch();
    $DisapprovedComments = array_shift($TotalRow);
    return $DisapprovedComments;
}
function PostNumber($CategoryName)
{
    global $ConnectingDB;
    $sqlFindPost = "SELECT COUNT(*) FROM posts WHERE category ='$CategoryName'";
    $stmtFindPost = $ConnectingDB->query($sqlFindPost);
    $TotalRow = $stmtFindPost->fetch();
    $PostFound = array_shift($TotalRow);
    return $PostFound;
}

?>