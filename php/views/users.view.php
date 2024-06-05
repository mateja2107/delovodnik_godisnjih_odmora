<?php require 'inc/header.php'; ?>
<?php
  $user = loadPage();
?>

<?php if ($user['status'] == 'admin'): ?>
  <?php require 'inc/nav.php'; ?>

  <div class="jumbotron">
    <h1 class="text-center">Rad sa korisnicima</h1>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-5">
        <h2>Unos korisnika: </h2>
        <form class="form" id="createUserForm">
          <input type="text" id="hiddenInput" name="id" class="form-control mb-3" disabled>
          <input type="text" name="username" placeholder="Korisniko ime" class="form-control mb-3">
          <input type="text" name="password" placeholder="Lozinka" class="form-control mb-3">
          <input type="text" name="e_code" placeholder="Sifra radnika" class="form-control mb-3">
          <select name="status" class="form-control mb-3">
            <option value="user">Radnik</option>
            <option value="admin">Administrator</option>
          </select>
          <button type="submit" class="form-control btn btn-primary mb-3" id="addUserBtn">Dodaj korisnika</button>
        </form>
        <button type="button" id="clearFormBtn" class="btn btn-secondary mb-3">Ocisti sva polja</button>
        <div id="register_errors"></div>
      </div>
      <div class="col-7">
        <h2>Svi korisnici: </h2>
        <div id="userList"></div>
      </div>
    </div>
  </div>
<?php else: ?>
  <!-- <div class="alert alert-danger">Korisnik nije pronadjen</div> -->
  <?php header("Location: /home"); ?>
<?php endif; ?>


<?php require 'inc/footer.php'; ?>