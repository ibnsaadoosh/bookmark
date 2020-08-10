<?php
$header = $footer = false;
$pageName = "Log In";
include "init.php";

if (isset($_SESSION['user_data'])) {
    header("Location: index.php");
    die();
}


include "models/User.php";
include "controllers/LoginController.php";

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login = new LoginController();
    $res = $login->login($_POST['username'], $_POST['password']);

    if ($res === true) {
        header("Location: index.php");
        die();
    } else {
        $errors["System"][] = "Invalid Username or Password";
    }

    $username = $_POST['username'];
}

require_once "vendors/config.php";
$loginURL = $gClient->createAuthUrl();

?>

<div class="container">
    <div class="row">
        <div class="intro col-md-6">
            <img class="login-image" src="layout/images/loginPage.png" alt="Login">
        </div>
        <div class="signup-form text-center col-md-6">
            <h4 class="title">Log In</h4>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group signup-input">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username; ?>" />
                </div>
                <div class="form-group signup-input">
                    <input type="password" class="form-control" name="password" placeholder="Password" />
                </div>
                <p class="validation">Please enter at least 8 characters</p>
                <button class="btn btn-primary form-control signup" type="submit">Log In</button>
            </form>
            <?php
            if (count($errors) != 0) {
                foreach ($errors as $el => $msg) {
                    echo '<div class="alert alert-danger backend-error">' . $msg[0] . '</div>';
                }
            }
            ?>
            <div class="or">OR</div>
            <button class="btn btn-default form-control google-login" onclick="window.location = '<?php echo $loginURL ?>';"><img class="img-circle img-responsive" src="layout/images/googleLogin.png" alt=""> Continue with Google</button>
            <p class="lead signin">Have no account yet? <a href="signup.php">Register now</a></p>
        </div>
    </div>
</div>

<?php
include "includes/footerIncludes.php";
?>