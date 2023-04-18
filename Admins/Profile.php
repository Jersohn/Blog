<?php
require_once("../Includes/Session.php");
?>

<?php
require_once("../Includes/DB.php");
?>

<?php
require_once("../Includes/Functions.php");
?>
<!-- Fetch existing data -->
<?php
$SearchQueryParam = $_GET["username"];
global $ConnectingDB;
$sql = "SELECT datetime,name,email, headline,bio, image FROM users WHERE username=:userName ";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':userName', $SearchQueryParam);
$stmt->execute();
$Result = $stmt->rowCount();
if ($Result == 1) {
    while ($DataRows = $stmt->fetch()) {
        $ExistingDate = $DataRows["datetime"];
        $ExistingName = $DataRows["name"];
        $ExistingEmail = $DataRows["email"];
        $ExistingHeadline = $DataRows["headline"];
        $ExistingBio = $DataRows["bio"];
        $ExistingImage = $DataRows["image"];

    }
} else {
    $_SESSION["ErrorMessage"] = 'Bad Request!';
    header("location: Blog.php?page=1");
    exit();
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

    <title>Profile</title>
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

        .btn-outline_search {
            background-color: #3bb186d7;
            color: #fff;
            border: 2px solid #3bb186d7;
            border-radius: 4px;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease-in-out;
        }

        .btn-outline_search:hover {
            background-color: #079360;
            color: #fff;
            border-color: #3bb186d7;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <!--NAVBAR-->
    <nav style="background-color:#dfe0e2;" class="navbar navbar-expand-lg navbar-dark">
        <div class="container">

            <a href="Blog.php?page=1"><img src="../Images/logo.jpg" alt=""></a>
            <button style="background-color:#FF8000;" class="navbar-toggler" data-toggle="collapse"
                data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a href="AboutUs.php" class="nav-link">Apropos de nous</a>
                    </li>

                    <li class="nav-item">
                        <a href="Contact.php" class="nav-link">Nous Contacter</a>
                    </li>
                </ul>
                <ul class="navbar-nav mt-2">
                    <form class="form-inline d-none d-sm-block" action="Blog.php">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Entrer votre recherche" name="Search"
                                style="border-color:#3bb186d7">
                            <div class="input-group-append">
                                <button class="btn btn-outline_search btn-sm text-center" name="SearchButton">Chercher
                                </button>
                            </div>

                        </div>
                    </form>
                </ul>
                <?php if (isset($_SESSION['UserId'])) {
                    ?>
                    <ul class="navbar-nav ml-auto">
                        <il class="nav-item">
                            <a style="text-decoration: none;" href="../Logout.php" class=" btn-outline_orange "><i
                                    class="fas fa-user-times"></i>
                                Déconnexion</a>
                        </il>
                    </ul>


                <?php } else {
                    ?>
                    <ul class="navbar-nav ml-auto">
                        <il class="nav-item">
                            <a style="text-decoration: none;" href="../Login.php" class="btn-outline_orange"><i
                                    class="fas fa-user"></i>
                                Connexion</a>
                        </il>
                    </ul>

                <?php } ?>

            </div>
        </div>
    </nav>
    <div style="height:100px;"></div>

    <!--HEADER-->

    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>
                        <i class="fas fa-user mr-2" style='color:#FF8000'></i>
                        <?php echo $ExistingName; ?>
                    </h1>
                    <small style="font-style: italic; color: #3bb186d7; ">
                        <?php echo $ExistingHeadline; ?>
                    </small>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3">
                <img src="../Images/<?php echo $ExistingImage ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
            </div>
            <div class="col-md-9" style="min-height:400px;">
                <div class="card">
                    <div class="card-body">
                        <p class="lead">
                            <?php echo $ExistingBio ?>
                        </p>
                        <p>Email :<a href="mailto:<?php echo $ExistingEmail ?>"><?php echo $ExistingEmail ?></a></p>
                        <p>Joined date :
                            <?php echo $ExistingDate ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--FOOTER-->
    <?php require_once("Footer.php") ?>

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
        $("#year").text(new Date().getFullYear());
    </script>
</body>

</html>