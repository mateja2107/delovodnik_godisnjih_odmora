function login(e) {
  e.preventDefault();

  let form = document.querySelector("#loginForm");

  let formData = new FormData(form);
  let data = {};

  formData.forEach((value, name) => {
    data[name] = value;
  });

  let errors = [];

  for (let [key, value] of Object.entries(data)) {
    value = value.trim();

    if (
      value === "" &&
      !errors.some((el) => el === "Polje ne moze biti prazno.")
    ) {
      errors.push("Polje ne moze biti prazno.");
    }

    let specialCharacters = /[^\w\s]/;
    let emailRegex =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let HTMLTagRegex = /<\/?[\w\s]*>|<.+[\W]>/;

    // filter HTML tags
    if (HTMLTagRegex.test(value)) errors.push("Cannot submit html tags.");

    // validate username or email
    if (key === "username") {
      if (value.length < 3)
        errors.push("Korisnicko ime mora sadrzati najmanje 3 karaktera.");
      if (value.includes(" "))
        errors.push("Korisnicko ime ne moze sadrzati razmak.");

      if (specialCharacters.test(value))
        errors.push(
          "Korisnicko ime ne moze sadrzati ni jedan specijalni karakter osim _."
        );
    }

    if (key === "password") {
      // validate password
      if (value.includes(" ")) errors.push("Lozinka ne moze sadrzati razmak.");
      if (value.length < 3)
        errors.push("Lozinka mora sadrzati najmanje 5 karaktera.");
    }
  }

  // errors = [];
  let errorContainer = document.querySelector("#login_errors");
  errorContainer.innerHTML = "";
  if (errors.length > 0) {
    errors.forEach((err) => {
      errorContainer.innerHTML += `<div class="alert alert-danger" role="alert">${err}</div>`;
    });
  } else {
    loginUser(data);
  }
}

async function loginUser(data) {
  data = JSON.stringify(data);

  let res = await fetch("/login", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  });
  res = await res.json();

  let errorContainer = document.querySelector("#login_errors");
  if (res?.errors) {
    if (errorContainer.innerHTML === "" && res.errors.length > 0) {
      res.errors.forEach((err) => {
        errorContainer.innerHTML += `<div class="alert alert-danger" role="alert">${err}</div>`;
      });
    }
  } else if (res?.success) window.location.href = "/home";
}

function register(e) {
  e.preventDefault();

  let form = document.querySelector("#createUserForm");

  let formData = new FormData(form);
  let data = {};

  formData.forEach((value, name) => {
    if (name != "id") {
      data[name] = value;
    }
  });
  let errors = [];

  for (let [key, value] of Object.entries(data)) {
    // trim the value "  asd " = "asd";
    value = value.trim();

    // check if all inputs are filled
    if (
      value === "" &&
      !errors.some((el) => el === "Sva polja moraju biti popunjena.")
    ) {
      errors.push("Sva polja moraju biti popunjena.");
    }

    let numbers = /\d/;
    let letters = /[a-zA-Z]/;
    let specialCharacters = /[^\w\s]/;
    let emailRegex =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let HTMLTagRegex = /<\/?[\w\s]*>|<.+[\W]>/;

    // filter HTML tags
    if (HTMLTagRegex.test(value)) errors.push("Cannot submit html tags.");

    // validate status
    if (key === "status") {
      if (value != "user" && value != "admin")
        errors.push("Korisnik mora biti radnik ili administrator.");
    }

    // validate username
    if (key === "username") {
      if (value.includes(" "))
        errors.push(`Korisnicko ime ne moze sadrzati razmake.`);
      if (value.length < 3) {
        errors.push(`Korisnicko ime mora sadrzati 3 ili vise karaktera.`);
      }

      // all special characters except _
      let validateUsernameRegex = /[^\w\s_]/;
      if (validateUsernameRegex.test(value))
        errors.push(
          "Korisnicko ime ne moze sadrzati ni jedan specijalni karakter sem _"
        );
    }

    // validate password
    if (key === "password") {
      if (value.includes(" "))
        errors.push("Lozinka ne moze da sadrzi razmake.");
      if (value.length < 5)
        errors.push("Lozinka mora sadrzati 5 ili vise karaktera.");
    }

    // validate e_code
    if (key === "e_code") {
      if (value.includes(" ")) {
        errors.push("Sifra radnika ne moze sadrzati razmake.");
      }
      if (value.length > 4) {
        errors.push("Sifra radnika ne moze imati vise od 4 cifre.");
      }
      if (letters.test(value)) {
        errors.push("Sifra radnika ne moze da sadrzi slova.");
      }
      if (specialCharacters.test(value)) {
        errors.push("Sifra radnika ne moze da sadrzi specijalne karaktere");
      }
    }
  }

  // errors = [];
  let errorContainer = document.querySelector("#register_errors");
  errorContainer.innerHTML = "";
  if (errors.length > 0) {
    errors.forEach((err) => {
      errorContainer.innerHTML += `<div class="alert alert-danger" role="alert">${err}</div>`;
    });
  } else {
    let disabledInput = document.querySelector("#hiddenInput");

    if (disabledInput.value === "") {
      registerUser(data);
    } else {
      editUser(disabledInput.value, data);
    }
  }
}

