<?php
    include_once '../app/autoload.php';
    Database::init();

    $con = new Controller();
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul class="navbar-el">
                <li class="navbar-item"><a href="#" class="navbar-item_link"  onclick="imageFilter('all')">Все</a></li>
                <li class="navbar-item"><a href="#" class="navbar-item_link active" onclick="imageFilter('admin')">админ</a></li>
                <li class="navbar-item"><a href="#" class="navbar-item_link" onclick="imageFilter('not_admin')">не админ</a></li>
            </ul>
            <div class="search">
                <input type="search" id="search" >
                <button onclick="searchUser()" class="btn_find">Искать</button>
            </div>
        </nav>
    </header>

    <div class="publicity">
        <p>Publicity</p>
    </div>

    <div id="slide-container">
        <div id="slide-carousel">
           
        </div>
        <span id="next_btn" class="btn_search">>></span>
        <span id="prev_btn" class="btn_search"><<</span>
    </div>
    <div class="social_network">
        <a href="http://twitter.com/share?url=<?= $actual_link ?>" class="social">
            Twitter
        </a>

        <a href="http://www.facebook.com/sharer/sharer.php?u=<?= $actual_link ?>" class="social">
            Facebook
        </a>

        <a href="mailto:?subject=<SUBJECT>&body=<BODY>" class="social">
            Email
        </a>
    </div>
    <footer class="down">
        <div class="copy">&copy Copyright</div>
    </footer>

	<?php $con->jsParams(); ?>
    <script src="js/slide.js"></script>
</body>
</html>