<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "storyofphoto"); // Thay đổi thông tin kết nối với database của bạn
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra nếu có id để sửa ảnh
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];

    // Lấy dữ liệu ảnh cần sửa
    $sql = "SELECT * FROM images WHERE id = $image_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $story = $row['story'];
        $image_path = $row['image_path'];
    } else {
        echo "Ảnh không tồn tại.";
        exit();
    }

    // Xử lý form sửa ảnh
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $story = $_POST['story'];
        $image_path = $row['image_path'];  // Giữ nguyên ảnh cũ nếu không thay đổi ảnh

        // Kiểm tra nếu có ảnh mới được tải lên
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Xóa ảnh cũ khỏi server
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            // Đường dẫn ảnh mới
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            
            // Di chuyển ảnh mới vào thư mục uploads
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image_path = $targetFile;  // Cập nhật đường dẫn ảnh mới
            }
        }

        // Cập nhật thông tin vào cơ sở dữ liệu
        $sql = "UPDATE images SET story = '$story', image_path = '$image_path' WHERE id = $image_id";
        if ($conn->query($sql) === TRUE) {
            // Chuyển hướng về trang chủ sau khi sửa ảnh thành công
            header("Location: index.php");
            exit();
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
} else {
    echo "Không tìm thấy ID ảnh để sửa.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa ảnh</title>
    <link rel="stylesheet" href="upload.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php"><img src="img/logo2.png" alt="Logo" class="logo-img"></a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="upload.php">Tải ảnh lên</a></li>
                <li><a href="#">Khám phá</a></li>
                <li><a href="#">Đăng nhập</a></li>
                <li><a href="#">Đăng ký</a></li>
            </ul>
        </nav>
    </header>
    <form action="edit.php?id=<?php echo $image_id; ?>" method="POST" enctype="multipart/form-data">
        <div>
            <label for="story">Câu chuyện:</label>
            <textarea name="story" id="story" rows="5"><?php echo htmlspecialchars($story); ?></textarea>
        </div>

        <div>
            <label for="image">Chọn ảnh mới (nếu có):</label>
            <input type="file" name="image" id="image">
        </div>

        <button type="submit">Lưu thay đổi</button>
    </form>
</body>
</html>
