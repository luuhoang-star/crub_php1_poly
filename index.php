<?php
session_start();
require_once "connection.php";

// Kiểm tra xem người dùng đã tồn tại chưa, nếu chưa thì phải đăng nhập
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    die;
}
// đặt kiểu flight là f và kiểu airlines a,nối 2 bảng = nhau
$sql = "SELECT flight_id, flight_number, image, total_passengers, description, airline_name
        FROM flights f JOIN airlines a ON f.airline_id = a.airline_id"; 
// Chuẩn bị
$stmt = $conn->prepare($sql);
// Thực thi
$stmt->execute();
// Lấy dữ liệu
$flights = $stmt->fetchAll(PDO::FETCH_ASSOC);// lưu trữ mảng
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách flight</title>
</head>
<body>
    <!-- Hiển thị thông tin người dùng -->
   <div>
        <?php if (isset($_SESSION['username'])): ?> 
            WELCOME <b><?= $_SESSION['username']?></b>
            <a href="logout.php">Thoát</a>
        <?php endif ?> <!-- đóng đk -->
    </div>
    <div style="color:green">
         <?= $_COOKIE['message'] ?? '' ?> <!-- ?? kiểm tra biến cookie có tồn tai ko,có hiển thị ,ko hiện ' '-->
    </div> 
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Flight Number</th>
            <th>Image</th>
            <th>Total passengers</th>
            <th>Description</th>
            <th>Airline Name</th>
            <th>
                <a href="add.php">Thêm</a>
            </th>
        </tr>
        <?php foreach ($flights as $fl): ?> <!--lấy biến lưu mảng sql ở trên để in thông số trong sql = foreach -->
            <tr>
                <td><?= $fl['flight_id']?></td>              
                <td><?= $fl['flight_number']?></td>
                <td>
                    <img src="images/<?= $fl['image']?>" width="110" alt="">
                </td>
                <td><?= $fl['total_passengers'] ?></td>
                <td><?= $fl['description'] ?></td>
                <td><?= $fl['airline_name'] ?></td>
                <td>
                    <a href="edit.php?flight_id=<?= $fl['flight_id']?>">Sửa</a>
                    <a onclick="return confirm('Bạn muốn xóa không')"  
                        href="delete.php?flight_id=<?= $fl['flight_id']?>">Xóa</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</body>
</html>