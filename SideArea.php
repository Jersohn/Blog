<?php
require_once("Includes/Functions.php")
    ?>

<div class="card mt-4">
    <div class="card-body">
        <img src="../Images/welcomImage.jpg" class="d-block img-fluid mb-3" alt="">
        <div class=" lead text-start">
            "Bienvenue sur notre blog! Nous sommes ravis de partager nos pensées, opinions et expériences avec vous.
            Nous espérons que vous apprécierez la lecture de nos articles et que vous les trouverez informatifs et
            divertissants. N'hésitez pas à laisser des commentaires et à partager notre contenu avec vos amis et vos
            abonnés. Nous attendons avec impatience de nous connecter avec vous et d'apprendre de vos perspectives.
            Merci de nous avoir rendu visite."
        </div>

    </div>
</div>
<br>
<div class=" card mt-2">
    <div style="background-color: #FF8000;" class="card-header text-light">
        <h2 class="lead">Nous rejoindre</h2>
    </div>
    <div class="card-body">
        <?php
        if (isset($_SESSION['UserId'])) {
            ?>
            <a href="Blog.php?page=1" class="btn btn-outline_green  btn-block text-center text-success mb-4 "
                name="Button">Rejoindre
                le forum</a>
        <?php } else {
            ?>
            <a href="SignIn.php" class="btn btn-outline_green btn-block text-center text-white mb-4 bg-light"
                name="Button">Rejoindre
                le forum</a>
        <?php }
        ?>
        <?php
        if (isset($_SESSION['UserId'])) {
            ?>
            <a href="Blog.php?page=1" type="button" class="btn btn-outline-primary btn-block text-center text-primary mb-4"
                name="Button">Connexion</a>
        <?php } else {
            ?>
            <a href="Login.php" type="button" class="btn btn-outline-primary btn-block text-center text-white mb-4"
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
<div class="card">
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
            <a style="text-decoration: none;" href="Blog.php?category=<?php echo $CategoryName ?>"><span class="heading">
                    <?php echo $CategoryName ?>
                </span></a>
            <span style="float: right; background-color: #FF8000; " class="badge text-light">
                <?php echo PostNumber($CategoryName) ?>
            </span>

            <br>
        <?php } ?>

    </div>


</div>
<div class=" card mt-4">
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
                <img src="../Uploads/<?php echo $Image; ?>" class="d-block img-fluid align-self-start" width="100" alt="">
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