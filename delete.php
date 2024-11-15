<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "storyofphoto"); // Thay đổi thông tin kết nối với database của bạn
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem có id ảnh để xóa không
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];

    // Lấy đường dẫn ảnh từ cơ sở dữ liệu
    $sql = "SELECT image_path FROM images WHERE id = $image_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image_path'];

        // Xóa ảnh khỏi server
        if (file_exists($image_path)) {
            unlink($image_path);  // Xóa file ảnh khỏi thư mục uploads
        }

        // Xóa bản ghi ảnh trong cơ sở dữ liệu
        $delete_sql = "DELETE FROM images WHERE id = $image_id";
        if ($conn->query($delete_sql) === TRUE) {
            // Chuyển hướng về trang chủ sau khi xóa ảnh thành công
            header("Location: index.php");
            exit();
        } else {
            echo "Lỗi khi xóa ảnh: " . $conn->error;
        }
    } else {
        echo "Ảnh không tồn tại.";
    }
} else {
    echo "Không tìm thấy ID ảnh.";
}

$conn->close();
?>
