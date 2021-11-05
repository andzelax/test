<?php
$conn = new mysqli('localhost', 'user2', '', 'ksiegarnia1');

$conn->set_charset("utf8mb4");

if(isset($_POST['dodaj'])){
    $tytul = $_POST['tytul'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $cena = $_POST['cena'];

    $sql = "INSERT INTO ksiazki(imieautora, nazwiskoautora, tytul, cena) VALUES ('$imie', '$nazwisko', '$tytul', '$cena')";
    $conn->query($sql);
}
elseif(isset($_POST['edytuj']) && $id = $_POST['edytuj']){
    $tytul = $_POST['tytul'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $cena = $_POST['cena'];

    $sql = "UPDATE ksiazki SET imieautora = '$imie', nazwiskoautora = '$nazwisko', tytul = '$tytul', cena = '$cena' WHERE idksiazki = '$id'";
    $conn->query($sql);
}

$conn->close();

header('Location: logged.php');
?>