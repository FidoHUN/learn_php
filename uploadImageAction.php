<?php
$folderPath = 'mentett/';

$image_parts = explode(";base64,", $_POST['image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file = $folderPath . uniqid() . '.png';
file_put_contents($file, $image_base64);
echo json_encode(["Image uploaded successfully."]);

$servername = "localhost";
$databasename = "bogar_tanulo_adatbazis";
$username = "root";
$password = "root";

$image_name = $_POST["imageName"];
$image_width = $_POST["imageWidth"];
$image_height = $_POST["imageHeight"];
$area_initial_x = $_POST["areaInitialX"];
$area_initial_y = $_POST["areaInitialY"];
$area_width = $_POST["areaWidth"];
$area_height = $_POST["areaHeight"];
$bug = $_POST["bug"];
$time = date("Y-m-d H:i:s");
$usernameCookie = $_COOKIE["username"];
$user_id = '';
$image_id = '';
$bug_id = '';

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
}else{
    echo "Ez a kép még nincs benne az adatbázisban.";
    $insert_image_sql = "INSERT INTO kep (fajl_nev, szelesseg_pixel, magassag_pixel, felhasznalo_id) VALUES ('$image_name','$image_width','$image_height','$user_id');";
    $conn->query($insert_image_sql);
    echo $insert_image_sql;
}



$select_image_id_sql = "SELECT id FROM kep WHERE fajl_nev='$image_name';";
$result = $conn->query($select_image_id_sql);
while($row = $result->fetch_assoc()) {
    $image_id = $row["id"];
}
$select_image_id_sql = "SELECT id FROM bogar WHERE nev='$bug';";
$result = $conn->query($select_image_id_sql);
while($row = $result->fetch_assoc()) {
    $bug_id = $row["id"];
}



$save_image_sql = "INSERT INTO kivagas (kezdo_koordinata_x, kezdo_koordinata_y, szelesseg_pixel, magassag_pixel, ido, kep_id, bogar_id, felhasznalo_id) VALUES ('$area_initial_x','$area_initial_y','$area_width','$area_height','$time','$image_id','$bug_id','$user_id');";
$conn->query($save_image_sql);


$conn->close();


?>
