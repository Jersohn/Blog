<?php
require_once("./Includes/Session.php");
?>
<?php
require_once("./Includes/DB.php");
?>

<?php
require_once("./Includes/Functions.php");
?>

<?php
//$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];

if (isset($_SESSION["UserId"])) {
  header("location: Users/Blog.php?page=1");
  exit();
}

if (isset($_POST["Submit"])) {
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  if (empty($UserName) || empty($Password)) {
    $_SESSION["ErrorMessage"] = 'All fields must be filled out!';
    header("location: Login.php");
    exit();
  } else {
    //code for checking username and password from Database.
    $stmt = $ConnectingDB->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $UserName]);
    $row = $stmt->fetch();
    if (!$row) {
      $_SESSION["ErrorMessage"] = 'Incorrect Username';
      header("location: Login.php");
      exit();
    }
    $Password_hash = $row['password'];


    if (password_verify($Password, $Password_hash)) {

      $FoundAccount = LoginAttempt($UserName, $Password_hash);
      if ($FoundAccount) {

        $_SESSION["UserId"] = $FoundAccount['id'];
        $_SESSION["UserName"] = $FoundAccount['username'];
        $_SESSION["Isadmin"] = $FoundAccount['isadmin'];
        $_SESSION["SuccessMessage"] = 'Welcom ' . $_SESSION["UserName"];


        if ($_SESSION["Isadmin"] == 'true') {
          if (isset($_SESSION["TrackingURL"])) {
            header("location:" . $_SESSION["TrackingURL"]);
            exit();
          } else {
            header("location:Admins/Dashboard.php?page=1");
            exit();
          }
        } else {
          header("location:Users/Blog.php?page=1");
          exit();
        }
      } else {
        $_SESSION["ErrorMessage"] = 'Incorrect Username/Password';
        header("location: Login.php");
        exit();
      }

    } else {
      $_SESSION["ErrorMessage"] = 'Incorrect Password';
      header("location: Login.php");
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

  <title>Document</title>
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
      color: #FF8000;
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
  </styl.navbar-dark>
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
            <a href="Blog.php?page=1" class="nav-link">Accueil</a>
          </li>

        </ul>

        <ul class="navbar-nav ml-auto">
          <il class="nav-item">
            <a href="SignIn.php" class="btn-outline_search nav-link text-light"><i class="fas fa-user"></i>
              Inscription</a>
          </il>
        </ul>

      </div>
    </div>
  </nav>
  <div style="height: 100px;"></div>
  <header>
    <div class="container">
      <div class="row">

        <div style="color: #FF8000; font-weight: bold;" class="col text-center my-5">
          <marquee>
            <p> Bienvenue sur notre blog d'information ! <span style="color: #3bb186d7;"> veillez vous
                authentifier</span>
            </p>
          </marquee>

        </div>

      </div>
    </div>
  </header>


  <!-- MAIN AREA START -->

  <section class="container py-2">
    <div class="row">

      <div class=" offset-sm-3 col-sm-6" style="min-height:500px;">
        <br><br><br>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();

        ?>

        <div class=" bg-light">

          <div style="color: #3bb186d7;">
            <h2 class=" card text-center bg-light">Connexion</h2>
          </div>
          <div class="card-body">
            <form action="Login.php" method="POST">
              <div class="form-group">
                <label for="username"> <span>Username </span></label>
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
                <label for="password"> <span>Password </span></label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span style="background-color:#3bb186d7;" class="input-group-text text-white"><i
                        class="fas fa-lock"></i>

                    </span>
                  </div>
                  <input type="password" class="form-control" name="Password" id="password" value="">

                </div>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
              </div>
              <input type="submit" name="Submit" class="btn btn-outline_search btn-block" value="Submit">
              <small>Don't have an account ? <a style="color: #ff8000;" href="SignIn.php">Create
                  one here</a> </small>
            </form>

          </div>
        </div>

      </div>

    </div>

  </section>



  <!-- MAIN AREA END -->


  <!--FOOTER-->
  <footer style="background-color: #dfe0e2">
    <div class="container">
      <div class="row py-5">
        <nav class="nav">

          <a style="color:#3bb186d7;" href="Blog.php?page=1" class="nav-link">Accueil</a>

        </nav>
        <div class="offset-md-2 col-md-6 text-center">
          <p class="lead">
            Conçu avec <i class="fas fa-heart text-danger"></i> par <span style="color: #3bb186d7;">
              JERSOHN_ASSAMOI </span>
            <a href="https://github.com/Jersohn" style="color: #3bb186d7;"><i class="fab fa-github fa-lg ml-2"></i></a>
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