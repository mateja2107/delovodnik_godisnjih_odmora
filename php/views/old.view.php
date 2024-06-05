<?php require 'inc/header.php'; ?>
<?php $user = loadPage(); ?>

<?php if($user['status'] == 'admin'): ?>
  <?php require 'inc/nav.php'; ?>

  <div class="jumbotron">
    <h1 class="text-center">Izmenjena Resenja</h1>

    <div class="container mt-4">
      <div class="row">
        <div class="col-6 offset-3">
          <label for="year">Izaberi godinu delovodnika</label>
          <select class="form-control mb-4" name="year" id="selectedYear_old">
            <option value="">-- Izaberi Godinu --</option>
            <?php
              $sql = "SELECT from_date FROM rescripts";

              $dates = Connection::getData($sql);
              
              $years = [];
              foreach($dates as $date) {
                $date = $date['from_date'];
                $date = substr($date, 0, 4);

                if(!in_array($date, $years)) {
                  $years[] = $date;
                }
              }
            ?>
            <?php foreach($years as $date): ?>
              <option value="<?= $date; ?>"><?= $date; ?></option>
            <?php endforeach; ?>
          </select> 
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-6 offset-3">
        <label for="search">Pretrazite pomocu broja resenja</label>
        <input type="text" name="search" placeholder="Unesite broj resenja" id="searchOldRescripts" class="form-control mb-3">
      </div>
    </div>
  </div>
  <div class="wrapper" id="old_rescripts">

  </div>

<?php else: ?>
  <?php header("Location: /home"); ?>
<?php endif; ?>

<?php require 'inc/footer.php'; ?>