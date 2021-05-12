
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"crossorigin="anonymous">
    <link href="./style/style.css" rel="stylesheet" type='text/css'>

</head>
<body>
<?php 
  session_start();
  if (!isset($_SESSION["username"])){
    header("location: login.html");
  }

?>

<!-- Modal -->
<!-- Modal -->

<!-- _______________________________________ -->
  <div class="wrapper">
  <?php include "components/sidebar_content.php"?>

    <div class="container-fluid main text-light" >
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          
        </div>
        <div class="carousel-inner">
          
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <div class="main-content container-fluid">

      </div>
    </div>
  </div>


<script type="text/html" id="li_lista_desideri">
  <li class="nav-item" href="${url.origin}/esercizi/tesina/app/eventPage.html?event=${arrayObj[a][key]}">- %title%</li>

</script>



<script type="text/html" id="menu">
  <li class="nav-item">
        <a  href = "#" class="nav-link" id="home" onclick="whish_list()">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
          Wish list
        </a>
      </li>
      <li>
        <a href="index.html" class="nav-link">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
          Home
        </a>
      </li>
      
      <li>
        <a href="#" class="nav-link" onclick="logout()">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
          Log out
        </a>
      </li>
     

</script>

<script type="text/html" id="carousel-first-indicator"><!-- carousel first indicators -->
<button
      type="button"
      data-bs-target="#carouselExampleCaptions"
      data-bs-slide-to="%idx%"
      class="active"
      aria-current="true"
      aria-label="Slide %num_slide%"
    ></button>
</script>

<script type="text/html" id="carousel-indicator">  <!-- carousel indicators -->
<button
      type="button"
      data-bs-target="#carouselExampleCaptions"
      data-bs-slide-to="%idx%"
      aria-label="Slide %num_slide%"
    ></button>
</script>

<script type="text/html" id="carousel-item"> <!-- carousel item -->
  <div class="carousel-item %active%">
        <img
          src="image/%img-src%"
          class="d-block w-100 carousel-img"
          alt="..."
        />
        <div class="carousel-caption d-none d-md-block">
          <h5>%Title%</h5>
          <p>Some representative placeholder content for the first slide.</p>
        </div>
      </div>
  </script>
<script type="text/html" id="single-carousel">
<div
  id="carouselExampleCaptions"
  class="carousel slide"
  data-bs-ride="carousel"
>
  <div class="carousel-indicators">
    <!-- carousel indicators -->
  </div>
  <div class="carousel-inner">
    <!-- carousel items -->
  </div>
</div>

</script>
<script src="script/jquery.js"  crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.bundle.js" crossorigin="anonymous"></script>


<script src="script/userPage.js"></script>



<!-- Button trigger modal -->



</body>
</html>