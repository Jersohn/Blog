<?php
require_once("Includes/Session.php");
?>

<?php
require_once("Includes/DB.php");
?>

<?php
require_once("Includes/Functions.php");
?>






<?php


if (isset($_SESSION["UserId"])) {
    header("location: Blog.php?page=1");
    exit();
}

if (isset($_POST['Submit'])) {
    $UserName = $_POST['Username'];
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    $Password_hash = password_hash($Password, PASSWORD_DEFAULT);
    $ConfirmedPassword = $_POST['ConfirmedPassword'];



    date_default_timezone_set("Africa/Tunis");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);





    if (empty($UserName) || empty($Email) || empty($Password) || empty($ConfirmedPassword)) {
        $_SESSION["ErrorMessage"] = 'All fields must be filled out!';
        header("location: SignIn.php");
        exit();

    } elseif (strlen($Password) < 5) {
        $_SESSION["ErrorMessage"] = 'Password should be greater than 4 characters!';
        header("location: SignIn.php");
        exit();
    } elseif (strlen($UserName) < 3) {
        $_SESSION["ErrorMessage"] = 'Username should be greater than 2 characters!';
        header("location: SignIn.php");
        exit();
    } elseif ($Password !== $ConfirmedPassword) {
        $_SESSION["ErrorMessage"] = 'Both Password should match!';
        header("location: SignIn.php");
        exit();

    } elseif (CheckUserExist($UserName)) {
        $_SESSION["ErrorMessage"] = 'Username already exits, try another one!';
        header("location: SignIn.php");
        exit();

    } else {
        //insertion query



        global $ConnectingDB;

        $sql = "INSERT INTO users(datetime,username,name,email,password,isadmin,addedby,headline,bio,image)";
        $sql .= "VALUES(:dateTime,:userName,:name,:email,:passWord,'false','pending','','',DEFAULT)";
        $stmt = $ConnectingDB->prepare($sql);

        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':userName', $UserName);
        $stmt->bindValue(':name', $Name);
        $stmt->bindValue(':email', $Email);
        $stmt->bindValue(':passWord', $Password_hash);



        $Execute = $stmt->execute();


        if ($Execute) {
            $_SESSION["SuccessMessage"] = "Salut " . $UserName . " veillez-vous connecter";
            header("location: Login.php");
            exit();
        } else {
            $_SESSION["ErrorMessage"] = "Something went wrong, try again!";
            header("location: SignIn.php");
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
    <link rel="stylesheet" href="Css/Style.css" />

    <title>Sign in Page</title>
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
            color: #FF8000
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
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a href="Blog.php?page=1"><img src="Images/logo.jpg" alt=""></a>
            <button style="background-color: #3bb186d7;" class="navbar-toggler" data-toggle="collapse"
                data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link"> Accueil</a>
                    </li>

                </ul>

                <ul class="navbar-nav ml-auto">
                    <il class="nav-item">
                        <a href="Login.php" class="btn-outline_search nav-link text-light"><i class="fas fa-user"></i>
                            Connexion</a>
                    </il>
                </ul>

            </div>
        </div>
    </nav>
    <div style="height: 100px;"></div>

    <!--HEADER-->

    <header>
        <div class="container">
            <div class="row">

                <div style="color: #FF8000; font-weight: bold;" class="col text-center my-5">
                    <marquee behavior="" direction="">
                        <p>
                            <i class="fas fa-user" style="color: #3bb186d7"></i><i style="color: #3bb186d7"
                                class="fas fa-arrow-right"></i> Rejoignez-nous et Apprenez plus sur les sujets
                            d'actualité!.
                        </p>
                    </marquee>
                </div>
            </div>
        </div>
    </header>
    <!--Main Area-->

    <section class="container py-2 my-4">
        <div class="row">
            <div class="offset-lg-3 col-lg-6" style="min-height:400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();

                ?>


                <form action="SignIn.php" method="post">
                    <div class=" bg-light">
                        <div class="card text-center bg-light">
                            <h3 style="color: #3bb186d7;"> Inscription</h3>
                        </div>
                        <div class="card-body ">
                            <div class="form-group">
                                <label for="username"> Pseudo</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="background-color:#3bb186d7;" class="input-group-text text-white"><i
                                                class="fas fa-user"></i>

                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="Username" id="username" value="">

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Nom</label><small class="text-muted"> * Facultatif</small>
                                <input class="form-control" type="text" name="Name" id="name" value="" />

                            </div>
                            <div class="form-group">
                                <label for="email"> Email</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="background-color:#3bb186d7;" class="input-group-text text-white"><i
                                                class="fas fa-envelope"></i>

                                        </span>
                                    </div>
                                    <input type="email" class="form-control" name="Email" id="email" value="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password"> Mot de Passe</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="background-color:#3bb186d7;" class="input-group-text text-white"><i
                                                class="fas fa-lock"></i>

                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="Password" id="password" value="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirmedPassword"> Confirmer le mot de Passe</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="background-color:#3bb186d7;" class="input-group-text text-white"><i
                                                class="fas fa-lock"></i>

                                        </span>
                                    </div>
                                    <input type="password" class="form-control" name="ConfirmedPassword"
                                        id="confirmedPassword" value="">

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Logout.php" class="btn btn-outline_orange btn-block"> <i
                                            class="fas fa-arrow-left"></i>Switch To
                                        Login Page</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type=" submit" name="Submit" class="btn btn-outline_search btn-block"><i
                                            class="fas fa-check"></i>Submit</button>
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

                    <a style="color:#3bb186d7;" href="Blog.php?page=1" class="nav-link">Accueil</a>

                </nav>
                <div class=" offset-md-2 col-md-6 text-center">
                    <p class="lead">
                        Conçu avec <i class="fas fa-heart text-danger"></i> par <span style="color: #3bb186d7;">
                            JERSOHN_ASSAMOI </span>
                        <a href="https://github.com/Jersohn" style="color: #3bb186d7;"><i
                                class="fab fa-github fa-lg ml-2"></i></a>
                        <a href="https://www.linkedin.com/in/felix-jersohn-assamoi" style="color: #3bb186d7;"><i
                                class="fab fa-linkedin fa-lg ml-2"></i></a>
                    </p>
                    <p class="text-muted">&copy; <span id="year"></span> Tous droits réservés</p>

                </div>
                <div class="col-md-2">
                    <img class="img-fluid" src="Images/logo.jpg" height="100%" width="100%">
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