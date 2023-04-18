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


global $ConnectingDB;
$ParamID = $_GET['id'];
if (isset($_POST['Submit'])) {
  $Name = $_POST['CommenterName'];
  $Email = $_POST['CommenterEmail'];
  $Comment = $_POST['CommenterThoughts'];


  date_default_timezone_set("Africa/Tunis");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);



  if (empty($Name) || empty($Email) || empty($Comment)) {
    $_SESSION["ErrorMessage"] = 'this field must be filled out!';
    header("location: FullPost.php?id=<?php echo $ParamID ;?>");
    exit();

  } elseif (strlen($Comment) > 499) {
    $_SESSION["ErrorMessage"] = 'Comment should be less than 500 characters!';
    header("location: FullPost.php?id=<?php echo $ParamID ;?>");
    exit();
  } else {
    //insertion query





    $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
    $sql .= "VALUES(:cmntdatetime,:cmntname,:cmntemail,:cmntcomment,'pending','OFF',:postID)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':cmntdatetime', $DateTime);
    $stmt->bindValue(':cmntname', $Name);
    $stmt->bindValue(':cmntemail', $Email);
    $stmt->bindValue(':cmntcomment', $Comment);
    $stmt->bindValue(':postID', $ParamID);

    $Execute = $stmt->execute();
    //  $this->log($Execute, 'debug');


    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Comment  Successfully added.Please wait, an admin will approve it ";
      header("location: Blog.php?page=1");
      exit();
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong, try again!";
      header("location: Blog.php?page=1");
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

  <title>Blog Page</title>
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
            <a href="UserProfil.php" class="nav-link active text-success"><i class="fas fa-user"></i> Profile</a>
          </li>
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
              <a style="text-decoration: none;" href="../Login.php" class="btn-outline_orange"><i class="fas fa-user"></i>
                Connexion</a>
            </il>
          </ul>

        <?php } ?>

      </div>
    </div>
  </nav>
  <div style="height:100px;"></div>
  <!--HEADER-->


  <div class="container">
    <div class="row mt-4">
      <!-- MAIN AREA -->
      <div class="col-sm-8">
        <h1>Bienvenue sur notre Blog </h1>
        <h1 class="lead">Informations,Pensées, opinions, et expériences</h1>
        <?php

        echo ErrorMessage();
        echo SuccessMessage();


        //Sql query when search button is active
        
        if (isset($_GET["SearchButton"])) {
          $SearchString = $_GET["Search"];


          $sql = "SELECT*FROM Posts
              WHERE datetime LIKE :search 
              OR title LIKE :search
              OR category LIKE :search
              OR post LIKE :search 
              ORDER BY id desc";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt->bindValue(':search', '%' . $SearchString . '%');
          $stmt->execute();


        } else {
          //the default sql query
        
          if (!isset($ParamID)) {
            $_SESSION["ErrorMessage"] = "Bad Request !";
            header("location: Blog.php?page=1");
            exit();
          }

          $sql = "SELECT *FROM posts WHERE id='$ParamID'";
          $stmt = $ConnectingDB->query($sql);
          $Result = $stmt->rowCount();
          if ($Result != 1) {
            $_SESSION["ErrorMessage"] = "Bad Request !";
            header("location: Blog.php?page=1");
            exit();

          }
        }

        while ($DataRows = $stmt->fetch()) {
          $PostId = $DataRows["id"];
          $DateTime = $DataRows["datetime"];
          $PostTitle = $DataRows["title"];
          $Category = $DataRows["category"];
          $Admin = $DataRows["author"];
          $Image = $DataRows["image"];
          $PostDescription = $DataRows["post"];



          ?>

          <div class="card">

            <img src="../Uploads/<?php echo $Image; ?>" style="max-height: 400px;" class="img-fluid card-img-top" />
            <div class="card-body">

              <h4 class="card-title">
                <?php echo htmlentities($PostTitle) ?>
              </h4>
              <small class="text-muted">Categorie :<a style="font-weight: bold;" class="text-dark">
                  <a href="Blog.php?category=<?php echo htmlentities($Category); ?>">
                    <?php echo htmlentities($Category); ?>
                  </a>
                  ??</a>
                </span>
                | Ecris par
                <a href="Profile.php?username=<?php echo $Admin ?>"><span style="font-weight: bold;">
                    <?php echo htmlentities($Admin); ?>
                  </span>
                </a> On
                <?php echo htmlentities($DateTime); ?>
              </small>
              <span style="float:right; background-color: #3bb186d7;" class="badge text-light">
                Commentaires
                <?php
                $ApprovedComment = ApprovedPostComment($PostId);
                if ($ApprovedComment > 0) {
                  echo $ApprovedComment;
                } ?>
              </span>
              <hr>
              <p class="card-text">
                <?php echo nl2br($PostDescription) ?>
              </p>

            </div>
          </div>
          <br>
        <?php } ?>
        <!-- Comment part start -->
        <span style="color:rgb(251, 174, 44);font-size: 1.2em ;">Commentaires</span>
        <br><br>

        <!-- fetch existing comment in db -->
        <?php
        global $ConnectingDB;
        $sql = "SELECT * FROM comments WHERE post_id ='$ParamID' AND status ='ON'";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
          $CommentDate = $DataRows['datetime'];
          $CommenterName = $DataRows['name'];
          $CommentContent = $DataRows['comment'];


          ?>
          <div class="mb-4">
            <div class="media" style="background-color:#F6F7F9 ;">
              <img class="align-self-start" src="../Images/commenter.png" alt="commenter" width="50px" height="50px">
              <div class="media-body ml-2">
                <h6 class="lead">
                  <?php echo $CommenterName ?>
                </h6>
                <p class="small">
                  <?php echo $CommentDate ?>
                </p>
                <p style="font-style:italic ;">
                  <?php echo $CommentContent ?>
                </p>
              </div>
            </div>

          </div>

        <?php } ?>
        <!-- fetch comment end -->
        <div class="">
          <form action="FullPost.php?id=<?php echo $ParamID ?>" method="post">
            <div class="card mb-3">
              <div class="card-header">
                <h5 style="color:rgb(251, 174, 44);">Partage tes pensées à propos de ce post</h5>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                  </div>

                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input class="form-control" type="Email" name="CommenterEmail" placeholder="Email" value="">
                  </div>

                </div>
                <div class="form-group">
                  <textarea name="CommenterThoughts" class="form-control" cols="30" rows="6"></textarea>
                </div>
                <div>
                  <button style="background-color: #3bb186d7; color: white;" type="submit" name="Submit"
                    class="btn">Soumettre</button>
                </div>
              </div>
            </div>

          </form>
        </div>
      </div>
      <!-- Comment part end -->
      <!-- side area start -->
      <div class="col-sm-4">
        <?php
        require_once("../SideArea.php");
        ?>
      </div>


      <!-- side area END -->
    </div>
  </div>

  <!-- MAIN END -->

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
            Conçu avec <i class="fas fa-heart text-danger"></i> par <span style="color: #3bb186d7; font-weight: bold;">
              JERSOHN_ASSAMOI </span>
            <a href="https://github.com/Jersohn" style="color: #3bb186d7;"><i class="fab fa-github fa-lg ml-2"></i></a>
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

  <!-- FOOTER END -->

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