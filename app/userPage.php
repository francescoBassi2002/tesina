
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"crossorigin="anonymous">

    <link href="./style/style.css" rel="stylesheet" type='text/css'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">

</head>
<body id="bigImg">
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


      

    <!-- Modal -->
    <div class="modal fade" id="becomeAdminModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-light" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-light">
            <form id="form" method="POST" action="./api/user/destroy_becomeAdmin.php">
              <label for="admin-psw">Admin psw</label>
              <input type="password" placeholder="••••••••" id="admin-psw" name="psw"></input>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary">Save changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>



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
        <div class="row" id="cards-events">

        </div>
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

      <li>
        <a href="userInfo.html" class="nav-link">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
          You
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
          src="http://localhost/esercizi/tesina/app/image/%img-src%"
          class="d-block w-100 carousel-img"
          alt="http://localhost/esercizi/tesina/app/image/%img-src%"
        />
        <div class="carousel-caption d-none d-md-block">
          <h5>%Title%</h5>
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
<script id="eventCard" type="text/html">
<?php require("components/event-card.php") ?>

</script>
<script src="script/jquery/jquery.js"  crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.bundle.js" crossorigin="anonymous"></script>


<script src="script/userPage.js"></script>



<!-- Button trigger modal -->



</body>
</html>