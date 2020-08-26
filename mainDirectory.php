<?php
$header = true;
$pageName = "Main directory";
include "init.php";
require_once "controllers/FolderController.php";
require_once "controllers/SiteController.php";
require_once "includes/functions.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    die();
}

$folders = [];
$parentFolder = '';
$sites = [];
$all = [];

if (isset($_GET['parent'])) {

    if (!is_numeric($_GET['parent'])) {
        echo "<div class='alert alert-danger'>This parent is <strong>not valid</strong></div>";
    } else if (empty($_GET['parent'])) {
        echo "<div class='alert alert-danger'>Parent can't be <strong>empty</strong></div>";
    } else {
        $folderController = new FolderController();
        $folders = $folderController->get("*", ["user_id", "parent"], [$_SESSION['user_data']['id'], intval($_GET['parent'])], "AND")->fetchAll();
        $parentFolder = $folderController->get("title", ["id"], [intval($_GET['parent'])])->fetch();

        $siteController = new SiteController();
        $sites = $siteController->get("*", ["parent"], [intval($_GET['parent'])])->fetchAll();

        $all = array_merge($folders, $sites);
    }
} else {
    $folderController = new FolderController();
    $folders = $folderController->get("*", ["user_id", "parent"], [$_SESSION['user_data']['id'], NULL], "AND")->fetchAll();

    $siteController = new SiteController();
    $sites = $siteController->get("*", ["user_id", "parent"], [$_SESSION['user_data']['id'], NULL], "AND")->fetchAll();

    $all = array_merge($folders, $sites);
}

if (count($all) > 0) {
    usort($all, 'date_compare');
}

?>

<div class="my-links container">
    <h2>Parent: <?php echo empty($parentFolder['title']) ? "Main" : $parentFolder['title']; ?></h2>
    <hr>
    <div class="row">
        <?php
        if (count($all) > 0) {
            foreach ($all as $item) {
                $icon = isset($item['link']) ? 'link' : 'folder-open';
                $link = isset($item['link']) ? '<a href="' . $item['link'] . '" class="url">' . $item['link'] . '</a>' : '';
                $anchorOpenning = isset($item['link']) ? '' : '<a href="mainDirectory.php?parent=' . $item['id'] . '">';
                $anchorClosing = isset($item['link']) ? '' : '</a>';
                $deletePage = isset($item['link']) ? 'deleteSite' : 'deleteFolder';
                $edit = isset($item['link']) ? "updateSite" : "updateFolder";
                echo '
                <div class="col-md-4 col-xs-12">
                    <div class="link">
                        <a href="' . $deletePage . '.php?id=' . $item['id'] . '">
                            <i class="fa fa-times fa-lg delete" title="Delete"></i>
                        </a>
                        <div class="icon text-center">
                            <i class="fa fa-' . $icon . ' fa-5x"></i>
                        </div>
                        ' . $anchorOpenning . '
                            <h4 class="title">' . $item['title'] . '</h4>
                            <a href="' . $edit . '.php?id=' . $item['id'] . '">
                                <i class="fa fa-pencil fa-lg update" title="Delete"></i>
                            </a>
                        ' . $anchorClosing . '
                        <p class="comment lead">Comments: ' . $item['comment_section'] . '</p>
                        ' . $link . '
                        <span class="date">' . $item['date'] . '</span>
                    </div>
                </div>
                ';
            }
        } else {
            echo "<p class='text-center lead'>No items found</p>";
        }
        ?>
    </div>
</div>

<?php
include_once "includes/footerIncludes.php";
