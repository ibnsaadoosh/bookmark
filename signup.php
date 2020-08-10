<?php
$header = $footer = false;
$pageName = "Sign Up";
include "init.php";

if (isset($_SESSION['user_data'])) {
    header("Location: index.php");
    die();
}

include "models/User.php";
include "controllers/RegisterController.php";

$errors = [];
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    $user->set(null, $_POST['username'], $_POST['password'], null, null, $_POST['email'], null, $_SERVER['REMOTE_ADDR']);

    $register = new RegisterController();
    $res = $register->register($user);

    if ($res === true) {
        echo "<script>alert('Congrats! You have an account now')</script>";
        header("Location: login.php");
        die();
    } elseif ($res === false) {
        $errors["System"][] = "An error occurred, try again later";
    } else {
        $errors = $res;
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
}


require_once "vendors/config.php";
$loginURL = $gClient->createAuthUrl();

?>

<div class="container">
    <div class="row">
        <div class="intro col-md-6">
            <h1 class="title text-center">Get started with Bookmark saver</h1>
            <div class="info row">
                <div class="col-md-3">
                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                </div>
                <div class="col-md-9">
                    <p class="desc lead">Save anything from across the web in a personal library.</p>
                </div>
            </div>
            <div class="info row">
                <div class="col-md-3">
                    <i class="fa fa-mobile" aria-hidden="true"></i>
                </div>
                <div class="col-md-9">
                    <p class="desc lead">Enjoy whatever you save, whenever you’re free.</p>
                </div>
            </div>
            <div class="info row">
                <div class="col-md-3">
                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                </div>
                <div class="col-md-9">
                    <p class="desc lead">Get thought-provoking stories in our daily newsletter.</p>
                </div>
            </div>
        </div>
        <div class="signup-form text-center col-md-6">
            <h4 class="title">Sign Up</h4>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="form-group signup-input">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username; ?>" />
                </div>
                <div class="form-group signup-input">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email; ?>" />
                </div>
                <div class="form-group signup-input">
                    <input type="password" class="form-control" name="password" placeholder="Password" />
                </div>
                <p class="validation">Please enter at least 8 characters</p>
                <button class="btn btn-primary form-control signup" type="submit">Sign Up</button>
            </form>
            <?php
            if (count($errors) != 0) {
                foreach ($errors as $el => $msg) {
                    echo '<div class="alert alert-danger backend-error">' . $msg[0] . '</div>';
                }
            }
            ?>
            <div class="or">OR</div>
            <button onclick="window.location = '<?php echo $loginURL ?>';" class="btn btn-default form-control google-login">
                <img class="img-circle img-responsive" src="layout/images/googleLogin.png" alt="">
                Continue with Google
            </button>
            <p class="lead signin">Already have an account? <a href="login.php">Log in now</a></p>
        </div>
    </div>
</div>

<?php
include "includes/footerIncludes.php";
?>