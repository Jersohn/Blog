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
$AdminId = $_SESSION["UserId"];


if (isset($_POST['Submit'])) {

    $AdminName = $_POST["Name"];
    $AdminHeadline = $_POST['Headline'];
    $AdminBio = $_POST['Bio'];
    $Image = $_FILES['Image']['name'];
    $Target = "Images/" . basename($_FILES['Image']['name']);

    if (strlen($AdminHeadline) > 30) {
        $_SESSION["ErrorMessage"] = 'Headline should be less than 30 characters!';
        header("location: MyProfile.php");
        exit();

    } elseif (strlen($AdminBio) > 9999) {
        $_SESSION["ErrorMessage"] = 'Bio should be less than 10000 characters!';
        header("location: MyProfile.php");
        exit();
    } elseif (strlen($AdminName) > 30) {
        $_SESSION["ErrorMessage"] = 'Name description should be less than 30 characters!';
        header("location: MyProfile.php");
        exit();
    } else {
        //insertion query

        global $ConnectingDB;

        if (!empty($Image)) {

            $sql = "UPDATE users SET name='$AdminName', headline='$AdminHeadline', bio ='$AdminBio', image= '$Image'
    WHERE id='$AdminId'";
        } else {

            $sql = "UPDATE users SET name='$AdminName', headline='$AdminHeadline', bio ='$AdminBio'
    WHERE id='$AdminId'";
        }
        $Execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

        //  $this->log($Execute, 'debug'


        if ($Execute) {
            $_SESSION["SuccessMessage"] = "User with id : " . $AdminId . " Successfully Updated";
            header("location: MyProfile.php");
            exit();
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong, try again!";
            header("location: MyProfile.php");
            exit();
        }
    }



}
global $ConnectingDB;
$sql = "SELECT * FROM users WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
    $ExistingName = $DataRows['name'];
    $ExistingUserName = $DataRows['username'];
    $ExistingHeadline = $DataRows['headline'];
    $ExistingBio = $DataRows['bio'];
    $ExistingImage = $DataRows['image'];
}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/905f0814b0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
    <link rel="stylesheet" href="../Css/Style.css" />

    <title>My Profile</title>
    <style>
        .navbar {
            background-color: #dfe0e2;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
            position: fixed;
            z-index: 5;

            top: 0;
            left: 0;
            right: 0;
            margin-bottom: 10px;
        }

        .btn-outline_orange {
            background-color: transparent;
            color: #ff8000;
            border: 2px solid #ff8000;
            border-radius: 4px;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease-in-out;
        }

        .btn-outline_orange:hover {
            background-color: #ff8000;
            color: #fff;
            border-color: #ff8000;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <!--NAVBAR-->
    <?php require_once("Navigation.php") ?>



    <!--HEADER-->

    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3>
                        <i class="fas fa-user mr-2" style="color: #ff8000"></i>
                        @
                        <?php echo $ExistingUserName ?>
                    </h3>
                    <span style="color: #3bb186d7; font-style:italic">
                        <?php echo $ExistingHeadline ?>
                    </span>
                </div>
            </div>
        </div>
    </header>
    <!--Main Area start-->

    <section class="container py-2 mb-4">
        <div class="row">
            <!-- left Area start -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-light text-dark">
                        <h5>
                            <?php echo $ExistingName ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <img src="../Images/<?php echo $ExistingImage ?>" class="block img-fluid mb-3 " alt="image" />
                    </div>
                    <div class="card-footer">
                        <small class="text-start">
                            <?php echo nl2br($ExistingBio) ?>
                        </small>

                    </div>

                </div>

            </div>
            <!-- left Area end -->

            <!-- Right area start -->

            <div class="col-md-9" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();

                ?>


                <form action="MyProfile.php" method="post" enctype="multipart/form-data">
                    <div class=" text-light ">
                        <div class="card-header ">
                            <h4 style="color:#ff8000"> <i class="fas fa-edit"></i> Edit Profile</h4>

                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" type="text" name="Name" id="name" placeholder="your name"
                                    value=<?php echo $ExistingName ?> />

                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="Headline" id="headline"
                                    placeholder="headline" value=<?php echo $ExistingHeadline ?> />
                                <small class="text-muted">Junior Web Developper</small>
                                <span style=" color:#ff8000">Not more than 30 characters</span>
                            </div>
                            <div class="form-group">

                                <textarea class="form-control" id="bio" name="Bio" rows="8" placeholder="Bio" cols="80"> <?php echo $ExistingBio ?>
                                </textarea>
                            </div>

                            <div class="form-group">
                                <div class="custom-file">

                                    <input class="custom-file-input" type="file" name="Image" id="image" value="" />
                                    <label for="image" class="custom-file-label">Select Image</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php?page=1" class="btn btn-outline_orange btn-block"><i
                                            class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-outline-success btn-block"><i
                                            class="fas fa-check"></i> Publish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Right area end -->

        </div>
    </section>

    <!--FOOTER-->
    <?php require_once("Footer.php"); ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>

    <script>
        $("#year").text(new Date().getFullYear())   </script>
</body>

</html>