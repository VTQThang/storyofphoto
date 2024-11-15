<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tải ảnh lên</title>
    <link rel="stylesheet" href="upload.css">
</head>
<?php
if (isset($_POST['upload'])) {
    // Kiểm tra nếu file đã được chọn
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Đường dẫn thư mục lưu trữ ảnh
        $targetDir = "uploads/";
        // Lấy tên file ảnh
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là ảnh không
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Kiểm tra nếu file đã tồn tại
            if (file_exists($targetFile)) {
                echo "Xin lỗi, file này đã tồn tại.";
            } else {
                // Giới hạn kích thước file ảnh
                if ($_FILES["image"]["size"] > 5000000) { // 5MB
                    echo "Xin lỗi, ảnh của bạn quá lớn.";
                } else {
                    // Cho phép các định dạng ảnh nhất định
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo "Xin lỗi, chỉ hỗ trợ ảnh JPG, JPEG, PNG và GIF.";
                    } else {
                        // Di chuyển file tải lên vào thư mục uploads
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                            echo "Ảnh " . basename($_FILES["image"]["name"]) . " đã được tải lên.";

                            // Lưu thông tin vào cơ sở dữ liệu
                            // Kết nối với database (sử dụng mysqli hoặc PDO)
                            $conn = new mysqli("localhost", "root", "", "storyofphoto"); // Thay đổi theo thông tin của bạn
                            if ($conn->connect_error) {
                                die("Kết nối thất bại: " . $conn->connect_error);
                            }

                            $story = $_POST['story'];
                            $filePath = $targetFile; // Đường dẫn file ảnh

                            // Lưu thông tin vào cơ sở dữ liệu
                            $sql = "INSERT INTO images (story, image_path) VALUES ('$story', '$filePath')";
                            if ($conn->query($sql) === TRUE) {
                                header("Location: index.php");  // Đảm bảo rằng trang chủ của bạn là 'index.php'
                                exit;
                                echo "Câu chuyện và ảnh đã được lưu thành công!";
                            } else {
                                echo "Lỗi: " . $sql . "<br>" . $conn->error;
                            }

                            $conn->close();
                        } else {
                            echo "Xin lỗi, có lỗi xảy ra khi tải ảnh lên.";
                        }
                    }
                }
            }
        } else {
            echo "File không phải là ảnh.";
        }
    }
}
?>


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
                <li><a href="login.php">Đăng nhập</a></li>
                <li><a href="register.php">Đăng ký</a></li>
            </ul>
        </nav>
    </header>>

    <section class="upload-section">
        <h1>Tải ảnh lên và chia sẻ câu chuyện của bạn</h1>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="image">Chọn ảnh:</label>
                <input type="file" name="image" id="image" required >
            </div>

            <div>
                <label for="story">Câu chuyện của bạn:</label>
                <textarea name="story" id="story" rows="5" required></textarea>
            </div>

            <button type="submit" name="upload">Tải ảnh lên</button>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 VTQT Tất cả các quyền được bảo vệ.</p>
        <ul>
            <li><a href="#">Giới thiệu</a></li>
            <li><a href="#">Chính sách bảo mật</a></li>
            <li><a href="#">Liên hệ</a></li>
        </ul>
    </footer>
</body>
</html>
