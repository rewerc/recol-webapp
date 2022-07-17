<?php 
session_start();
require("../AAR/config.php");

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
}

if (isset($_SESSION['username']) && isset($_SESSION['admin'])) {
    header("Location: ../AAR/admin.php");
}
elseif (isset($_SESSION['username'])) {
    header("Location: ../AAR/home.php");
}

function toError($string) {
    echo "<span class='form-err'>*" . $string . "</span>";
}

$not_registered = false;

if(isset($_POST["login-submit"])) {
    
    if (isset($_POST["email"]) && isset($_POST["pword"])) {
        $email = $_POST["email"];
        $pword = $_POST["pword"];
        $res = retrieve("SELECT uname, email, pswd FROM aar_users WHERE email = '$email' AND pswd = '$pword'");

        if (empty($res)) $not_registered = true;
        
        if (!empty($res)) {
            if ($email === $res[0]["email"] && $res[0]["uname"] === "admin") {
                $_SESSION["username"] = $res[0]["uname"];
                $_SESSION["admin"] = true;
                header("Location: ../AAR/admin.php");
                exit();
            }
            elseif (!$not_registered) {
                $_SESSION["username"] = $res[0]["uname"];
                header("Location: ../AAR/home.php");
                exit();
            }
        }
    }
}

?>

<?php include("../AAR/header.php"); ?>
<link rel="stylesheet" href="../AAR/assets/css/style.css">
<title>Log into your account - Recol</title>
</head>

<body id="login-body">
    <div class="container">
		<form id="form-signup" action="../AAR/login.php" method="POST" class="login-email">
			<p class="login-text">Log into your account</p>
			<div class="input-group">
				<label for="inputEmail">Email</label>
				<input id="inputEmail" type="email" placeholder="Email" name="email" required>
			</div>
			<div class="input-group" style="margin-top: 45px;">
				<label for="inputPassword">Password</label>
				<input id="inputPassword" type="password" placeholder="Password" name="pword" required>
			</div>
            <div class="input-group" style="padding-top: 19px; height: 1px">
                <?php if($not_registered) toError("<label> The data you inputted is incorrect.</label>");?>
			</div>
            <div class="input-group">
				<button name="login-submit" class="btn" type="submit">Log In</button>
			</div>
            
			
			<div class="login-register-text">
				<div style="text-align: left;">
					<label>Haven't got an account? <a href="../AAR/signup.php">Create one</a></label>
				</div>
				<div style="text-align: right;">
					<label><a href="../AAR/sign-up.php">Forgot password?</a></label>
				</div>
        	</div>
		</form>
	</div>

    <?php include("../AAR/footer.php"); ?>
    