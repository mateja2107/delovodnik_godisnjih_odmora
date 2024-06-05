<?php require "inc/header.php"; ?>

<?php
$user = loadPage();
// $user = ['username' => 'asd', 'id' => 1];
?>

<?php if ($user): ?>
  <?php require 'inc/nav.php'; ?>

  <div class="jumbotron text-center">
    <h1>Delovodnik Godisnjeg Odmora</h1>
    <p><i>Bečejpromet DOO</i>, Bečej</p>
    <button onclick="clearErrorBox()" type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">Unesi Novo Resenje</button>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-8 offset-2">
        <h2>Izaberi delovodnik:</h2>
        <div class="row">
          <div class="col-6">
            <select class="form-control mb-4" name="year" id="selectedYear">
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
        <h2>Sortiraj <span id="sortRescriptsByNumber" class="btn btn-sm btn-light ml-2">Po rednom broju</span></h2>
        <p>Po datumima unosa: <button class="btn btn-sm btn-light mr-2" id="sortRescriptsAZ">Od Najnovijeg</button><button id="sortRescriptsZA" class="btn btn-sm btn-light">Od Najstarijeg</button></p>
        <p>Uneo: 
          <select name="author" id="selectedAuthor" class="select_filter">
            <option value="*">-- Korisnik --</option>
            <?php
              $sql = "SELECT id, username, e_code FROM users;";

              $users = Connection::getData($sql);
            ?>
            <?php foreach($users as $usr): ?>
              <option value="<?php echo $usr['id']; ?>"><?php echo $usr['username'] . ' - ' . $usr['e_code']; ?></option>
            <?php endforeach; ?>
          </select>
        </p>
        
        <h2>Pretraga:</h2>
        <label for="home_search">Pretraga pomocu sifre, imena radnika ili broja resenja</label>
        <input type="text" name="home_search" id="homeSearch" class="form-control" placeholder="Unesite broj resenja, sifru ili ime radnika">
      </div>
    </div>
  </div>

  <div class="wrapper mt-5">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Br.</th>
          <th scope="col">Datum Unosa</th>
          <th scope="col">Br. Resenja</th>
          <th scope="col">God. Resenja</th>
          <th scope="col">Sifra Radnika</th>
          <th scope="col">Ime Radnika</th>
          <th scope="col">Br. Dana GO</th>
          <th scope="col">GO od:</th>
          <th scope="col">GO do:</th>
          <th scope="col">Uneo</th>
          <th scope="col">Izmenjeno</th>
        </tr>
      </thead>
      <tbody id="rescriptsTable">
        <!-- <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>Otto</td>
          <td>@mdo</td>
        </tr> -->
      </tbody>
    </table>
  </div>

  <?php require 'inc/modal.php'; ?>
<?php else: ?>
  <div class="alert alert-danger">Korisnik nije pronadjen</div>
<?php endif; ?>

<?php require "inc/footer.php"; ?>