async function registerUser(data) {
  data = JSON.stringify(data);

  let res = await fetch("/register", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  });
  res = await res.json();

  let errorContainer = document.querySelector("#register_errors");
  if (res?.errors) {
    if (errorContainer.innerHTML === "" && res.errors.length > 0) {
      res.errors.forEach((err) => {
        errorContainer.innerHTML += `<div class="alert alert-danger" role="alert">${err}</div>`;
      });
    }
  }

  if (res?.success) {
    errorContainer.innerHTML = `<div class="alert alert-success" role="alert">Uspesno ste dodali korisnika.</div>`;

    clearForm(document.querySelector("#createUserForm"));
    loadUsers();
  }
}

async function loadUsers() {
  let res = await fetch("/get_users?action=get_all_users");

  let users = await res.json();

  let html = ``;
  users.forEach((user) => {
    html += `
    <div class="user-container">
      <span>${user.username} - <i>${user.e_code}</i></span>
      <div>
        <button class="btn btn-sm btn-info" onclick="fillForm(${user.id})">Izmeni</button>
        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">Obrisi</button>
      </div>
    </div>
    `;
  });

  document.querySelector("#userList").innerHTML = html;
}

function clearForm(form) {
  form.querySelector(`input[name="username"]`).value = "";
  form.querySelector(`input[name="password"]`).value = "";
  form.querySelector(`input[name="e_code"]`).value = "";
  form.querySelector(`input[name="id"]`).value = "";
  form.querySelector("button").textContent = "Dodaj korisnika";
}

async function fillForm(id) {
  let form = document.querySelector("#createUserForm");
  let usernameInput = form.querySelector(`input[name="username"]`);
  let ecodeInput = form.querySelector(`input[name="e_code"]`);
  let status = form.querySelector(`select[name="status"]`);
  let idInput = form.querySelector(`input[name="id"]`);
  let btn = form.querySelector("button");

  let user = await getUser(id);

  usernameInput.value = user.username;
  ecodeInput.value = user.e_code;
  status.value = user.status;
  idInput.value = user.id;
  btn.textContent = "Izmeni korisnika";
}

async function editUser(id, data) {
  let user = {
    id: id,
    data: data,
  };

  user = JSON.stringify(user);

  let res = await fetch("/edit_user?action=edit_user", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: user,
  });
  res = await res.json();

  let errorContainer = document.querySelector("#register_errors");
  if (res?.errors) {
    if (errorContainer.innerHTML === "" && res.errors.length > 0) {
      res.errors.forEach((err) => {
        errorContainer.innerHTML += `<div class="alert alert-danger" role="alert">${err}</div>`;
      });
    }
  }

  if (res?.success) {
    errorContainer.innerHTML = `<div class="alert alert-success" role="alert">Uspesno ste izmenuli korisnika.</div>`;

    clearForm(document.querySelector("#createUserForm"));
    loadUsers();
  }
}

