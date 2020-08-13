<?php
$image = "uploads/images/avatars/";
if (filter_var($_SESSION['user_data']['image'], FILTER_VALIDATE_URL)) {
    $image = $_SESSION['user_data']['image'];
} elseif (!empty($_SESSION['user_data']['image'])) {
    $image .= $_SESSION['user_data']['image'];
} else {
    $image .= "default.png";
}
?>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Bookmark saver</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="<?php echo $pageName == 'All links' ? 'active' : '';  ?>"><a href="index.php">My links</a></li>
                <li class="<?php echo $pageName == 'All folders' ? 'active' : '';  ?>"><a href="folders.php">My folders</a></li>
                <li class="<?php echo $pageName == 'Main directory' ? 'active' : '';  ?>"><a href="mainDirectory.php">Main directory</a></li>
                <li class="<?php echo $pageName == 'Add manually' ? 'active' : '';  ?>"><a href="addManually.php">Add manually</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php echo $pageName == 'Edit profile' ? 'active' : '';  ?>">
                    <a class="image-link" href="editProfile.php">
                        <img class="profile_image img-circle" src="<?php echo $image; ?>" alt="Edit profile" title="Edit profile">
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>