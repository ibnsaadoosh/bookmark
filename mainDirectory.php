<?php
$header = true;
$pageName = "Main directory";
include "init.php";
require_once "controllers/FolderController.php";
require_once "controllers/SiteController.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    die();
}

$folders = [];
$sites = [];

if (isset($_GET['parent'])) {

    if (!is_numeric($_GET['parent'])) {
        echo "<div class='alert alert-danger'>This parent is <strong>not valid</strong></div>";
    } else if (empty($_GET['parent'])) {
        echo "<div class='alert alert-danger'>Parent can't be <strong>empty</strong></div>";
    } else {
        $folderController = new FolderController();
        $folders = $folderController->get("*", ["user_id", "parent"], [$_SESSION['user_data']['id'], intval($_GET['parent'])], "AND")->fetchAll();

        $siteController = new SiteController();
        $sites = $siteController->get("*", "parent", intval($_GET['parent']))->fetchAll();
    }
} else {
    $folderController = new FolderController();
    $folders = $folderController->get("*", ["user_id", "parent"], [$_SESSION['user_data']['id'], NULL], "AND")->fetchAll();

    $siteController = new SiteController();
    $sites = $siteController->get("*", "parent", NULL)->fetchAll();
}

?>

<div class="my-links container">
    <div class="row">
        <?php
        if (count($folders) > 0) {
            foreach ($folders as $folder) {
                echo '
                <a href="folders.php?parent=' . $folder['id'] . '">
                    <div class="col-md-4 col-xs-12">
                        <div class="link">
                            <div class="icon text-center">
                                <i class="fa fa-folder-open fa-5x"></i>
                            </div>
                            <h4 class="title">' . $folder['title'] . '</h4>
                            <p class="comment lead">Comments: ' . $folder['comment_section'] . '</p>
                        </div>
                    </div>
                </a>
                ';
            }
        }
        if (count($sites) > 0) {
            foreach ($sites as $site) {
                echo '
                <div class="col-md-4 col-xs-12">
                    <div class="link">
                        <div class="icon text-center">
                            <i class="fa fa-link fa-5x"></i>
                        </div>
                        <h4 class="title">' . $site['title'] . '</h4>
                        <p class="comment lead">Comments: ' . $site['comment_section'] . '</p>
                        <a href="' . $site['link'] . '" class="url">' . $site['link'] . '</a>
                    </div>
                </div>
                ';
            }
        }
        if (count($sites) == 0 && count($folders) == 0) {
            echo "<p class='text-center lead'>No items found</p>";
        }
        ?>
    </div>
</div>

<?php
include_once "includes/footerIncludes.php";
