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

  <title>All Posts</title>
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
  <?php require_once("Navigation.php") ?>


  <!--HEADER-->

  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>
            <i class="fas fa-blog" style="color: #ff8000"></i> Blog Posts
          </h1>
        </div>
        <div class='col-lg-3 mb-2'>
          <a href='Comments.php?page=1' class='btn btn-outline_green btn-block'><i class='fas fa-check'></i>Approve
            Comments</a>
        </div>
        <div class='col-lg-3 mb-2'>
          <a href='AddNewPost.php' class='btn btn-outline-primary btn-block'><i class='fas fa-edit'></i>Add
            New
            Post</a>
        </div>

        <div class='col-lg-3 mb-2'>
          <a href='Categories.php' class='btn btn-outline-info btn-block'><i class='fas fa-folder-plus'></i>Add New
            Category</a>
        </div>
        <div class='col-lg-3 mb-2'>
          <a href='Admins.php' class='btn btn-outline_orange btn-block'><i class='fas fa-user-plus'></i>Add
            New
            Admin</a>
        </div>


      </div>
    </div>
  </header>
  <!-- Header end -->
  <!-- Main area -->


  <section class="container py-2 my-5">

    <?php
    echo ErrorMessage();
    echo SuccessMessage(); ?>

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
      <div class="col-lg-10">

        <table class="table table-hover ">
          <thead style="color: #ff8000;" class="bg-light">
            <tr>
              <th>N°</th>
              <th>Title</th>
              <th>Category</th>
              <th>Date&Time</th>
              <th>Author</th>
              <th>Banner</th>
              <th>Comments</th>
              <th>Actions</th>
              <th>Live Preview</th>
            </tr>
          </thead>
          <?php
          global $ConnectingDB;



          if (isset($_GET["page"])) {
            $Page = $_GET["page"];

            if ($Page == 0 || $Page < 1) {
              $ShowPostFrom = 0;
            } else {
              $ShowPostFrom = ($Page * 6) - 6;
            }
            $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $ShowPostFrom,6";
            $stmt = $ConnectingDB->query($sql);


          } else {

            // Default sql request.
          
            $sql = "SELECT *FROM posts ORDER BY id desc LIMIT 0,6";
            $stmt = $ConnectingDB->query($sql);
          }


          $Counter = ($Page - 1) * 6;

          while ($DataRows = $stmt->fetch()) {
            $Id = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $PostTitle = $DataRows["title"];
            $Category = $DataRows["category"];
            $Admin = $DataRows["author"];
            $Image = $DataRows["image"];
            $PostText = $DataRows["post"];
            $Counter++;

            ?>
            <tbody>
              <tr>
                <td>
                  <?php
                  echo $Counter
                    ?>
                </td>
                <td>
                  <?php
                  if (strlen($PostTitle) > 20) {
                    $PostTitle = substr($PostTitle, 0, 10) . '..';
                  }
                  echo $PostTitle;
                  ?>
                </td>
                <td>
                  <?php
                  if (strlen($Category) > 8) {
                    $Category = substr($Category, 0, 8) . '..';
                  }

                  echo $Category ?>
                </td>
                <td>
                  <?php
                  if (strlen($DateTime) > 11) {
                    $DateTime = substr($DateTime, 0, 11) . '..';
                  }

                  echo $DateTime ?>
                </td>
                <td>
                  <?php
                  if (strlen($Admin) > 8) {
                    $Admin = substr($Admin, 0, 8) . '..';
                  }

                  echo $Admin ?>
                </td>
                <td><img src="../Uploads/<?php echo $Image; ?>" width="100px" height="65px"></td>
                <td>

                  <?php
                  $ApprovedComment = ApprovedPostComment($Id);
                  if ($ApprovedComment > 0) {
                    ?>
                    <span class="badge badge-success">
                      <?php echo $ApprovedComment ?>
                    </span>


                  <?php } ?>
                  <?php
                  $DisapprovedComment = DisapprovedPostComment($Id);
                  if ($DisapprovedComment > 0) {
                    ?>
                    <span class="badge badge-danger">
                      <?php echo $DisapprovedComment ?>
                    </span>


                  <?php } ?>

                </td>
                <td><a href="EditPost.php?id=<?php echo $Id ?>"><span class="btn btn-outline-info" style="border:none"><i
                        class="fas fa-edit"></i></span></a>
                  <a href="DeletePost.php?id=<?php echo $Id ?>"><span class="btn btn-outline-danger"
                      style="border:none"><i class="fas fa-trash"></i></span></a>
                </td>
                <td><a href="FullPost.php?id=<?php echo $Id ?>" target="blank"><span class="btn btn-outline-success"
                      style="border:none"><i class="fas fa-eye"></i> <i class="fas fa-eye"></i></span></a></td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
        <nav>

          <ul class="pagination pagination-md">
            <?php
            if (isset($Page)) {
              if ($Page > 1) { ?>
                <li class="page-item">
                  <a href="Posts.php?page=<?php echo $Page - 1; ?>" class="page-link">
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
                    <a href="Posts.php?page=<?php echo $i ?>" class="page-link">
                      <?php echo $i ?>
                    </a>
                  </li>
                  <?php

                } else { ?>
                  <li class="page-item">
                    <a href="Posts.php?page=<?php echo $i ?>" class="page-link">
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
                  <a href="Posts.php?page=<?php echo $Page + 1; ?>" class="page-link">
                    &raquo;
                  </a>
                </li>


              <?php }
            } ?>

          </ul>
        </nav>
      </div>
    </div>




  </section>
  <!-- Main area end -->


  <!--FOOTER-->

  <?php require_once('Footer.php') ?>




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