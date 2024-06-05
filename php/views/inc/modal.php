 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Unos/Izmena Resenja</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="addEditRescript">
            <input type="text" id="rescriptNumberID" name="id" class="form-control mb-3" disabled>

            <label for="number">Redni Br. Resenja:</label>
            <input type="text" name="number" placeholder="Redni broj resenja" class="form-control mb-3">

            <label for="rescript_id">Broj Resenja:</label>
            <input type="text" name="rescript_id" placeholder="Broj resenja" class="form-control mb-3">

            <label for="rescript_year">Godina Resenja:</label>
            <input type="text" name="rescript_year" placeholder="Godina resenja" class="form-control mb-3">

            <label for="e_code">Sifra Radnika:</label>
            <input type="text" name="e_code" placeholder="Sifra radnika" class="form-control mb-3">

            <label for="e_name">Ime Radnika:</label>
            <input type="text" name="e_name" placeholder="Ime radnika" class="form-control mb-3">

            <label for="from_date">Prvi dan GO (mesec / dan / godina):</label>
            <input type="date" name="from_date" class="form-control mb-3">

            <label for="to_date">Poslednji dan GO (mesec / dan / godina):</label>
            <input type="date" name="to_date" class="form-control mb-3">

            <label for="days_number">Broj dana GO: <span class="btn btn-sm btn-info" id="calculateDaysButton">Izracunaj <b>BEZ PRAZNIKA</b></span></label>
            <input type="text" name="days_number" class="form-control mb-3">

            <button type="submit" id="submitRescriptButton" class="btn btn-primary form-control mb-3">Dodaj Resenje</button>
            <button type="button" class="btn btn-secondary mb-3" id="clearRescriptForm">Ocisti polja</button>
          </form>
          <div id="saveRescriptErrors"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="closeModalBtn" data-dismiss="modal">Zatvori</button>
        </div>
      </div>
    </div>
  </div>