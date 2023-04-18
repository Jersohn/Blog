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
ConfirmLogin();
?>


<?php
$ParamId = $_GET['id'];

global $ConnectingDB;

$sql = "SELECT*FROM posts WHERE id='$ParamId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
  $Title = $DataRows['title'];
  $Category = $DataRows['category'];
  $Image = $DataRows['image'];
  $Post = $DataRows['post'];

}



if (isset($_POST['Submit'])) {
  global $ConnectingDB;
  //Delete query
  $sql = "DELETE FROM posts WHERE id ='$ParamId'";

  $Execute = $ConnectingDB->query($sql);


  //  $this->log($Execute, 'debug');

  if ($Execute) {
    $Target_Path_To_Delete_Image = "Uploads/$Image";
    unlink($Target_Path_To_Delete_Image);

    $_SESSION["SuccessMessage"] = "Post with id : " . $ParamId . " Successfully Deleted";
    header("location:Posts.php?page=1");
    exit();
  } else {
    $_SESSION["ErrorMessage"] = "Something went wrong, try again!";
    header("location: DeletePost.php?id=$ParamId");
    exit();
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

  <title>Delete Post</title>
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
  <?php
  require_once("Navigation.php")
    ?>

  <!--HEADER-->

  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>
            <i class="fas fa-edit" style="color: #ff8000"></i> Delete Post
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


        <form action="DeletePost.php?id=<?php echo $ParamId; ?>" method="post" enctype="multipart/form-data">
          <div class=" card text-dark">

            <div class="card-body">
              <div class="form-group">
                <label for="title">Post Title</label>
                <input disabled class="form-control" type="text" name="PostTitle" id="title"
                  placeholder="type title here" value="<?php echo $Title ?>" />
              </div>
              <div class="form-group">
                <span style="color:#ff8000;">Existing Category :</span>
                <?php echo $Category ?> <br>

              </div>
              <div class="form-group">
                <span style="color:#ff8000;">Existing Image :</span>
                <img class="mb-2" src="../Uploads/<?php echo $Image ?>" width="170px" height="70px" /> <br>

              </div>
              <div class="form-group">
                <label for="post"> <span class="FieldInfo"> Post:</span></label>
                <textarea disabled class="form-control" id="post" name="PostDescription" rows="8" cols="80">
                          <?php echo $Post ?>
                        </textarea>
              </div>
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php?page=1" class="btn btn-outline_green btn-block"><i
                      class="fas fa-arrow-left"></i> Back to
                    Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-danger btn-block"><i class="fas fa-trash"></i>
                    Delete</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

    </div>
  </section>

  <!--FOOTER-->
  <?php
  require_once("Footer.php")
    ?>
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