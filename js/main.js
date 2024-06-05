let loginBtn = document.querySelector("#loginBtn");
if (loginBtn != null) loginBtn.onclick = (e) => login(e);

let addUserBtn = document.querySelector("#addUserBtn");
if (addUserBtn != null) addUserBtn.onclick = (e) => register(e);

let userListContainer = document.querySelector("#userList");
if (userListContainer != null) loadUsers();

let rescriptsTable = document.querySelector("#rescriptsTable");

let clearFormBtn = document.querySelector("#clearFormBtn");
if (clearFormBtn != null) {
  clearFormBtn.onclick = () =>
    clearForm(document.querySelector("#createUserForm"));
}

let saveRescriptBtn = document.querySelector("#submitRescriptButton");
if (saveRescriptBtn != null) saveRescriptBtn.onclick = (e) => saveRescript(e);

let clearRescriptFormBtn = document.querySelector("#clearRescriptForm");
if (clearRescriptFormBtn != null) {
  clearRescriptFormBtn.onclick = (e) => {
    clearRescriptForm(document.querySelector("#addEditRescript"));

    if (window.location.href.toString().includes("/stats")) {
      document.querySelector("#closeModalBtn").click();
      alert("Ako zelite da dodate novo resenje predjite na pocetnu stranicu.");
    }
  };
}

let calculateDaysButton = document.querySelector("#calculateDaysButton");
if (calculateDaysButton != null) {
  calculateDaysButton.onclick = (e) => {
    let from = document.querySelector(`input[name="from_date"]`).value;
    let to = document.querySelector(`input[name="to_date"]`).value;

    if (from != "" && to != "") {
      document.querySelector(`input[name="days_number"`).value =
        calculateWorkDays(from, to);
    }
  };
}

let selectedYear = document.querySelector("#selectedYear");
if (selectedYear != null) {
  selectedYear.onchange = (e) => loadRescripts("", "", "date", e.target.value);
}

let sortRescriptsAZ = document.querySelector("#sortRescriptsAZ");
if (sortRescriptsAZ != null) {
  sortRescriptsAZ.onclick = (e) =>
    loadRescripts("A-Z", "", "date", selectedYear.value);
}

let sortRescriptsZA = document.querySelector("#sortRescriptsZA");
if (sortRescriptsZA != null) {
  sortRescriptsZA.onclick = (e) => {
    loadRescripts("Z-A", "", "date", selectedYear.value);
  };
}

let selectedAuthor = document.querySelector("#selectedAuthor");
if (selectedAuthor != null) {
  selectedAuthor.onchange = (e) =>
    loadRescripts("author", e.target.value, "date", selectedYear.value);
}

let searchButton = document.querySelector("#searchButton");
if (searchButton != null) {
  searchButton.onclick = (e) => {
    e.preventDefault();
    loadStats();
  };
}

let homeSearch = document.querySelector("#homeSearch");
if (homeSearch != null) {
  homeSearch.oninput = (e) => {
    if (selectedYear.value != "") {
      loadRescripts("", "", "date", selectedYear.value, homeSearch.value);
    } else {
      alert("Morate odabrati delovodnik!");
      selectedYear.focus();
    }
  };
}

let sortBtn = document.querySelector("#sortRescriptsByNumber");
if (sortBtn != null) {
  sortBtn.onclick = (e) => {
    loadRescripts("", "", "date", selectedYear.value);
  };
}

let selYear = document.querySelector("#selectedYear_old");
if (selYear != null) {
  selYear.onchange = (e) => {
    if (selYear.value != "") {
      loadOldRescripts(selYear.value);
    }
  };
}

let searchOldRescripts = document.querySelector("#searchOldRescripts");
if (searchOldRescripts != null) {
  searchOldRescripts.oninput = (e) => {
    console.log(selYear.value);

    if (selYear.value != "") {
      loadOldRescripts(selYear.value, searchOldRescripts.value);
    } else {
      alert("Morate odabrati delovodnik!");
      selYear.focus();
    }
  };
}
