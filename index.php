<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chia sẻ ảnh & Câu chuyện</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- Header Section -->
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
    </header>
    <script>
          // Hàm mở Modal khi nhấp vào ảnh
                function openModal(imagePath, caption, imageId) {
                    var modal = document.getElementById("imageModal");
                    var modalImg = document.getElementById("modalImage");
                    var captionTextElement = document.getElementById("caption");
                    var editButton = document.getElementById("editButton");
                    var deleteButton = document.getElementById("deleteButton");

                    modal.style.display = "block";               // Hiển thị modal
                    modalImg.src = imagePath;                    // Đặt đường dẫn ảnh trong modal
                    captionTextElement.innerHTML = caption;      // Đặt nội dung chú thích trong modal

                    // Cập nhật đường dẫn cho nút Sửa và Xóa
                    editButton.href = "edit.php?id=" + imageId;
                    deleteButton.href = "delete.php?id=" + imageId;
                }

                // Đóng Modal khi nhấp vào "X"
                function closeModal() {
                    var modal = document.getElementById("imageModal");
                    modal.style.display = "none";                // Ẩn modal
                }


</script>
                
                <?php
                // Kết nối cơ sở dữ liệu
                $conn = new mysqli("localhost", "root", "", "storyofphoto");
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                // Kiểm tra nếu người dùng đã gửi form tìm kiếm
                $searchQuery = isset($_GET['search']) ? $_GET['search'] : ''; // Lấy từ khóa tìm kiếm
                $searchResults = null;

                if (!empty($searchQuery)) {
                    // Gọi hàm xử lý tìm kiếm
                    $searchResults = searchImages($searchQuery);
                } else {
                    // Nếu không có tìm kiếm, trả về tất cả các ảnh
                    $searchResults = searchImages('');
                }
                ?>

<!-- Hiển thị phần tìm kiếm -->
            <section class="search-bar">
                <h1>Khám phá những câu chuyện tuyệt vời qua từng bức ảnh</h1>
                <form action="index.php" method="GET">
                    <input type="text" placeholder="Tìm kiếm câu chuyện..." name="search" id="search-input" value="<?php echo isset($searchQuery) ? htmlspecialchars($searchQuery) : ''; ?>">
                    <button type="submit">Tìm kiếm</button>
                </form>
            </section>

<!-- Hiển thị kết quả tìm kiếm -->
            <section class="featured-photos">
                <h2>Câu chuyện nổi bật</h2>
                <div class="photo-grid">
                    <?php
                    if ($searchResults && $searchResults->num_rows > 0) {
                        // Hiển thị các ảnh và câu chuyện tìm được
                        while ($row = $searchResults->fetch_assoc()) {
                            echo '<div class="photo-item">';
                            echo '<img src="' . $row['image_path'] . '" alt="Ảnh">';
                            echo '<div class="photo-caption">' . htmlspecialchars($row['story']) . '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>Không có kết quả nào với từ khóa tìm kiếm.</p>";
                    }
                    ?>
                </div>
            </section>

    <?php
    $conn->close();
    ?>

             <?php
            // Hàm xử lý tìm kiếm
            function searchImages($searchQuery) {
                global $conn; // Sử dụng biến kết nối toàn cục

                // Đảm bảo an toàn cho truy vấn SQL
                $searchQuery = $conn->real_escape_string($searchQuery);

                // Truy vấn tìm kiếm ảnh và câu chuyện
                if (!empty($searchQuery)) {
                    $sql = "SELECT story, image_path FROM images WHERE story LIKE '%$searchQuery%' ORDER BY id DESC";
                } else {
                    $sql = "SELECT story, image_path FROM images ORDER BY id DESC";
                }

                $result = $conn->query($sql);
                return $result;
            }
            ?>


    <!-- Categories -->
    <section class="categories">
        <h2>Chủ đề</h2>
        <div class="category-list">
            <div class="category-item">Du lịch</div>
            <div class="category-item">Gia đình</div>
            <div class="category-item">Thiên nhiên</div>
            <div class="category-item">Nghệ thuật</div>
            <div class="category-item">Sự kiện</div>
        </div>
    </section>

    <!-- Latest Stories -->
    <section class="latest-stories">
        <h2>Câu chuyện mới nhất</h2>
         <div class="story-list">
        </div>
        <section class="image-gallery">
        <?php
            // Kết nối cơ sở dữ liệu
            $conn = new mysqli("localhost", "root", "", "storyofphoto"); // Thay đổi thông tin kết nối với database của bạn
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Sửa câu lệnh SQL để lấy các cột đúng
            $sql = "SELECT id,story, image_path FROM images ORDER BY id DESC"; // Lấy câu chuyện và đường dẫn ảnh
            $result = $conn->query($sql);
                    

            if ($result->num_rows > 0) {
                // Hiển thị ảnh và câu chuyện
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="image-post">';
                        echo '<img src="' . $row['image_path'] . '" alt="Ảnh" style="width: 100%; max-width: 500px;" onclick="openModal(\'' . $row['image_path'] . '\', \'' . htmlspecialchars($row['story']) . '\', ' . $row['id'] . ')">';
                        echo '<p>' . htmlspecialchars($row['story']) . '</p>';
                        if (isset($row['id'])) {
                            echo '
                            <a href="delete.php?id=' . $row['id'] . '" class="delete-btn" >
                            <i class="fas fa-trash-alt"></i> <!-- Icon Xoá -->
                            </a>';
                            echo '<a href="edit.php?id=' . $row['id'] . '" class="edit-btn">
                            <i class="fas fa-edit"></i> <!-- Icon Sửa -->
                            </a>';
                            
                        }
                        echo '</div>';
                    }

            } else {
                echo "Chưa có ảnh nào được tải lên.";
            }

            $conn->close();
            ?>
             
        </section>
    </section>
           <!-- Modal Structure -->
            <div id="imageModal" class="modal">
                <span class="close" onclick="closeModal()">&times;</span>
                <img class="modal-content" id="modalImage">
                <div id="caption"></div>
                

            </div>

           
    <!-- Footer -->
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
