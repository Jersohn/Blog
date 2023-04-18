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
  $Category = $_POST['CategoryTitle'];
  $Admin = $_SESSION["UserName"];


  date_default_timezone_set("Africa/Tunis");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);



  if (empty($Category)) {
    $_SESSION["ErrorMessage"] = 'this field must be filled out!';
    header("location: Categories.php");
    exit();

  } elseif (strlen($Category) < 2) {
    $_SESSION["ErrorMessage"] = 'Category title should be greater than 2 characters!';
    header("location: Categories.php");
    exit();
  } elseif (strlen($Category) > 49) {
    $_SESSION["ErrorMessage"] = 'Category title should be less than 50 characters!';
    header("location: Categories.php");
    exit();
  } else {
    //insertion query





    $sql = "INSERT INTO categories(title,author,datetime)";
    $sql .= "VALUES(:categoryName,:adminName,:datetime)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':datetime', $DateTime);

    $Execute = $stmt->execute();
    //  $this->log($Execute, 'debug');


    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Category with id : " . $ConnectingDB->lastInsertId() . " Successfully added";
      header("location: Categories.php");
      exit();
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong, try again!";
      header("location: Categories.php");
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

  <title>Categories</title>
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
      padding: 10px 20px;
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

    .btn-outline_green {
      background-color: transparent;
      color: #3bb186d7;
      border: 2px solid #3bb186d7;
      border-radius: 4px;
      padding: 10px 20px;
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

    label {
      color: #ff8000
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
          <h1>
            <i class="fas fa-edit" style="color: #ff8000"></i> Manage Categories
          </h1>
        </div>
      </div>
    </div>
  </header>
  <!--Main Area-->

  <section class="container py-2 mt-5">
    <div class="row">
      <div style="border-left:solid 3px #ff8000;" class='col-lg-2 bg-light'>
        <div class="mb-1">
          <div class="card-body"><a href="Admins.php" style="color:#FF8000; text-decoration: none;">
              <h5>
                Users
              </h5>
            </a>

            <h4 class="display-5 text-success">
              <i class="fas fa-users"></i>
              <?php echo TotalUsers() ?>

            </h4>
          </div>

        </div>
        <hr>
        <div class="mb-1">
          <div class="card-body">
            <a href="Posts.php?page=1" class="text-success" style="text-decoration: none;">
              <h5>
                Posts
              </h5>
            </a>
            <h4 class="display-5" style="color:#FF8000">
              <i class="fab fa-readme"></i>
              <?php echo TotalPosts() ?>

            </h4>
          </div>

        </div>
        <hr>
        <div class="mb-1">
          <div class="card-body">
            <a href="Categories.php" style="color:#FF8000; text-decoration: none;">
              <h5>
                Categories
              </h5>
            </a>
            <h4 class="display-5 text-success">
              <i class="fas fa-folder"></i>
              <?php echo TotalCategories() ?>

            </h4>
          </div>

        </div>
        <hr>
        <div class="mb-1">
          <div class="card-body">
            <a href="Comments.php?page=1" class="text-success" style="text-decoration: none;">
              <h5>
                Comments
              </h5>
            </a>
            <h4 class="display-5" style="color:#FF8000">
              <i class="fas fa-comments"></i>
              <?php echo TotalComments() ?>

            </h4>
          </div>

        </div>
        <hr>
        <div class="mb-1">
          <div class="card-body">
            <a href="UserMessage.php" style="color:#FF8000; text-decoration: none;">
              <h5>
                Messages
              </h5>
            </a>
            <h4 class="display-5 text-success">
              <i class="fas fa-comments"></i>
              <?php echo TotalMessage() ?>

            </h4>
          </div>

        </div>



      </div>
      <div class="col-lg-10" style="min-height:400px;">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();

        ?>


        <form action="Categories.php" method="post">
          <div>
            <div class="card-header">
              <h1 style="color: #3bb186d7;background-color:#fff"><i class='fas fa-folder-plus'></i> Add New Category
              </h1>
            </div>
            <div class="card-body bg-light">
              <div class="form-group">
                <label for="title">Category Title</label>
                <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="type title here"
                  value="" />
              </div>
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php?page=1" class="btn btn-outline_orange btn-block"><i
                      class="fas fa-arrow-left"></i> Back
                    to
                    Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-outline_green btn-block"><i
                      class="fas fa-check"></i>Publish</button>
                </div>
              </div>
            </div>
          </div>
        </form><br>
        <h2>Existing Categories</h2>

        <table class='table table-hover'>
          <thead style="color: #ff8000;" class="bg-light">
            <tr>
              <th>No.</th>
              <th>Date&Time</th>
              <th>Title</th>
              <th>Creator Name</th>
              <th>Action</th>
            </tr>

          </thead>

          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM categories ORDER BY id desc";
          $Execute = $ConnectingDB->query($sql);
          $SerieNum = 0;

          while ($DataRows = $Execute->fetch()) {
            $CategoryId = $DataRows['id'];
            $CategoryDate = $DataRows['datetime'];
            $CategoryTitle = $DataRows['title'];
            $CreatorName = $DataRows['author'];
            $SerieNum++;

            ?>
            <tbody>
              <tr>
                <td>
                  <?php echo htmlentities($SerieNum) ?>
                </td>
                <td>
                  <?php echo htmlentities($CategoryDate) ?>
                </td>
                <td>
                  <?php echo htmlentities($CategoryTitle) ?>
                </td>
                <td>
                  <?php echo htmlentities($CreatorName) ?>
                </td>
                <?php require_once("DeleteCategoryModal.php") ?>


                <td>
                  <a href="DeleteCategory.php?id=<?php echo htmlentities($CategoryId) ?>" type="button"
                    class="btn btn-outline-danger" data-toggle="modal" data-target="#confirmDeleteModal"
                    style="border:none">
                    <i class='fas fa-trash'></i>
                  </a>

                </td>

              </tr>
            </tbody>

          <?php }
          ?>

        </table>
      </div>

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
    $("#year").text(new Date().getFullYear());
  </script>
</body>

</html>