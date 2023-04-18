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
if (isset($_POST['Submit'])) {

    $UserName = $_POST["Name"];
    $UserEmail = $_POST['Email'];
    $UserMessage = $_POST["Message"];



    date_default_timezone_set("Africa/Tunis");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);



    if (empty($UserName) || empty($UserEmail) || empty($UserMessage)) {
        $_SESSION["ErrorMessage"] = 'All field should be filled out!';
        header("location:Contact.php");
        exit();

    } elseif (strlen($UserName) < 3) {
        $_SESSION["ErrorMessage"] = 'Username should be greater than 3 characters!';
        header("location:Contact.php");
        exit();
    } elseif (strlen($UserMessage) > 9999) {
        $_SESSION["ErrorMessage"] = 'Message should be less than 10000 characters!';
        header("location:Contact.php");
        exit();
    } else {
        //insertion query





        $sql = "INSERT INTO message(datetime,name,email,message)";
        $sql .= "VALUES(:dateTime,:userName,:userEmail,:userMessage)";
        $stmt = $ConnectingDB->prepare($sql);

        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':userName', $UserName);
        $stmt->bindValue(':userEmail', $UserEmail);
        $stmt->bindValue(':userMessage', $UserMessage);

        $Execute = $stmt->execute();




        //  $this->log($Execute, 'debug');


        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Message Successfully Sent";
            header("location: Contact.php");
            exit();
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong, try again!";
            header("location: Contact.php");
            exit();
        }

    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/905f0814b0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
    <link rel="stylesheet" href="../Css/Style.css" />


    <title>Contact</title>
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

        label {
            color: #3bb186d7;
            font-weight: bold;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: black;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #FF8000;
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

        .btn-outline_green {
            background-color: transparent;
            color: #3bb186d7;
            border: 2px solid #3bb186d7;
            border-radius: 4px;
            padding: 5px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease-in-out;
        }

        .btn-outline_green:hover {
            background-color: #3bb186d7;
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
                        <a href="UserProfil.php" class="nav-link active text-success"><i class="fas fa-user"></i>
                            Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a href="AboutUs.php" class="nav-link">Apropos de nous</a>
                    </li>

                    <li class="nav-item">
                        <a href="Contact.php" class="nav-link active">Nous Contacter</a>
                    </li>
                </ul>
                <ul class="navbar-nav mt-2">
                    <form class="form-inline d-none d-sm-block" action="Blog.php">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Entrez votre recherche" name="Search"
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
                <div class="col-md-12">
                    <h1>
                        <i class="fas fa-address-book" style="color: #ff8000"></i> Nous Contacter
                    </h1>
                </div>
            </div>
        </div>
    </header>
    <!--Main Area-->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class=" offset-lg-1 col-lg-10" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();

                ?>
                <p class="lead">Avez-vous une question ? Une suggession à propos de notre site ou manuel ?
                    N'hésitez pas à nous Contacter.</p>


                <form action="Contact.php" method="POST" enctype="multipart/form-data">
                    <div class="bg-light text-dark">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" style="color:#FF8000">Nom</label>
                                <input class="form-control" type="text" name="Name" id="name"
                                    placeholder="type your name here" value="" />
                            </div>
                            <div class="form-group">
                                <label for="email" style="color:#FF8000"> Email</label>
                                <input class="form-control" type="email" name="Email" id="email"
                                    placeholder="type your Email here" value="" />
                            </div>

                            <div class="form-group">
                                <label for="message"> <span style="color:#FF8000"> Message:</span></label>
                                <textarea class="form-control" id="message" name="Message" rows="8"
                                    cols="80"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Blog.php?page=1" class="btn btn-outline_orange btn-block"><i
                                            class="fas fa-arrow-left"></i> Accueil</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-outline_green btn-block"><i
                                            class="fas fa-check"></i> Publier</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <!--FOOTER-->
    <footer style="background-color: #dfe0e2">
        <div class="container">
            <div class="row py-5">
                <nav class="nav">
                    <a style="color: #FF8000;" href="AboutUs.php" class="nav-link">Apropos de nous</a>
                    <a style="color: #FF8000;" href="Blog.php?page=1" class="nav-link">Accueil</a>
                    <a style="color: #FF8000;" href="Contact.php" class="nav-link">Nous Contacter</a>
                </nav>
                <div class="col-md-6 text-center">
                    <p class="lead">
                        Conçu avec <i class="fas fa-heart text-danger"></i> par <span
                            style="color: #3bb186d7; font-weight: bold;">
                            JERSOHN_ASSAMOI </span>
                        <a href="https://github.com/Jersohn" style="color: #3bb186d7;"><i
                                class="fab fa-github fa-lg ml-2"></i></a>
                        <a href="https://www.linkedin.com/in/felix-jersohn-assamoi" style="color: #3bb186d7;"><i
                                class="fab fa-linkedin fa-lg ml-2"></i></a>
                    </p>
                    <p class="text-muted">&copy; <span id="year"></span> Tous droits réservés</p>

                </div>
                <div class="col-md-2">
                    <img class="img-fluid" src="../Images/logo.jpg" height="100%" width="100%">
                </div>
            </div>
        </div>
    </footer>
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