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

  $PostTitle = $_POST["PostTitle"];
  $Category = $_POST['Category'];
  $Image = $_FILES['Image']['name'];
  $Target = "../Uploads/" . basename($_FILES['Image']['name']);
  $PostText = $_POST["PostDescription"];
  $Admin = $_SESSION["UserName"];


  date_default_timezone_set("Africa/Tunis");
  $CurrentTime = time();
  setlocale(LC_ALL, array('fr_FR.UTF-8'));
  $DateTime = strftime("%d %B %Y %H:%M:%S", $CurrentTime);



  if (empty($PostTitle)) {
    $_SESSION["ErrorMessage"] = 'Title can not be empty!';
    header("location: AddNewPost.php");
    exit();

  } elseif (strlen($PostTitle) < 5) {
    $_SESSION["ErrorMessage"] = 'Post title should be greater than 5 characters!';
    header("location: AddNewPost.php");
    exit();
  } elseif (strlen($PostText) > 9999) {
    $_SESSION["ErrorMessage"] = 'Post description should be less than 10000 characters!';
    header("location: AddNewPost.php");
    exit();
  } else {
    //insertion query





    $sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
    $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
    $stmt = $ConnectingDB->prepare($sql);

    $stmt->bindValue(':dateTime', $DateTime);
    $stmt->bindValue(':postTitle', $PostTitle);
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':imageName', $Image);
    $stmt->bindValue(':postDescription', $PostText);

    $Execute = $stmt->execute();
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);



    //  $this->log($Execute, 'debug');


    if ($Execute) {
      $_SESSION["SuccessMessage"] = "Post with id : " . $ConnectingDB->lastInsertId() . " Successfully added";
      header("location: AddNewPost.php");
      exit();
    } else {
      $_SESSION["ErrorMessage"] = "Something went wrong, try again!";
      header("location: AddNewPost.php");
      exit();
    }

  }
}


?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/905f0814b0.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
  <link rel="stylesheet" href="../Css/Style.css" />

  <title>New Post</title>
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
            <i class="fas fa-edit" style="color: #ff8000"></i> Add New Post
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


        <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
          <div class="text-dark">

            <div class="card-body bg-light">
              <div class="form-group">
                <label for="title" style="color:#ff8000">Post Title</label>
                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="type title here"
                  value="" />
              </div>
              <div class="form-group">
                <label for="title" style="color:#ff8000">Choose Category</label>
                <select class="form-control" id="category" name="Category">
                  <?php
                  //Fetching all the categories from category table
                  global $ConnectingDB;
                  $sql = "SELECT id,title FROM Categories";
                  $stmt = $ConnectingDB->query($sql);
                  while ($DataRows = $stmt->fetch()) {
                    $id = $DataRows["id"];
                    $CategoryName = $DataRows["title"];

                    ?>
                    <option>
                      <?php echo $CategoryName; ?>
                    </option>

                  <?php } ?>

                </select>
              </div>
              <div class="form-group">
                <div class="custom-file">

                  <input class="custom-file-input" type="file" name="Image" id="image" value="" />
                  <label for="image" class="custom-file-label">Select Image</label>
                </div>
              </div>
              <div class="form-group">
                <label for="post" style="color:#ff8000"> Post</label>
                <textarea class="form-control" id="post" name="PostDescription" rows="8" cols="80"></textarea>
              </div>
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php?page=1" class="btn btn-outline_orange btn-block"><i
                      class="fas fa-arrow-left"></i>
                    Back to
                    Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-outline_green btn-block"><i
                      class="fas fa-check"></i> Publish</button>
                </div>
              </div>
            </div>
          </div>
        </form>
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