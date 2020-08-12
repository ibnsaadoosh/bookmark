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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add-link'])) {
        $site = new Site();
        $site->set(null, $_POST['title'], $_POST['link'], $_POST['comments'], $_POST['parent'], $_SESSION['user_data']['id']);

        $siteController = new SiteController();
        if ($siteController->add($site) === true) {
            echo "<script>alert('Link added successfully!')</script>";
            header("Location: index.php");
            die();
        }
    } elseif (isset($_POST['add-folder'])) {
        $folder = new folder();
        $folder->set(null, $_POST['title'], $_POST['comments'], $_POST['parent'], $_SESSION['user_data']['id']);

        $folderController = new FolderController();
        if ($folderController->add($folder) === true) {
            echo "<script>alert('Folder added successfully!')</script>";
            header("Location: folders.php");
            die();
        }
    }
} else {
    $folderController = new FolderController();
    $folders = $folderController->get("id, title", "user_id", $_SESSION['user_data']['id'])->fetchAll();
}

?>

<div class="add-link container">
    <div class="row">
        <div class="col-md-8 col-xs-12 col-md-offset-2">
            <h2 class="text-center">Add link</h2> <br />
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                </div> <br />
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea name="comments" rows="7" class="form-control" id="comments" placeholder="Enter your comments"></textarea>
                </div> <br />
                <select name="parent" class="form-control">
                    <?php
                    if (count($folders) > 0) {
                        echo "<option disabled>Choose folder</option>";
                        foreach ($folders as $folder) {
                            echo "<option value='" . $folder['id'] . "'>" . $folder['title'] . "</option>";
                        }
                    } else {
                        echo "<option disabled>No folders to choose</option>";
                    }
                    ?>
                </select> <br />
                <div class="form-group">
                    <label for="link">link</label>
                    <input type="text" name="link" class="form-control" id="link" placeholder="Enter link">
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
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter title">
                </div> <br />
                <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea name="comments" rows="7" class="form-control" id="comments" placeholder="Enter your comments"></textarea>
                </div> <br />
                <select name="parent" class="form-control">
                    <?php
                    if (count($folders) > 0) {
                        echo "<option disabled>Choose folder</option>";
                        foreach ($folders as $folder) {
                            echo "<option value='" . $folder['id'] . "'>" . $folder['title'] . "</option>";
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
