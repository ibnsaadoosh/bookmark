<?php
$header = true;
$pageName = "Add manually";
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

$folderTitle = '';
$folderComments = '';
$folderParent = '';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add-link'])) {
        $linkTitle = $_POST['title'];
        $linkComments = $_POST['comments'];
        $linkParent = $_POST['parent'] == 'null' ? NULL : $_POST['parent'];
        $link = $_POST['link'];

        $site = new Site();
        $site->set(null, $_POST['title'], $_POST['link'], $_POST['comments'], $linkParent, $_SESSION['user_data']['id']);

        $siteController = new SiteController();
        $siteRes = $siteController->add($site);
        if ($siteRes === true) {
            echo "<script>alert('Link added successfully!')</script>";
            header("Location: index.php");
            die();
        } else {
            $errors = $siteRes;
        }
    } elseif (isset($_POST['add-folder'])) {
        $folderTitle = $_POST['title'];
        $folderComments = $_POST['comments'];
        $folderParent = $_POST['parent'] == 'null' ? NULL : $_POST['parent'];

        $folder = new folder();
        $folder->set(null, $_POST['title'], $_POST['comments'], $folderParent, $_SESSION['user_data']['id']);

        $folderController = new FolderController();
        $folderRes = $folderController->add($folder);
        if ($folderRes === true) {
            echo "<script>alert('Folder added successfully!')</script>";
            header("Location: folders.php");
            die();
        } else {
            $errors = $folderRes;
        }
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
            <h2 class="text-center">Add link</h2> <br />
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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
<hr>
<div class="add-folder container">
    <div class="row">
        <div class="col-md-8 col-xs-12 col-md-offset-2">
            <h2 class="text-center">Add folder</h2> <br />
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" value="<?php echo $folderTitle ?>">
                </div> <br />
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea name="comments" rows="7" class="form-control" id="comments" placeholder="Enter your comments"><?php echo $folderComments ?></textarea>
                </div> <br />
                <select name="parent" class="form-control">
                    <?php
                    if (count($folders) > 0) {
                        echo "<option disabled>Choose folder</option>";
                        if ($folderParent == null) {
                            echo "<option value='null' selected>no parent</option>";
                        } else {
                            echo "<option value='null' selected>no parent</option>";
                        }
                        foreach ($folders as $folder) {
                            $selected = $folder['id'] == $folderParent && $folderParent != null ? "selected" : "";
                            echo "<option value='" . $folder['id'] . "' " . $selected . ">" . $folder['title'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>No folders to choose</option>";
                    }
                    ?>
                </select> <br />
                <button type="submit" name="add-folder" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div><br><br>

<?php
include_once "includes/footerIncludes.php";