async function deleteUser(id) {
  if (confirm("Da li ste sigurni da zelite da obrisete korisnika?")) {
    let data = { id: id };
    data = JSON.stringify(data);

    let res = await fetch("/delete_user?action=delete", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: data,
    });

    res = await res.json();

    if (res?.success) {
      alert("Uspesno ste obrisali korisnika");

      loadUsers();
    } else {
      alert(res.errors);
    }
  }
}

async function getUser(id) {
  let data = { id: id };
  data = JSON.stringify(data);

  let res = await fetch("/get_users?action=get_user", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  });

  res = await res.json();
  return res[0];
}

// Function to calculate work days between two dates
function calculateWorkDays(start, end) {
  let workDays = 0;
  let currentDate = new Date(start);
  end = new Date(end);

  // Iterate from start date to end date
  while (currentDate <= end) {
    const dayOfWeek = currentDate.getDay();
    // Check if the current day is a weekday (Monday to Friday)
    if (dayOfWeek >= 1 && dayOfWeek <= 5) {
      workDays++;
    }
    // Move to the next day
    currentDate.setDate(currentDate.getDate() + 1);
  }

  return workDays;
}

function formatDateTime(inputDate) {
  const date = new Date(inputDate);

  // Get the individual components of the date
  const day = String(date.getDate()).padStart(2, "0");
  const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are zero-based
  const year = date.getFullYear();

  // Get the individual components of the time
  const hours = String(date.getHours()).padStart(2, "0");
  const minutes = String(date.getMinutes()).padStart(2, "0");
  const seconds = String(date.getSeconds()).padStart(2, "0");

  // Format the date and time
  const formattedDate = `${day}.${month}.${year} - ${hours}:${minutes}`;

  return formattedDate;
}

function formatDate(dateString) {
  // Split the input date string into its components
  const [year, month, day] = dateString.split("-");

  // Reformat the date components into d-m-Y format
  const formattedDate = `${day}.${month}.${year}`;

  return formattedDate;
}

function isValidDate(dateString) {
  // Attempt to create a new Date object from the input string
  const date = new Date(dateString);

  // Check if the new Date object is invalid (NaN) or if the input string does not match the expected format
  return !isNaN(date) && dateString === date.toISOString().slice(0, 10);
}

function isDateBefore(date1, date2) {
  // Convert date strings to Date objects
  const d1 = new Date(date1);
  const d2 = new Date(date2);

  // Compare the getTime() values of the Date objects
  return d1.getTime() <= d2.getTime();
}

function sortByDateAscending(data, dateProperty) {
  return data.sort((a, b) => {
    const dateA = new Date(a[dateProperty]);
    const dateB = new Date(b[dateProperty]);
    return dateA - dateB;
  });
}

function sortByDateDescending(data, dateProperty) {
  return data.sort((a, b) => {
    const dateA = new Date(a[dateProperty]);
    const dateB = new Date(b[dateProperty]);
    return dateB - dateA;
  });
}

