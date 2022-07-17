<?php 
session_start();
require("../AAR/config.php");
if (!isset($_SESSION["username"])) {
    header("Location: ../AAR/login.php");
}
elseif (isset($_SESSION["username"]) && !isset($_SESSION["admin"])) {
    header("Location: ../AAR/home.php");
}

if (isset($_POST["save-change"])) {
    if (isset($_POST["nameEDIT"]) && isset($_POST["emailEDIT"])) {
        $name = $_POST["nameEDIT"];
        $email = $_POST["emailEDIT"];
        $id = $_POST["save-change"];
        query("UPDATE aar_users SET uname = '$name', email = '$email' WHERE uid = '$id'");
    }
}

if (isset($_POST["delete"])) {
    $delete = $_POST["delete"];
    query("DELETE FROM aar_users WHERE uid = $delete");
}

?>

<?php include("../AAR/header.php"); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<title>Admin's Page</title>
</head>

<body id="browse-body">
    <div class="container-fluid">
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Recol</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#my-navbar"">
                <span class=" navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="my-navbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <form action="../AAR/login.php" method="post">
                            <button class="btn btn-link" style="color: red" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container-fluid" style="margin-top: 8rem">
        <div class="row">
            <div class="col-12 text-center display-4" style="color: white; font-weight: 700">
                User List
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: 1rem">
        <div class="row">
            
            <div class="col-7"></div>
            <div class="col-4">
                <input class="form-control mr-2 w-50" type="search" placeholder="Search users..." id="search-input">
            </div>
            <div class="col-1"></div>
            <div class="col-2"></div>
            <div class="col-8" style="border-radius: 10px">

                <div class="container-fluid mt-3" style="border-radius: 10px; color: white;">
                    <div class="row p-2 bg-dark" style="height: 40px; border-radius: 10px 10px 0 0">

                        <div class="col-1">#</div>
                        <div class="col-3">Username</div>
                        <div class="col-3">Email</div>
                        <div class="col-2">Time</div>
                        <div class="col-1"></div>

                    </div>
                </div>

                <div id="itemList"></div>

            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            let itemList = document.getElementById("itemList");
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    itemList.innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "../AAR/ajax/users.php", true);
            xmlhttp.send();



            let search = document.getElementById("search-input");
            search.addEventListener("input", () => {
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        itemList.innerHTML = this.responseText;
                    }
                }
                xmlhttp.open("GET", "../AAR/ajax/users.php?keyword=" + search.value, true);
                xmlhttp.send();
            });



            let id, name, email;
            $(document).on("click", ".editbtn", function (id, name, email) {
                id = this.id.substring(4);
                name = document.getElementById("name" + id).innerHTML.trim();
                email = document.getElementById("email" + id).innerHTML.trim();

                document.getElementById("name" + id).innerHTML = "<input type='text' name='nameEDIT' maxlength='20' minlength='5' value='" + name + "'>";
                document.getElementById("email" + id).innerHTML = "<input type='email' name='emailEDIT' maxlength='40' minlength='5' value='" + email + "'>";
                document.getElementById("editcol" + id).innerHTML = "<button class='btn btn-link p-0' type='submit' name='save-change' value='" + id + "'>Save</button>";
            });
        </script>

        <?php include("../AAR/footer.php") ?>