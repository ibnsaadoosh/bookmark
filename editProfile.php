<?php
$header = true;
$pageName = "Edit profile";
include "init.php";

require_once "models/User.php";
require_once "controllers/UserController.php";

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    die();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updated = [];

    $updated['id'] = $_SESSION['user_data']['id'];
    if (!empty($_POST['first_name'])) $updated['firstName'] = $_POST['first_name'];
    if (!empty($_POST['last_name'])) $updated['lastName'] = $_POST['last_name'];
    if (!empty($_POST['username'])) $updated['username'] = $_POST['username'];
    if (!empty($_POST['password'])) $updated['password'] = $_POST['password'];
    if (!empty($_POST['email'])) $updated['email'] = $_POST['email'];
    if (!empty($_FILES['avatar']['name'])) $updated['image'] = $_FILES['avatar'];

    // echo "<pre>";
    // print_r($updated);
    // echo "</pre>";

    if (count($updated) > 1) {
        $userController = new UserController();
        $res = $userController->update($updated);
        if ($res === true) {
            echo "<script>alert('Your profile updated successfully!')</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Not updated!')</script>";
            $errors = $res;
        }
    }
}

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
            <h2 class="text-center">Edit your profile</h2> <br />
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" value="<?php echo $_SESSION['user_data']['firstName']; ?>" name="first_name" class="form-control" id="first-name" placeholder="Edit your first name">
                </div> <br />
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" value="<?php echo $_SESSION['user_data']['lastName']; ?>" name="last_name" class="form-control" id="last-name" placeholder="Edit your last name">
                </div> <br />
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" value="<?php echo $_SESSION['user_data']['username']; ?>" name="username" class="form-control" id="username" placeholder="Edit username">
                </div> <br />
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Edit your password">
                </div> <br />
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" value="<?php echo $_SESSION['user_data']['email']; ?>" name="email" class="form-control" id="email" placeholder="Edit your email">
                </div> <br />
                <div class="form-group">
                    <label for="image">Avatar</label>
                    <input type="file" name="avatar" id="image">
                    <p class="help-block">Update you avatar</p>
                </div> <br />
                <button type="submit" name="add-link" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div><br><br>

<?php
include_once "includes/footerIncludes.php";