async function loadRescripts(
  order = "",
  selectedAuthor = "",
  date,
  selectedDate,
  search = ""
) {
  if (date == "date") {
    if (selectedDate != "" && Number(selectedDate) < 9999) {
      let data = { date: selectedDate };
      data = JSON.stringify(data);

      let rescripts = await fetch("/get_rescripts?action=get_all_rescripts", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: data,
      });

      rescripts = await rescripts.json();

      if (!rescripts?.errors) {
        let html = ``;

        if (order == "author") {
          if (selectedAuthor != "*") {
            rescripts = rescripts.filter((el) => el.author == selectedAuthor);
          }
        }

        let HTMLTagRegex = /<\/?[\w\s]*>|<.+[\W]>/;
        if (search != "" && !HTMLTagRegex.test(search)) {
          rescripts = rescripts.filter(
            (el) =>
              el.e_code == search ||
              el.e_name.toLowerCase().includes(search.toLocaleLowerCase()) ||
              el.rescript_id.includes(search)
          );
        }

        rescripts = rescripts.sort((a, b) => a.number - b.number);

        if (order == "A-Z") {
          rescripts = sortByDateDescending(rescripts, "created_at");
        } else if (order == "Z-A") {
          rescripts = sortByDateAscending(rescripts, "created_at");
        }

        for (let rescript of rescripts) {
          let user = await getUsername(rescript.author);
          if (!user) {
            user = "Obrisan korisnik";
          } else user = `${user.username} - ${user.e_code}`;

          let edited_at = "-";
          if (rescript.edited_at != null) {
            edited_at = formatDateTime(rescript.edited_at);
          }

          html += `
          <tr onclick="fillRescriptForm(${
            rescript.id
          })" data-toggle="modal" data-target="#exampleModal">
            <th scope="row">${rescript.number}.</th>
            <td>${formatDateTime(rescript.created_at)}</td>
            <td>${rescript.rescript_id}</td>
            <td>${rescript.rescript_year}</td>
            <td>${rescript.e_code}</td>
            <td>${rescript.e_name}</td>
            <td>${rescript.days_number}</td>
            <td>${formatDate(rescript.from_date)}</td>
            <td>${formatDate(rescript.to_date)}</td>
            <td>${user}</td>
            <td>${edited_at}</td>
          </tr>
          `;
        }

        document.querySelector("#rescriptsTable").innerHTML = html;
      }
    } else {
      document.querySelector("#rescriptsTable").innerHTML = "";
    }
  }
}

