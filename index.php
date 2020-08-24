<?php
$header = true;
$pageName = "All links";
include "init.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    die();
}

require_once "controllers/SiteController.php";

$siteController = new SiteController();

$sites = $siteController->get("*", ['user_id'], [$_SESSION['user_data']['id']])->fetchAll();

?>

<div class="my-links container">
    <?php
    if (count($sites) > 0) {
        foreach ($sites as $site) {
            echo '
            <div class="col-md-4 col-xs-12">
                <div class="link">
                    <a href="deleteSite.php?id=' . $site['id'] . '">
                        <i class="fa fa-times fa-lg delete" title="Delete"></i>
                    </a>
                    <div class="icon text-center">
                        <i class="fa fa-link fa-5x"></i>
                    </div>
                    <h4 class="title">
                        ' . $site['title'] . '
                    </h4>
                    <a href="updateSite.php?id=' . $site['id'] . '">
                        <i class="fa fa-pencil fa-lg update" title="Delete"></i>
                    </a> 
                    <p class="comment lead"><span class="custom">Comments:</span> ' . $site['comment_section'] . '</p>
                    <a href="' . $site['link'] . '" class="url">' . $site['link'] . '</a>
                    <span class="date">' . $site['date'] . '</span>
                </div>
            </div>
            ';
        }
    } else {
        echo "<p class='text-center lead'>You have no links</p>";
    }
    ?>
</div>

<?php
include_once "includes/footerIncludes.php";
