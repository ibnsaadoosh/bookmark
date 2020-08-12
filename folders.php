<?php
$header = true;
$pageName = "All folders";
include "init.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    die();
}

require_once "controllers/FolderController.php";

$folderController = new FolderController();

$folders = $folderController->get("*", 'user_id', $_SESSION['user_data']['id'])->fetchAll();

?>

<div class="my-links container">
    <?php
    if (count($folders) > 0) {
        foreach ($folders as $folder) {
            echo '
            <div class="col-md-4 col-xs-12">
                <div class="link">
                    <div class="icon text-center">
                        <i class="fa fa-folder-open fa-5x"></i>
                    </div>
                    <h4 class="title">' . $folder['title'] . '</h4>
                    <p class="comment lead">Comments: ' . $folder['comment_section'] . '</p>
                </div>
            </div>
            ';
        }
    } else {
        echo "<p class='text-center lead'>You have no folders</p>";
    }
    ?>
</div>

<?php
include_once "includes/footerIncludes.php";
