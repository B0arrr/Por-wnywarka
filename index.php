<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Adrian Wałach, Patryk Gruszczyk, Jakub Bialikiewicz">
    <title>Strona testowa</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" i>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="./scripts/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"  ></script>
</head>

<body class="d-flex flex-column min-vh-100 bg-dark">

    <section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-dark bg-black">
            <a class="navbar-brand" href="#">Pórównywarka cen gier</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                    <a class="nav-link" href="javascript:void(0)" id="home">Home <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </section>

    <div class ="container">

        <?php
        require 'home/options.php';
        ?>
        <div class="row justify-content-center" id="Products">
        </div>
    </div>

    <footer class="page-footer font-small blue mt-auto">
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="index.php"> Pórowynwarkacengier</a>
        </div>
    </footer>

</body>
</html>