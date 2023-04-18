<?php
require_once("Includes/Session.php");
?>
<?php
require_once("Includes/DB.php");
?>

<?php
require_once("Includes/Functions.php");

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

    footer {
      background-color: #dfe0e2;


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
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

      <a href="Blog.php?page=1"><img src="Images/logo.jpg" alt=""></a>
      <button style="background-color:#FF8000;" class="navbar-toggler" data-toggle="collapse"
        data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="Blog.php?page=1" class="nav-link active">Accueil</a>
          </li>
          <li class="nav-item">
            <a href="Login.php" class="nav-link">Apropos de nous</a>
          </li>

          <li class="nav-item">
            <a href="Login.php" class="nav-link">Nous Contacter</a>
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

        <ul class="navbar-nav ml-auto">
          <il class="nav-item">
            <a style="text-decoration: none;" href="Login.php" class="btn-outline_orange"><i class="fas fa-user"></i>
              Connexion</a>
          </il>
        </ul>

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
        <marquee>
          <h1 class="lead text-success">Ici nous partageons avec vous nos pensées, opinions, et expériences.</h1>
        </marquee>
        <?php
        echo ErrorMessage();
        echo SuccessMessage();

        ?>
        <?php
        global $ConnectingDB;

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

          //query when pagination is Active i.e Blog.php?page=1
        

        } elseif (isset($_GET["page"])) {
          $Page = $_GET["page"];
          if ($Page == 0 || $Page < 1) {
            $ShowPostFrom = 0;
          } else {
            $ShowPostFrom = ($Page * 4) - 4;
          }
          $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,4";
          $stmt = $ConnectingDB->query($sql);
        } elseif (isset($_GET["category"])) {
          $Category = $_GET["category"];
          $sql = "SELECT * FROM posts WHERE category =:categoryName";
          $stmt = $ConnectingDB->prepare($sql);
          $stmt->bindValue(':categoryName', $Category);
          $stmt->execute();

        } else {
          //the default sql query
        
          $sql = "SELECT *FROM posts ORDER BY id desc LIMIT 0,3";
          $stmt = $ConnectingDB->query($sql);
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
            <img src="Uploads/<?php echo $Image; ?>" style="max-height: 400px;" class="img-fluid card-img-top" />
            <div class="card-body">

              <h4 class="card-title">
                <?php echo htmlentities($PostTitle) ?>
              </h4>
              <small class="text-muted">Category :<span style="font-weight: bold;" class="text-dark">
                  <a href="Blog.php?category=<?php echo htmlentities($Category); ?>">
                    <?php echo htmlentities($Category); ?>
                  </a>
                </span>
                | Ecris par
                <a href="Profile.php?username=<?php echo $Admin ?>"><span style="font-weight: bold;">
                    <?php echo htmlentities($Admin); ?>
                  </span>
                </a> le
                <?php echo htmlentities($DateTime); ?>
              </small>
              <a href="Login.php"><span style="float:right;" class="badge bg-dark text-light">
                  <i class='fas fa-comments' style='color:white'></i> Commentaires
                  <?php
                  $ApprovedComment = ApprovedPostComment($PostId);
                  if ($ApprovedComment > 0) {
                    echo $ApprovedComment;
                  } ?>
                </span></a>
              <hr>
              <p class="card-text">
                <?php
                if (strlen($PostDescription) > 150) {
                  $PostDescription = substr($PostDescription, 0, 150) . '...';
                }

                echo nl2br($PostDescription) ?>
              </p>
              <a href="Login.php" style="float:right ;">
                <span class="btn btn-outline_search">Plus >></span>

              </a>
            </div>
          </div>
          <br>
        <?php } ?>

        <!-- Pagination -->
        <nav class="mb-5">

          <ul class="pagination pagination-md">
            <?php
            if (isset($Page)) {
              if ($Page > 1) { ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page - 1; ?>" class="page-link">
                    &laquo;
                  </a>
                </li>


              <?php }
            } ?>
            <?php
            global $ConnectingDB;
            $sql = "SELECT COUNT(*) FROM posts";
            $stmt = $ConnectingDB->query($sql);
            $PaginationRow = $stmt->fetch();
            $TotalPosts = array_shift($PaginationRow);

            $PostPagination = $TotalPosts / 4;
            $PostPagination = ceil($PostPagination);

            for ($i = 1; $i <= $PostPagination; $i++) {
              if (isset($Page)) {
                if ($i == $Page) { ?>

                  <li class="page-item active">
                    <a href="Blog.php?page=<?php echo $i ?>" class="page-link">
                      <?php echo $i ?>
                    </a>
                  </li>
                  <?php

                } else { ?>
                  <li class="page-item">
                    <a href="Blog.php?page=<?php echo $i ?>" class="page-link">
                      <?php echo $i ?>
                    </a>
                  </li>

                <?php }
              }
            } ?>
            <?php
            if (isset($Page)) {
              if ($Page + 1 <= $PostPagination) { ?>
                <li class="page-item">
                  <a href="Blog.php?page=<?php echo $Page + 1; ?>" class="page-link">
                    &raquo;
                  </a>
                </li>


              <?php }
            } ?>

          </ul>
        </nav>
      </div>
      <!-- Side Area Start -->
      <div style="position: relative; right: 0;" class="col-sm-4 mb-5 ">
        <div class="card mt-4">
          <div class="card-body">
            <img src="Images/welcomImage.jpg" class="d-block img-fluid mb-3" alt="">
            <div class="text-start">
              "Bienvenue sur notre blog! Nous sommes ravis de partager nos pensées, opinions et expériences avec vous.
              Nous espérons que vous apprécierez la lecture de nos articles et que vous les trouverez informatifs et
              divertissants. N'hésitez pas à laisser des commentaires et à partager notre contenu avec vos amis et vos
              abonnés. Nous attendons avec impatience de nous connecter avec vous et d'apprendre de vos perspectives.
              Merci de nous avoir rendu visite."
            </div>

          </div>
        </div>
        <br>
        <div class="mt-4">
          <div style="background-color: #FF8000;" class="card-header text-light">
            <h2 class="lead">Nous rejoindre</h2>
          </div>
          <div class="card-body">
            <?php
            if (isset($_SESSION['UserId'])) {
              ?>
              <a href="Blog.php?page=1" class="btn btn-outline_search  btn-block text-center mb-4 "
                name="Button">Rejoindre
                le forum</a>
            <?php } else {
              ?>
              <a href="SignIn.php" class="btn btn-outline_search btn-block text-center mb-4" name="Button">Rejoindre
                le forum</a>
            <?php }
            ?>
            <?php
            if (isset($_SESSION['UserId'])) {
              ?>
              <a href="Blog.php?page=1" type="button"
                class="btn btn-outline-primary btn-block text-center text-primary mb-4" name="Button">Connexion</a>
            <?php } else {
              ?>
              <a href="Login.php" type="button" class="btn btn-outline-primary btn-block text-center text-primary mb-4"
                name="Button">Connexion</a>
            <?php }
            ?>
            <?php
            if (isset($_SESSION['UserId'])) {
              ?>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter your email" name="Button"
                  style="border-color:#ff8000">
                <div class="input-group-append">
                  <a style="background-color: #FF8000;color:#fff" href="Contact.php"
                    class="btn btn-outline_orange btn-sm text-center" name="Button">Souscrire
                  </a>
                </div>

              </div>
            <?php } else {
              ?>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter your email" name="Button"
                  style="border-color:#ff8000">
                <div class="input-group-append">
                  <a style="background-color: #FF8000;color:#fff" href="Login.php"
                    class="btn btn-outline_orange btn-sm text-center" name="Button">Souscrire
                  </a>
                </div>

              </div>
            <?php }
            ?>

          </div>

        </div>
        <br>
        <div>
          <div style="background-color: #3bb186d7;" class="card-header text-light">
            <h2 class="lead">Catégories</h2>
          </div>
          <div class="card-body">
            <?php

            global $ConnectingDB;
            $sql = "SELECT * FROM categories ORDER BY id";
            $stmt = $ConnectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
              $CategoryId = $DataRows['id'];
              $CategoryName = $DataRows['title'];


              ?>
              <a style="text-decoration: none;" href="Blog.php?category=<?php echo $CategoryName ?>"><span
                  class="heading">
                  <?php echo $CategoryName ?>
                </span></a>
              <span style="float: right; background-color: #FF8000; " class="badge text-light">
                <?php echo PostNumber($CategoryName) ?>
              </span>

              <br>
            <?php } ?>

          </div>


        </div>
        <div class="mt-4">
          <div class="card-header bg-info text-light">
            <h2 class="lead">Posts Recents</h2>
          </div>
          <div class="card-body">
            <?php
            global $ConnectingDB;
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
            $stmt = $ConnectingDB->query($sql);
            while ($DataRows = $stmt->fetch()) {
              $Id = $DataRows["id"];
              $Title = $DataRows["title"];
              $DateTime = $DataRows["datetime"];
              $Image = $DataRows["image"];


              ?>
              <div class="media">
                <img src="Uploads/<?php echo $Image; ?>" class="d-block img-fluid align-self-start" width="100" alt="">
                <div class="media-body ml-2">
                  <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank">
                    <h6 class="lead">
                      <?php echo htmlentities($Title) ?>
                    </h6>
                  </a>
                  <p class="small">
                    <?php echo htmlentities($DateTime) ?>
                  </p>
                </div>

              </div>
              <hr>
            <?php } ?>

          </div>
        </div>


        <!-- Side Area End -->

      </div>
    </div>

    <!-- MAIN END -->

  </div>
  <!--FOOTER-->

  <footer>
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
          <img class="img-fluid" src="Images/logo.jpg" height="100%" width="100%">
        </div>
      </div>
    </div>
  </footer>
  <!--FOOTER END  -->

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
    $("#year").text(new Date().getFullYear())  </script>
</body>

</html>