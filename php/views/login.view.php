<?php require 'inc/header.php' ?>
  <?php 
    if(login()) {
      header("Location: /home");
    }
  ?>
  <div class="jumbotron text-center">
    <h1 class="display-4">Ulogujte Se</h1>
  </div>


  <div class="container">
    <div class="row">
      <div class="col-4 offset-4">
        <form class="form" id="loginForm">
          <input type="text" name="username" placeholder="korisnicko ime..." class="form-control mb-3">
          <input type="text" name="password" placeholder="lozinka..." class="form-control mb-3">
          <!-- <input type="checkbox" name="remember" class=" mb-3"> <span class="mb-3">Zapamti me</span> -->
          <button type="submit" class="mb-3 form-control btn btn-primary" id="loginBtn">ulogujte se</button>
        </form>
        <div id="login_errors"></div>
      </div>
    </div>
  </div>

<?php require 'inc/footer.php' ?>