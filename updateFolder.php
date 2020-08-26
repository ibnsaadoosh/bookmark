<?php
$header = true;
$pageName = "Edit site";
include "init.php";
include "models/Folder.php";
include "controllers/FolderController.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    die();
}

$folderTitle = '';
$folderComments = '';
$folderParent = '';

if (isset($_GET['id'])) {

    if (!is_numeric($_GET['id'])) {
        echo "<div class='alert alert-danger'>This id is <strong>not valid</strong></div>";
        die();
    } else if (empty($_GET['id'])) {
        echo "<div class='alert alert-danger'>Id can't be <strong>empty</strong></div>";
        die();
    } else {
        $id = $_GET['id'];

        $folderController = new FolderController();
        $folder = $folderController->get("*", ['id', 'user_id'], [$_GET['id'], $_SESSION['user_data']['id']], 'AND')->fetchAll();

        $folderTitle = $folder[0]['title'];
        $folderComments = $folder[0]['comment_section'];
        $folderParent = $folder[0]['parent'];
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $folderTitle = $_POST['title'];
    $folderComments = $_POST['comments'];
    $folderParent = $_POST['parent'];

    $updated = [];

    $updated['id'] = $id;
    if (!empty($_POST['title'])) $updated['title'] = $_POST['title'];
    if (!empty($_POST['comments'])) $updated['comment_section'] = $_POST['comments'];
    if (!empty($_POST['parent'])) $updated['parent'] = $_POST['parent'] == 'null' ? NULL : $_POST['parent'];

    // echo "<pre>";
    // print_r($updated);
    // echo "</pre>";

    if (count($updated) > 1) {
        $folderController = new FolderController();
        $res = $folderController->update($updated);
        if ($res === true) {
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Not updated!')</script>";
            $errors = $res;
            header("Location: updateSite.php?id=" . $id);
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
            <h2 class="text-center">Update folder</h2> <br />
            <form action="?id=<?php echo $id; ?>" method="POST">
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
                <button type="submit" name="add-link" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<br><br>

<?php
include_once "includes/footerIncludes.php";