function saveRescript(e) {
  e.preventDefault();

  let form = document.querySelector("#addEditRescript");

  let formData = new FormData(form);
  let data = {};

  formData.forEach((value, name) => {
    data[name] = value;
  });

  let errors = [];

  for (let [key, value] of Object.entries(data)) {
    value = value.trim();

    if (
      value === "" &&
      !errors.some((el) => el === "Polje ne moze biti prazno.")
    ) {
      errors.push("Polje ne moze biti prazno.");
    }

    let numbers = /\d/;
    let letters = /[a-zA-Z]/;
    let specialCharacters = /[^\w\s]/;
    let emailRegex =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let HTMLTagRegex = /<\/?[\w\s]*>|<.+[\W]>/;

    // filter HTML tags
    if (HTMLTagRegex.test(value)) errors.push("Cannot submit html tags.");

    if (key === "number") {
      if (!numbers.test(value)) {
        errors.push("Redni broj resenja mora sadrzati cifre.");
      }
      if (Number(value) < 1) {
        errors.push("Redni broj n € N");
      }
      if (letters.test(value)) {
        errors.push("Redni broj resenja ne moze sadrzati slova.");
      }
      if (value.includes(" ")) {
        errors.push("Redni broj resenja ne moze da sadrzi razmak.");
      }
    }

    if (key === "rescript_id") {
      if (value.length > 10) {
        errors.push("Broj resenja ne moze biti duzi od 10 karaktera");
      }
      if (!numbers.test(value)) {
        errors.push("Broj resenja mora sadrzati cifre.");
      }
      if (letters.test(value)) {
        errors.push("Broj resenja ne moze sadrzati slova.");
      }
      if (value.includes(" ")) {
        errors.push("Broj resenja ne moze da sadrzi razmak.");
      }
      if (!value.includes("-")) {
        errors.push("Broj resenja mora sadrzati -");
      }
    }

    if (key === "rescript_year") {
      if (value.length != 4) {
        errors.push("Godina resenja moze sadrzati samo 4 cifre.");
      }
      if (!numbers.test(value)) {
        errors.push("Godina resenja mora sadrzati cifre.");
      }
      if (letters.test(value)) {
        errors.push("Godina resenja ne moze sadrzati slova.");
      }
      if (value.includes(" ")) {
        errors.push("Godina resenja ne moze da sadrzi razmak.");
      }
    }

    if (key === "e_code") {
      if (value.includes(" ")) {
        errors.push("Sifra radnika ne moze da sadrzi razmake.");
      }
      if (value.length > 4) {
        errors.push("Sifra radnika ne moze da sadrzi vise od 4 cifre");
      }
      if (letters.test(value)) {
        errors.push("Sifra radnika ne moze da sadrzi slova.");
      }
      if (specialCharacters.test(value)) {
        errors.push("Sifra radnika ne moze da sadrzi specijalne karaktere.");
      }
    }

    if (key === "e_name") {
      if (numbers.test(value)) {
        errors.push("Ime radnika ne moze da sadrzi brojeve.");
      }
      if (specialCharacters.test(value)) {
        errors.push("Ime radnika ne moze da sadrzi specijalne karaktere.");
      }
      if (!value.includes(" ")) {
        errors.push("Ime radnika mora sadrzati jedan razmak.");
      }
    }

    if (key === "from_date" || key === "to_date") {
      if (
        !isValidDate(value) &&
        !errors.some((el) => el === "Datum nije validan.")
      ) {
        errors.push("Datum nije validan.");
      }
    }
  }

  if (!isDateBefore(data["from_date"], data["to_date"])) {
    errors.push(
      "Obratite paznju na format datuma kad ga upisujete. mesec / dan / godina"
    );
  }

  // errors = [];
  let errorContainer = document.querySelector("#saveRescriptErrors");
  errorContainer.innerHTML = "";
  if (errors.length > 0) {
    errors.forEach((err) => {
      errorContainer.innerHTML += `<div class="alert alert-danger" role="alert">${err}</div>`;
    });
  } else {
    let disabledInput = form.querySelector("#rescriptNumberID");

    if (disabledInput.value === "") {
      addNewRescript(data);
    } else {
      editRescript(disabledInput.value, data);
    }
  }
}

async function addNewRescript(data) {
  data = JSON.stringify(data);

  let res = await fetch("/create_rescript?action=create_new_rescript", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  });

  res = await res.json();

  let errorContainer = document.querySelector("#saveRescriptErrors");
  if (res?.errors) {
    if (errorContainer.innerHTML === "" && res.errors.length > 0) {
      res.errors.forEach((err) => {
        errorContainer.innerHTML += `<div class="alert alert-danger" role="alert">${err}</div>`;
      });
    }
  }

  if (res?.success) {
    errorContainer.innerHTML = `<div class="alert alert-success" role="alert">Uspesno ste dodali resenje.</div>`;

    // clearRescriptForm(document.querySelector("#addEditRescript"));
    loadRescripts(
      "",
      "",
      "date",
      document.querySelector("#selectedYear").value
    );
  }
}

async function editRescript(id, data) {
  data = {
    data: data,
    id: id,
  };
  data = JSON.stringify(data);

  let res = await fetch("/edit_rescript?action=edit_one_rescript", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  });

  res = await res.json();

  let errorContainer = document.querySelector("#saveRescriptErrors");
  if (res?.errors) {
    if (errorContainer.innerHTML === "" && res.errors.length > 0) {
      res.errors.forEach((err) => {
        errorContainer.innerHTML += `<div class="alert alert-danger" role="alert">${err}</div>`;
      });
    }
  }

  if (res?.success) {
    // errorContainer.innerHTML = `<div class="alert alert-success" role="alert">Uspesno ste izmenuli resenje.</div>`;

    clearRescriptForm(document.querySelector("#addEditRescript"));
    loadRescripts(
      "",
      "",
      "date",
      document.querySelector("#selectedYear").value
    );
    alert("Uspesno ste izmenuli resenje.");
    document.querySelector("#closeModalBtn").click();
  }
}

