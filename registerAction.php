<?php
  $servername = "localhost";
  $databasename = "bogar_tanulo_adatbazis";
  $username = "root";
  $password = "root";

  $conn = new mysqli($servername, $username, $password, $databasename);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $usernamePage = $_POST['username'];
  $passwordPage = $_POST['password'];

  $select_sql = "SELECT * FROM felhasznalo WHERE binary felhasznalo_nev='$usernamePage'";
  $result = $conn->query($select_sql);
  if(mysqli_num_rows($result) != 0){
    setcookie("passedReg","false",time() + (5), "/");
  }else{
    setcookie("passedReg","true",time() + (5), "/");
    $insert_sql = "INSERT INTO felhasznalo (felhasznalo_nev, jelszo) VALUES ('$usernamePage','$passwordPage');";
    $conn->query($insert_sql);
  }

  $conn->close();
?>
