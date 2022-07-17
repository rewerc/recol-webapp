<?php
session_start();
require("../AAR/config.php");
if (isset($_SESSION['username']) && !isset($_SESSION["admin"])) {
    header("Location: ../AAR/admin.php");
}
elseif (isset($_SESSION['username'])) {
    header("Location: ../AAR/home.php");
}

function toError($string) {
    echo "<span class='form-err'>*" . $string . "</span>";
}

$error_email = false;
$error_username = false;
$error_username_2 = false;
$error_username_3 = false;
$error_password = false;

if (isset($_POST["signup-submit"])) {
    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["rpassword"]) && isset($_POST["email"])) {
        $email = $_POST["email"];
        $username = $_POST["username"];
        $pword = $_POST["password"];

        $res = retrieve("SELECT uname,email FROM aar_users WHERE email = '$email'");
        if (!empty($res)) {
            $error_email = true;
        }
        
        unset($res);
        $res = retrieve("SELECT uname,email FROM aar_users WHERE uname = '$username'");

        if (is_numeric($username[0])) {
            $error_username = true;
        }
        elseif (strpos($username, " ") !== false || strpos($username, '"') !== false || strpos($username, "'") !== false || strpos($username, "<") !== false || strpos($username, ">") !== false) {
            $error_username_2 = true;
        }
        elseif (!empty($res)) {
            $error_username_3 = true;
        }

        if ($pword !== $_POST["rpassword"]) {
            $error_password = true;
        }

        if (!$error_email && !$error_password && !$error_username_3 && !$error_username_2 && !$error_username) {
            query("INSERT INTO aar_users(uname, email, pswd) VALUES('$username', '$email', '$pword')");
            $_SESSION["signedup"] = true;
            header("Location: ../AAR/thankyou.php");
        }
    }
}

?>

<?php include("header.php");?>
<link rel="stylesheet" href="../AAR/assets/css/style.css">
<title>Sign up to Recol</title>
</head>

<body id="signup-body">
    <div class="container" style="height: 580px;">
		<form action="../AAR/signup.php" method="POST" class="login-email">
            <p class="login-text">Sign up to Recol</p>
			<div class="input-group">
				<label for="inputUsername" style="padding-top: 200px;">
                    Username
                    <?php if($error_username) toError("Your username needs to start with an alphabetical character."); ?>
                    <?php if($error_username_2) toError("Your username shouldn't contain any white spaces and some special characters."); ?>
                    <?php if($error_username_3) toError("This username has already been used."); ?>
                </label>
				<input id="inputUsername" type="text" placeholder="Username" name="username" required>
			</div>
			<div class="input-group" style="margin-top: 42px;">
				<label for="inputEmail">
                    Email
                    <?php if ($error_email) toError("This email has already been used."); ?>
                </label>
				<input id="inputEmail" type="email" placeholder="Email" name="email" required>
			</div>
			<div class="input-group" style="margin-top: 42px;">
				<label for="inputPassword">Password</label>
				<input id="inputPassword" type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-group" style="margin-top: 42px;">
				<label for="inputRepeatPassword">
                    Repeat Password
                    <?php if ($error_password) toError("This doesn't match the password you inputted.") ?>
                </label>
				<input id="inputRepeatPassword" type="password" placeholder="Repeat Password" name="rpassword" required>
			</div>
			<div class="input-group" style="margin-top: 42px;">
				<button name="signup-submit" type="submit" class="btn">Sign Up</button>
			</div>
			<div style="padding-top: 13px; padding-bottom: 9px; font-size:15px; font-weight:400;">
				<div>
					<p>Already have an account? Log in <a href="../AAR/login.php"> here</a></p>
				</div>
			</div>
		</form>
	</div>


    <?php include("footer.php"); ?>