function clearRescriptForm(form) {
  form.querySelector("#rescriptNumberID").value = "";
  form.querySelector(`input[name="number"]`).value = "";
  form.querySelector(`input[name="rescript_id"]`).value = "";
  form.querySelector(`input[name="rescript_year"]`).value = "";
  form.querySelector(`input[name="e_code"]`).value = "";
  form.querySelector(`input[name="e_name"]`).value = "";
  form.querySelector(`input[name="from_date"]`).value = "";
  form.querySelector(`input[name="to_date"]`).value = "";
  form.querySelector(`input[name="days_number"]`).value = "";
  form.querySelector(`#submitRescriptButton`).textContent = "Dodaj Resenje";
}

async function fillRescriptForm(id) {
  let form = document.querySelector("#addEditRescript");

  let rescript = await getRescript(id);

  if (rescript?.errors) {
    alert(rescript.errors);
    setTimeout(() => {
      document.querySelector("#closeModalBtn").click();
    }, 500);
  } else {
    document.querySelector("#saveRescriptErrors").innerHTML = "";
    form.querySelector("#rescriptNumberID").value = rescript.id;
    form.querySelector(`input[name="number"]`).value = rescript.number;
    form.querySelector(`input[name="rescript_id"]`).value =
      rescript.rescript_id;
    form.querySelector(`input[name="rescript_year"]`).value =
      rescript.rescript_year;
    form.querySelector(`input[name="e_code"]`).value = rescript.e_code;
    form.querySelector(`input[name="e_name"]`).value = rescript.e_name;
    form.querySelector(`input[name="from_date"]`).value = rescript.from_date;
    form.querySelector(`input[name="to_date"]`).value = rescript.to_date;
    form.querySelector(`input[name="days_number"]`).value =
      rescript.days_number;
    form.querySelector(`#submitRescriptButton`).textContent = "Izmeni Resenje";
  }
}

async function getRescript(id) {
  let data = { id: id };
  data = JSON.stringify(data);

  let res = await fetch("/get_rescripts?action=get_one_rescript", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  });

  res = await res.json();

  return res;
}

async function getUsername(id) {
  let data = { id: id };
  data = JSON.stringify(data);

  let res = await fetch("/get_users?action=get_username", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: data,
  });

  res = await res.json();
  return res[0];
}

async function loadStats() {
  let form = document.querySelector("#searchForm");
  let e_code = Number(form.querySelector(`input[name="e_code"]`).value);

  if (typeof e_code == "number" && e_code != "") {
    if (e_code <= 9999) {
      let data = JSON.stringify({
        e_code: e_code,
      });

      let res = await fetch("/get_rescripts?action=search_by_e_code", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: data,
      });

      res = await res.json();

      if (!res?.errors && res.length > 0) {
        let notes = {};
        // response
        res.forEach((rescript) => {
          let year = rescript.from_date.slice(0, 4);

          if (!notes?.year) {
            notes[year] = res
              .filter((el) => el.from_date.slice(0, 4) == year)
              .sort((a, b) => a.number - b.number);
          }
        });

        let html = ``;
        // notes
        for (let [key, value] of Object.entries(notes)) {
          html += `<h2 id="delovodnik">Delovodnik - ${key}</h2>`;

          let statistics = {};
          let string = ``;
          // rescripts
          value.forEach((rescript) => {
            let y_string = rescript.rescript_year.toString();

            if (statistics[y_string] >= 0) {
              statistics[y_string] += Number(rescript.days_number);
            } else {
              statistics[y_string] = 0;
              statistics[y_string] += Number(rescript.days_number);
            }

            string += `
            <tr>
              <th scope="row">${rescript.number}.</th>
              <td>${rescript.rescript_id}</td>
              <td>${rescript.rescript_year}</td>
              <td>${rescript.e_code}</td>
              <td>${rescript.e_name}</td>
              <td>${rescript.days_number}</td>
              <td>${formatDate(rescript.from_date)}</td>
              <td>${formatDate(rescript.to_date)}</td>
            </tr>`;
          });

          html += `
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Br.</th>
                <th scope="col">Br. Resenja</th>
                <th scope="col">God. Resenja</th>
                <th scope="col">Sifra Radnika</th>
                <th scope="col">Ime Radnika</th>
                <th scope="col">Br. Dana GO</th>
                <th scope="col">GO od:</th>
                <th scope="col">GO do:</th>
              </tr>
            </thead>
            <tbody id="statsTable">${string}</tbody>
          </table>`;

          let stats = ``;
          for (let [stat_key, stat_value] of Object.entries(statistics)) {
            stats += `
            <p style="font-size: 20px;"><i>Za <b>${stat_key}.</b> godinu iskorisceno <b>${stat_value}</b> dana GO u ${key}. godini</i></p>
            `;
          }

          html += `<div id="statsResult">${stats}</div> <hr class="mb-5">`;
        }

        document.querySelector("#employee_stats").innerHTML = html;
      } else {
        alert("Doslo je do greske. Proverite sifru.");
        document.querySelector("#statsTable").innerHTML = "";
      }
    }
  }
}

