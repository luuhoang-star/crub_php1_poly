<?php
require_once "connection.php"; //Kết nối csdl(có thể sd csdl cho đoạn dưới)

// GÁN ID VÀO url  thông qua cột flight_id trong sql
$flight_id = $_GET['flight_id']; 

//Xóa giá trị flight_id từ bảng flights
$sql = "DELETE FROM flights WHERE flight_id= $flight_id";

// Chuẩn bị và thực thi câu lệnh SQL
$stmt = $conn->prepare($sql);
$stmt->execute();

// Thiết lập cookie và chuyển hướng
setcookie("message", "Xoa du lieu thanh cong", time() + 1);
header("location: index.php");
die;