<?php
require_once('../Includes/Session.php');
?>
<?php
require_once('../Includes/DB.php');
?>

<?php
require_once('../Includes/Functions.php');
?>
<?php

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
ConfirmLogin();
?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <script src='https://kit.fontawesome.com/905f0814b0.js' crossorigin='anonymous'></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css'
        integrity='sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS' crossorigin='anonymous' />
    <link rel='stylesheet' href='../Css/Style.css' />

    <title>Comments page</title>
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

    <header class='bg-dark text-white py-3'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h1>
                        <i class='fas fa-comments' style='color: #ff8000'></i> Manage Comments
                    </h1>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->
    <!-- MAIN AREA START -->
    <section class='container py-2 mt-4'>
        <div class='row' style='min-height:30px;'>
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
            <div class='col-lg-10' style='min-height:400px;'>
                <?php
                echo ErrorMessage();
                echo SuccessMessage();

                ?>

                <h2>Un-Approved Comments</h2>

                <table class='table table-hover '>
                    <thead style="color: #ff8000;" class="bg-light">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>Name</th>

                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>

                    </thead>

                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SerieNum = 0;

                    while ($DataRows = $Execute->fetch()) {
                        $CommentId = $DataRows['id'];
                        $CommentDate = $DataRows['datetime'];
                        $CommenterName = $DataRows['name'];

                        $CommentContent = $DataRows['comment'];
                        $PostCommented = $DataRows['post_id'];
                        $SerieNum++;

                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo htmlentities($SerieNum) ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommentDate) ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommenterName) ?>
                                </td>

                                <td>
                                    <?php echo htmlentities($CommentContent) ?>
                                </td>
                                <td> <a href="ApproveComment.php?id=<?php echo htmlentities($CommentId) ?>"
                                        class='btn btn-outline_green' style="border:none">Approve</a></td>
                                <?php
                                require_once("ConfirmationModal.php")
                                    ?>
                                <td>
                                    <a href="DeleteComment.php?id=<?php echo htmlentities($CommentId) ?>" type="button"
                                        class="btn btn-outline-danger" data-toggle="modal" data-target="#confirmDeleteModal"
                                        style="border:none">
                                        <i class='fas fa-trash'></i>
                                    </a>

                                </td>

                                <td> <a href="FullPost.php?id=<?php echo htmlentities($PostCommented) ?>"
                                        class='btn btn-outline-primary' target='_blank' style="border:none"><i
                                            class='fas fa-info'></i></a></td>

                            </tr>
                        </tbody>

                    <?php }
                    ?>

                </table>
                <h2>Approved Comments</h2>

                <table class='table table-hover '>
                    <thead style="color: #ff8000;" class="bg-light">
                        <tr>
                            <th>No.</th>
                            <th>Date&Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Revert</th>

                            <th>Details</th>
                        </tr>

                    </thead>

                    <?php
                    global $ConnectingDB;

                    $Page = $_GET["page"];
                    if (isset($_GET["page"])) {
                        if ($Page == 0 || $Page < 1) {
                            $ShowCommentFrom = 0;
                        } else {
                            $ShowCommentFrom = ($Page * 4) - 4;
                        }
                        $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc LIMIT $ShowCommentFrom,4";

                        $Execute = $ConnectingDB->query($sql);
                    } else {


                        $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc LIMIT 0,4";
                        $Execute = $ConnectingDB->query($sql);
                    }

                    $Counter = ($Page - 1) * 4;

                    while ($DataRows = $Execute->fetch()) {
                        $CommentId = $DataRows['id'];
                        $CommentDate = $DataRows['datetime'];
                        $CommenterName = $DataRows['name'];
                        $CommentContent = $DataRows['comment'];
                        $PostCommented = $DataRows['post_id'];
                        $Counter++;

                        ?>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo htmlentities($Counter) ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommentDate) ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommenterName) ?>
                                </td>
                                <td>
                                    <?php echo htmlentities($CommentContent) ?>
                                </td>
                                <td> <a href="DisApproveComment.php?id=<?php echo htmlentities($CommentId) ?>"
                                        class='btn btn-outline_orange' style="border:none">Disapprove</a></td>

                                <td> <a href="FullPost.php?id=<?php echo htmlentities($PostCommented) ?>"
                                        class='btn btn-outline-primary' target='_blank' style="border:none"><i
                                            class='fas fa-info'></i></a></td>

                            </tr>
                        </tbody>

                    <?php }
                    ?>

                </table>
                <nav>

                    <ul class="pagination pagination-md">
                        <?php
                        if (isset($Page)) {
                            if ($Page > 1) { ?>
                                <li class="page-item">
                                    <a href="Comments.php?page=<?php echo $Page - 1; ?>" class="page-link">
                                        &laquo;
                                    </a>
                                </li>


                            <?php }
                        } ?>
                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM comments WHERE status='ON'";
                        $stmt = $ConnectingDB->query($sql);
                        $PaginationRow = $stmt->fetch();
                        $TotalComments = array_shift($PaginationRow);

                        $CommentPagination = $TotalComments / 4;
                        $CommentPagination = ceil($CommentPagination);

                        for ($i = 1; $i <= $CommentPagination; $i++) {
                            if (isset($Page)) {
                                if ($i == $Page) { ?>

                                    <li class="page-item active">
                                        <a href="Comments.php?page=<?php echo $i ?>" class="page-link">
                                            <?php echo $i ?>
                                        </a>
                                    </li>
                                    <?php

                                } else { ?>
                                    <li class="page-item">
                                        <a href="Comments.php?page=<?php echo $i ?>" class="page-link">
                                            <?php echo $i ?>
                                        </a>
                                    </li>

                                <?php }
                            }
                        } ?>
                        <?php
                        if (isset($Page)) {
                            if ($Page + 1 <= $CommentPagination) { ?>
                                <li class="page-item">
                                    <a href="Comments.php?page=<?php echo $Page + 1; ?>" class="page-link">
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
    <!-- MAIN AREA END -->

    <!--FOOTER-->
    <?php require_once("Footer.php"); ?>

    <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'
        integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo'
        crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js'
        integrity='sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut'
        crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js'
        integrity='sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k'
        crossorigin='anonymous'></script>

    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>