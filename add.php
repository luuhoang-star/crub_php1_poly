<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $flight_number = $_POST['flight_number'];
    $total_passengers = $_POST['total_passengers'];
    $description = $_POST['description'];
    $airline_id = $_POST['airline_id'];

    // Upload
    $file = $_FILES['image']; // Chú ý sửa từ $_FILE thành $_FILES
    // Lấy tên file
    $image = $file['name'];
    // Upload
    move_uploaded_file($file['tmp_name'], "images/" . $image);

    // SQL
    $sql = "INSERT INTO flights(flight_number, image, total_passengers, description, airline_id)
            VALUES('$flight_number', '$image', '$total_passengers', '$description', '$airline_id')";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    setcookie("message", "Thêm dữ liệu thành công", time() + 1);

    header("location: index.php");
    die;
}

$sql = "SELECT * FROM airlines"; // lấy dữ liệu từ bảng airlines
$stmt = $conn->prepare($sql);   //Chuẩn bị sql
$stmt->execute();               //Thực hiện sql
$airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm flight</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        Flight Number: <input type="number" name="flight_number" id="">
        <br><br>
        Image: <input type="file" name="image" id="">
        <br><br>
        Total passengers: <input type="number" name="total_passengers" id="">
        <br><br>
        Description:
        <textarea name="description" id="" cols="30" rows="10"></textarea>
        <br><br>
        
        Airline:
        <select name="airline_id" id="">
            <?php foreach ($airlines as $air): ?>
                <option value="<?= $air['airline_id'] ?>"> <!--lựa chọn tên hàng không trong bảng airlines-->
                    <?= $air['airline_name'] ?>
                </option>
            <?php endforeach ?>
        </select>
        <br><br>
        <button type="submit">Thêm</button>
    </form>
</body>
</html>
