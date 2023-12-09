<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") { // Kiểm tra xem form có gọi = post ko
    $flight_number = $_POST['flight_number'];       //Lấy dữ liệu từ form rồi thông qua post
    $total_passengers = $_POST['total_passengers'];  // để tải web và cập nhật sql
    $description = $_POST['description'];
    $airline_id = $_POST['airline_id'];

    $flight_id = $_POST['flight_id'];
    $image = $_POST['image'];

    // Upload
    $file = $_FILES['image']; // Sửa từ $_FILE thành $_FILES
    // Cập nhật ảnh
    if ($file['size'] > 0) {       /*Kiểm tra xem ảnh có trong form ko*/         
        // Lấy tên file
        $image = $file['name'];
        // Upload
        move_uploaded_file($file['tmp_name'], 'images/' . $image);
    }

    // cập nhật giá trị bảng flights,giá trị flight= biến flight,ở chỗ if,form lq đến post
    $sql = "UPDATE flights SET flight_number='$flight_number', image='$image',
            total_passengers='$total_passengers', description='$description', 
            airline_id='$airline_id' WHERE flight_id=$flight_id";

    $stmt = $conn->prepare($sql);// chuẩn bị kết nối sql
    $stmt->execute();//Thực thi câu lệnh sql

    setcookie("message", "Cập nhật dữ liệu thành công", time() + 1);

    header("location: index.php");
    die;
}

$sql = "SELECT * FROM airlines"; // lấy sql từ bảng airlines
$stmt = $conn->prepare($sql);   //chuẩn bị sql
$stmt->execute();               //thực thi câu lệnh
$airlines = $stmt->fetchAll(PDO::FETCH_ASSOC);//thực thi 1 dòng của airlines

// Lấy thông tin flight_id từ URL
$flight_id = $_GET['flight_id'];

$sql = "SELECT * FROM flights WHERE flight_id=$flight_id";//lấy từ bảng flights trong sql nếu giá trị = biến
$stmt = $conn->prepare($sql); // chuẩn bị
$stmt->execute(); // thực thi
$flight = $stmt->fetch(PDO::FETCH_ASSOC); //thực thi 1 dòng của flight 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa flight</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">       <!--Form đặt tên theo post,liên quan nhau-->
      <input type="hidden" name="flight_id" value="<?= $flight['flight_id']?>"> <!--In ra -->
        Flight Number: <input type="number" name="flight_number" value="<?= $flight['flight_number']?>">
        <br><br>
        Image: <input type="file" name="image" id="">
        <img src="images/<?= $flight['image']?>" width="110">
        <br><br>
        Total passengers: <input type="number" name="total_passengers" value="<?= $flight['total_passengers']?>">
        <br><br>
        Description:
        <textarea name="description" id="" cols="30" rows="10"><?= $flight['description']?></textarea>
        <br><br>
        Airline:
        <select name="airline_id" id="">
            <?php foreach($airlines as $air) : ?>
                <option value="<?= $air['airline_id'] ?>" <?= ($air['airline_id'] == $flight['airline_id']) ? 'selected': '' ?>>
                    <?= $air['airline_name'] ?>
                </option>
            <?php endforeach ?>
        </select>
        <br><br>
        <button type="submit">Cập nhật</button>
        <a href="index.php">Danh sách</a>
    </form>
</body>
</html>