<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Adrian Wałach, Patryk Gruszczyk, Jakub Bialikiewicz">
    <title>Strona testowa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" i>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"  ></script>
</head>

<body>

        <section id="nav-bar">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Pórównywarka cen gier</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Signup</a>
      </li>
     
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Kategorie
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">MilF</a>
          <a class="dropdown-item" href="#">RPG</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
 </section>
        <div class ="container">
        <div class="row">
              <div class="col-md-2 mb-2">
               
                <select class="custom-select d-block w-100" id="Kategoria" required>
                  <option value="">Kategoria...</option>
                  <option>RPG</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid category.
                </div>
              </div>
              <div class="col-md-2 mb-2">
                
                <select class="custom-select d-block w-100" id="producent" required>
                  <option value="">Producent...</option>
                  <option>Producent1</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid producent.
                </div>
              </div>
              <div class="col-md-2 mb-2">
               
                <select class="custom-select d-block w-100" id="sklep" required>
                  <option value="">Sklep...</option>
                  <option>Sklep1</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid sklep.
                </div>
              </div>
            <div class="col-md-4 mb-2">
                <form class="form-inline">                
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    <button type="button" class="btn btn-secondary">Search</button>
  </form>
            </div>
            </div>
        
        <div class="row justify-content-center">
           
		   <?php
            require 'test3.php';
            ?>
		   
        </div>
    </div>
    
<footer class="page-footer font-small blue">
 
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href=""> Pórowynwarkacengier</a>
  </div>
</footer>

    <script src="script.js"></script>
</body>
</html>
