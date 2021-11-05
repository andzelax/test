<?php
$conn = new mysqli('localhost', 'user1', '', 'ksiegarnia1');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
$conn->set_charset("utf8mb4");

$sql = "SELECT DISTINCT imieautora, nazwiskoautora FROM ksiazki";
$autorzy = $conn->query($sql);

if(isset($_GET['autor']) && $_GET['autor'] != "wszyscy"){
    $autor = explode(';', $_GET['autor']);
    $imie = $autor[0];
    $nazwisko = $autor[1];
    $sql = "SELECT * FROM ksiazki WHERE imieautora LIKE '$imie' AND nazwiskoautora LIKE '$nazwisko'";
}else{
    $sql = "SELECT * FROM ksiazki";
}
$ksiazki = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en" class="h-100">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
    <title>Document</title>
  </head>
  <body class="h-100">
    <nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand">Szymon Mlonekt 4it</a>
        <a href="logged.php" class="btn btn-primary">Połącz</a>
      </div>
    </nav>
    <div class="row h-100">
      <div class="col-4 h-100 d-flex justify-content-center">
        <div
          class="card text-center"
          style="width: 18rem; top: 40%; position: absolute"
        >
          <div class="card-body">
            <h5 class="card-title">Wyszukaj autora</h5>
            <div class="card-text">
              <form class="form" method="get" action="index.php">
                <select class="form-select" name="autor">
                    <option value="wszyscy">Wszyscy</option>
                    <?php 
                        if ($autorzy->num_rows > 0){
                            while ($row = $autorzy->fetch_assoc()){
                                if (isset($_GET['autor']) && $_GET['autor'] == $row['imieautora'] . ";" . $row['nazwiskoautora']){
                                   ?>
                                   <option selected value="<?= $row['imieautora'] . ";" . $row['nazwiskoautora'] ?>"><?= $row['imieautora'] . " " . $row['nazwiskoautora'] ?></option>
                                   <?php     
                                }
                                else{
                                    ?>
                                    <option value="<?= $row['imieautora'] . ";" . $row['nazwiskoautora'] ?>"><?= $row['imieautora'] . " " . $row['nazwiskoautora'] ?></option>
                                    <?php
                                }                   

                            }
                        }
                    ?>
                </select>
                <br />
                <button type="submit" class="btn btn-primary">
                  Wyszukaj
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-8 h-100 text-center mt-5 mb-5">
        <table class="table">
          <?php if(isset($_GET['autor']) && $_GET['autor'] != 'wszyscy'): ?>
            <?php
            $autor = explode(';', $_GET['autor']);
            echo "<h1>" . $autor[0] . " " . $autor[1] . "</h1>"; 
            ?>
          <?php else: ?>
          <h1>Wszyscy autorzy</h1>
          <?php endif; ?>
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Autor</th>
              <th scope="col">Nazwa</th>
              <th scope="col">Cena</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if ($ksiazki->num_rows > 0){
                while ($row = $ksiazki->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?= $row['idksiazki'] ?></td>
                        <td><?= $row['imieautora'] . " " . $row['nazwiskoautora'] ?></td>
                        <td><?= $row['tytul'] ?></td>
                        <td><?= $row['cena'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
          </tbody>
        </table>
        <p>Znalezionych książek: <?= $ksiazki->num_rows ?></p>
      </div>
    </div>
  </body>
</html>
