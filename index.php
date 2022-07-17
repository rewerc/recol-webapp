<?php include("header.php"); ?>
<link rel="stylesheet" href="assets/css/indexs.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<title>Recol - Collect, manage, and share your recipe here</title>
</head>

<body>
    <div class="container-fluid first-page">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="#">Recol</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#expandnavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse " id="expandnavbar">
                        <form class="form-inline my-2 my-lg-0 ml-auto">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search a dish..."
                                aria-label="Search">
                            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="assets/images/carousel1.png" class="d-block w-100 carouselcontent" alt="food1">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/images/carousel2.png" class="d-block w-100 carouselcontent" alt="food2">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/images/carousel3.png" class="d-block w-100 carouselcontent" alt="food3">
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-6 right-header">
                <h1 class="page-header">Collect, share, and manage your recipes.</h1>

                <a href="../AAR/signup.php" class="btn btn-success">Sign me up!</a>
                <a href="../AAR/login.php" class="btn btn-outline-light">Login</a>
            </div>

        </div>
    </div>

<?php include("footer.php"); ?>