function clearErrorBox() {
  document.querySelector("#saveRescriptErrors").innerHTML = "";
}

async function loadOldRescripts(year, search = "") {
  let data = { year: year };
  data = JSON.stringify(data);

  if (year != "") {
    let res = await fetch("/get_rescripts?action=get_old_rescripts", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: data,
    });

    res = await res.json();

    if (res.length > 0) {
      let html = ``;
      let HTMLTagRegex = /<\/?[\w\s]*>|<.+[\W]>/;

      if (search != "" && !HTMLTagRegex.test(search)) {
        res = res.filter((el) => el.new.rescript_id.includes(search));
      }

      res.forEach((el) => {
        let rescript = el.new;
        let old_rescript = el.old[0];

        html += `
        <h3 class="mt-5">Trenutna verzija Resenja</h3>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Br.</th>
              <th scope="col">Datum Izmene</th>
              <th scope="col">Br. Resenja</th>
              <th scope="col">God. Resenja</th>
              <th scope="col">Sifra Radnika</th>
              <th scope="col">Ime Radnika</th>
              <th scope="col">Br. Dana GO</th>
              <th scope="col">GO od:</th>
              <th scope="col">GO do:</th>
              <th scope="col">Uneo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">${rescript.number}.</th>
              <td>${formatDateTime(rescript.edited_at)}</td>
              <td>${rescript.rescript_id}</td>
              <td>${rescript.rescript_year}</td>
              <td>${rescript.e_code}</td>
              <td>${rescript.e_name}</td>
              <td>${rescript.days_number}</td>
              <td>${formatDate(rescript.from_date)}</td>
              <td>${formatDate(rescript.to_date)}</td>
              <td>${rescript.author}</td>
            </tr>
          </tbody>
        </table>
        <h3>Prethodna(stara) verzija Resenja</h3>
        <table class="table table-striped">
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
              <th scope="col">Izmenio</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">${old_rescript.number}.</th>
              <td>${formatDateTime(old_rescript.created_at)}</td>
              <td>${old_rescript.rescript_id}</td>
              <td>${old_rescript.rescript_year}</td>
              <td>${old_rescript.e_code}</td>
              <td>${old_rescript.e_name}</td>
              <td>${old_rescript.days_number}</td>
              <td>${formatDate(old_rescript.from_date)}</td>
              <td>${formatDate(old_rescript.to_date)}</td>
              <td>${old_rescript.author}</td>
            </tr>
          </tbody>
        </table><hr class="mb-5">`;
      });

      document.querySelector("#old_rescripts").innerHTML = html;
    }
  }
}
