<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/home">Zdravo, <?= $user['username']; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="/home">Pocetna</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/stats">Izvestaji</a>
      </li>
      <?php if($user['status'] == "admin"): ?>
        <li class="nav-item">
          <a class="nav-link" href="/old_rescripts">Istorija Resenja</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/users">Korisnici</a>
        </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="/logout">Izlogujte se</a>
      </li>
    </ul>

  </div>
</nav>