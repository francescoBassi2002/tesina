
<div class="d-flex flex-column p-3 text-white" style="width: 280px; height: 100%;" id="sidebar" >
<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
    <span class="fs-4"><?php echo ucwords($_SESSION["name"]."'s ") ?>Menu</span>
  </a>
  <hr>
  <div class="user-info-sidebar" style="display:flex;">
    <div class="user-img"><img src="image/user.svg" class="img-fluid"></div>
    <div class="user-info">
      <h6><?php echo ucwords($_SESSION["username"])?></h6>
      <p class="text-light admin" style="font-size: 10px;"><?php echo ($_SESSION["admin"] == true ? "Administrator" : "User")?></p>
      <p class="text-success" style="font-size: 9px; margin-top: 4px;">Online •</p>
      </div>
  </div>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto" id="sidebar_list">
    <!--SIDEBAR LIST -->
  </ul>
  
  

</div>
