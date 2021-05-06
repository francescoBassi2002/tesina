
<div class="d-flex flex-column p-3 text-white bg-dark" style="width: 280px; height: 100%;" id="sidebar" >
<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
    <span class="fs-4"><?php echo($_SESSION["name"]."'s ") ?>Menu</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto" id="sidebar_list">
    <!--SIDEBAR LIST -->
  </ul>
  <hr>
  <div class="dropdown" id="little-sidebar">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle me-2">
      <strong>mdo</strong>
    </a>
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
      <li><a class="dropdown-item" href="#">New project...</a></li>
      <li><a class="dropdown-item" href="#">Settings</a></li>
      <li><a class="dropdown-item" href="#">Profile</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item" href="#">Sign out</a></li>
    </ul>
  </div>

</div>
