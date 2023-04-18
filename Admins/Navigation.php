<?php
require_once('../Includes/Session.php');
require_once('../Includes/DB.php');
require_once('../Includes/Functions.php');


?>


<nav style="background-color:  #dfe0e2;" class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

        <a href="Blog.php?page=1"><img src="../Images/logo.jpg" alt=""></a>
        <button style="background-color:#FF8000;" class="navbar-toggler" data-toggle="collapse"
            data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link">
                        <i class="fas fa-user text-success"></i> My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php?page=1" class="nav-link">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a href="UserMessage.php" class="nav-link"><span class="badge badge-success">
                            <?php echo TotalMessage() ?>
                        </span> Messages</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <il class="nav-item">
                    <a href="../Logout.php" class="btn-outline_orange" style="text-decoration:none"><i
                            class="fas fa-user-times"></i>
                        Logout</a>
                </il>
            </ul>
        </div>
    </div>
</nav>
<div style="height:100px;"></div>