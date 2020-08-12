<?php
$header = true;
$pageName = "Main directory";
include "init.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    die();
}

?>

<div class="my-links container">
    <div class="col-md-4 col-xs-12">
        <div class="link">
            <div class="icon text-center">
                <i class="fa fa-folder-open fa-5x"></i>
            </div>
            <h4 class="title">Main directory</h4>
            <p class="comment lead">Comments: Parent directory of all folders and links</p>
        </div>
    </div>
</div>

<?php
include_once "includes/footerIncludes.php";
