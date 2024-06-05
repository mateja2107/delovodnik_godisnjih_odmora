<?php require "inc/header.php"; ?>
<?php $user = loadPage(); ?>

<?php if($user): ?>
  <?php require "inc/nav.php"; ?>

  <div class="jumbotron text-center">
    <h1 class="mb-3">Izvestaji</h1>

    <div class="container">
      <div class="row">
        <div class="col-6 offset-3">
          <form id="searchForm">
            <label for="e_code">Sifra Radnika:</label>
            <input type="text" name="e_code" placeholder="Unesite Sifru radnika..." class="form-control mb-3">
            
            <button type="submit" id="searchButton" class="btn btn-sm btn-success mb-3 form-control">Pretrazi</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="wrapper mt-5" id="employee_stats"></div>

  <?php require 'inc/modal.php'; ?>
<?php else: ?>
  <?php header("Location: /"); ?>
<?php endif; ?>
<?php require "inc/footer.php"; ?>