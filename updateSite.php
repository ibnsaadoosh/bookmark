<?php
$header = true;
$pageName = "Edit site";
include "init.php";
include "models/Site.php";
include "controllers/SiteController.php";
include "models/Folder.php";
include "controllers/FolderController.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    die();
}

$linkTitle = '';
$linkComments = '';
$linkParent = '';
$link = '';

if (isset($_GET['id'])) {

    if (!is_numeric($_GET['id'])) {
        echo "<div class='alert alert-danger'>This id is <strong>not valid</strong></div>";
        die();
    } else if (empty($_GET['id'])) {
        echo "<div class='alert alert-danger'>Id can't be <strong>empty</strong></div>";
        die();
    } else {
        $id = $_GET['id'];

        $siteController = new SiteController();
        $site = $siteController->get("*", ['id', 'user_id'], [$_GET['id'], $_SESSION['user_data']['id']], 'AND')->fetchAll();

        $linkTitle = $site[0]['title'];
        $linkComments = $site[0]['comment_section'];
        $linkParent = $site[0]['parent'];
        $link = $site[0]['link'];
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $linkTitle = $_POST['title'];
    $linkComments = $_POST['comments'];
    $linkParent = $_POST['parent'];
    $link = $_POST['link'];

    $updated = [];

    $updated['id'] = $id;
    if (!empty($_POST['title'])) $updated['title'] = $_POST['title'];
    if (!empty($_POST['comments'])) $updated['comment_section'] = $_POST['comments'];
    if (!empty($_POST['parent']) || $_POST['parent'] == null) $updated['parent'] = $_POST['parent'];
    if (!empty($_POST['link'])) $updated['link'] = $_POST['link'];

    echo "<pre>";
    print_r($updated);
    echo "</pre>";

    if (count($updated) > 1) {
        $siteController = new SiteController();
        $res = $siteController->update($updated);
        if ($res === true) {
            echo "<script>alert('Your profile updated successfully!')</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Not updated!')</script>";
            $errors = $res;
            header("Location: updateSite.php?id=" . $id);
        }
    } else {
        header("Location: index.php");
        exit();
    }
}

$folderController = new FolderController();
$folders = $folderController->get("id, title", ["user_id"], [$_SESSION['user_data']['id']])->fetchAll();

?>

<div class="add-link container">
    <div class="row">
        <div class="col-md-8 col-xs-12 col-md-offset-2">
            <?php
            if (count($errors) != 0) {
                foreach ($errors as $el => $msg) {
                    echo '<div class="alert alert-danger backend-error">' . $msg[0] . '</div>';
                }
            }
            ?>
            <h2 class="text-center">Update link</h2> <br />
            <form action="?id=<?php echo $id; ?>" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="<?php echo $linkTitle ?>">
                </div> <br />
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea name="comments" rows="7" class="form-control" id="comments" placeholder="Enter your comments"><?php echo $linkComments ?></textarea>
                </div> <br />
                <select name="parent" class="form-control">
                    <?php
                    if (count($folders) > 0) {
                        echo "<option disabled>Choose folder</option>";
                        if ($linkParent == null) {
                            echo "<option value='null' selected>no parent</option>";
                        } else {
                            echo "<option value='null' selected>no parent</option>";
                        }
                        foreach ($folders as $folder) {
                            $selected = $folder['id'] == $linkParent && $linkParent != null ? "selected" : "";
                            echo "<option value='" . $folder['id'] . "' " . $selected . ">" . $folder['title'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>No folders to choose</option>";
                    }
                    ?>
                </select> <br />
                <div class="form-group">
                    <label for="link">link</label>
                    <input type="text" name="link" class="form-control" id="link" placeholder="Enter link" value="<?php echo $link ?>">
                </div> <br />
                <button type="submit" name="add-link" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<br><br>

<?php
include_once "includes/footerIncludes.php";
