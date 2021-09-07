<?php
    $servername = "localhost";
    $databasename = "bogar_tanulo_adatbazis";
    $username = "root";
    $password = "root";

    $image_name = $_POST["imageName"];
    $image_width = $_POST["imageWidth"];
    $image_height = $_POST["imageHeight"];
    $distance_pixels = $_POST["distancePixel"];
    $distance_mm = $_POST["distancemm"];
    $usernameCookie = $_COOKIE["username"];
    $user_id = '';

    $conn = new mysqli($servername, $username, $password, $databasename);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $select_user_id_sql = "SELECT id FROM felhasznalo WHERE binary felhasznalo_nev = '$usernameCookie'";
    $result = $conn->query($select_user_id_sql);
    while($row = $result->fetch_assoc()) {
        $user_id = $row["id"];
    }

    $select_image_sql = "SELECT * FROM kep WHERE fajl_nev='$image_name';";
    $result = $conn->query($select_image_sql);
    if (mysqli_num_rows($result) != 0){
        echo "Juhé! Ez a kép már benne van az adatbázisban!";
        $update_image_sql = "UPDATE kep SET aranytavolsag_pixel='$distance_pixels', aranytavolsag_mm='$distance_mm' WHERE fajl_nev='$image_name';";
        $conn->query($update_image_sql);
    }else{
        echo "Ez a kép még nincs benne az adatbázisban.";
        $insert_image_sql = "INSERT INTO kep (fajl_nev, szelesseg_pixel, magassag_pixel, aranytavolsag_pixel, aranytavolsag_mm, felhasznalo_id) VALUES ('$image_name','$image_width','$image_height','$distance_pixels','$distance_mm','$user_id');";
        $conn->query($insert_image_sql);
    }


    $conn->close();
?>
