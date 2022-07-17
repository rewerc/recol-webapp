<?php 
    session_start(); 
    require("../AAR/config.php");
    if (!isset($_SESSION["username"])) {
        header("Location: ../AAR/login.php");
        exit();
    }

    if (isset($_POST["delete"])) {
        $del = $_POST["delete"];
        query("DELETE FROM recipe WHERE id = $del");
    }

    if (isset($_POST["update"])) {
      $id = $_POST["update"];
      $name = $_POST["update-name"];
      $desc = join("`", explode("\n", $_POST["update-desc"]));
      $ingr = join("`", explode("\n", $_POST["update-ingr"]));
      $inst = join("`", explode("\n", $_POST["update-inst"]));

      query("UPDATE recipe SET 
            name = '$name', 
            description = '$desc', 
            ingredients = '$ingr', 
            instructions = '$inst'
            WHERE id = $id");
    }

    $username = $_SESSION['username'];

    $recipes = retrieve("SELECT id, name, description, uploader, photoloc
                        FROM recipe WHERE uploader = '$username' ORDER BY name");
?>

<?php include("../AAR/header.php"); ?>
   <link rel="stylesheet" href="../AAR/assets/css/style2.css">
   <title>Browse for new recipes!</title>
   <link rel="icon" href=".../AAR/assets/images/favicon.ico">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body id="browse-body">
   <header class="header">
      <nav class="navbar">
         <a href="#" class="nav-logo">Recol</a>
         <ul class="nav-menu">
            <li class="nav-item">
               <a href="#date" class="nav-link active" id="date"></a>
            </li>
            <div class="dropdown">
               <button href="#" class="dropbtn">
                  <span id="username">
                     <?= $username ?>
                  </span>
                  <i class="fa fa-caret-down"></i>
               </button>
               <div class="dropdown-content">
                  <form action="../AAR/login.php" method="post">
                     <button type="submit" class="btn-link" name="logout">Logout</button>
                  </form>
               </div>
            </div>
            </li>
            <li class="nav-item">
               <a href="../AAR/home.php" class="nav-link">My Collection</a>
            </li>
            <li class="nav-item">
               <a href="" class="nav-link active">Browse</a>
            </li>
         </ul>
         <div class="hamburger">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
         </div>
      </nav>
   </header>

   <div class="mysearchbar">
      <div>
         <div>
            <h1 style="color: white; font-size:3.5rem; font-weight: 400;">
               Find new recipes
            </h1>
         </div>
         <div>
            <form>
               <input class="searchBox" type="search" placeholder="Search collection..." aria-label="Search"
                  id="search-input">
            </form>
         </div>
         <a href="#" title="Add dish..." data-target="#addDish" class="add-btn"
            onclick="document.getElementById('id01').style.display='block'">+</a>
         <?php include("../AAR/create-recipe.php"); ?>
      </div>
      <div class="">
         <div class="">
         </div>
      </div>
   </div>

   <div class="new_recipecard">
      <div id="recipe-cards">
         <!-- Ajax loaded content from recipecards.php -->
      </div>
   </div>

   <div id="dish-content" data-keyboard="false">
      <div>
         <div id="modal-content">
            <div id="id02" class="modal">
               <!-- Ajax loaded content from getrecipe.php -->
            </div>
         </div>
      </div>
   </div>

   <script src="../AAR/browse.js" type="text/javascript"></script>
</body>

</html>