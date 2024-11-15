<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  <style>
    /* Áp dụng hình ảnh cho toàn bộ trang */
body {
    background-image: url('img/bg6.jpg'); /* Đặt đường dẫn hình ảnh của bạn */
    background-size: cover;  /* Đảm bảo hình ảnh phủ toàn bộ màn hình */
    background-position: center center;  /* Căn giữa hình ảnh */
    background-repeat: no-repeat;  /* Không lặp lại hình ảnh */
    margin: 0; /* Loại bỏ margin mặc định */
    padding: 0; /* Loại bỏ padding mặc định */
}



/* Header */
header {
    height: 100px;                  /* Đặt chiều cao cho header, bạn có thể thay đổi theo ý muốn */
    color: white;                   /* Đặt màu chữ là màu trắng (nếu cần) */
    display: flex;
    align-items: center;            /* Căn giữa nội dung theo chiều dọc */
    justify-content: center;        /* Căn giữa nội dung theo chiều ngang */
    text-align: center;
    padding: 50px 0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Thêm bóng nhẹ */
    background: inherit;  /* Kế thừa background từ body */
}

/* Tương tự, footer kế thừa background từ body */
footer {
    background: inherit;  /* Kế thừa background từ body */
    padding: 30px 0; /* Điều chỉnh padding của footer */
    text-align: center;
    color: white; /* Màu chữ trắng */
}

/* Điều chỉnh cho logo */
.logo {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
}

.logo-img {
    max-width: 350px;
    height: auto;
    transition: all 0.3s ease; /* Hiệu ứng chuyển động mượt mà khi hover */
}
.logo-img:hover {
    transform: scale(1.05); /* Phóng to logo khi hover */
}

/* Nếu muốn logo nhỏ hơn trên các màn hình nhỏ */
@media (max-width: 768px) {
    .logo-img {
        max-width: 120px; /* Logo nhỏ hơn trên thiết bị di động */
    }
}


nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

nav .logo a {
    font-size: 28px;
    font-weight: bold;
    text-decoration: none;
    color: black;
    letter-spacing: 1px;
    transition: color 0.3s ease;
}

nav .logo a:hover {
    color: #ff6347; /* Chuyển sang màu cam khi hover */
}

.nav-links {
    list-style-type: none;
    display: flex;
    gap: 20px;
}

.nav-links li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    position: relative;
    transition: color 0.3s ease;
}

.nav-links li a:hover {
    color: #ff6347;
}

.nav-links li a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #ff6347;
    transform: scaleX(0);
    transform-origin: bottom right;
    transition: transform 0.3s ease;
}

.nav-links li a:hover::after {
    transform: scaleX(1);
    transform-origin: bottom left;
}

    /* Form đăng nhập */
    form {
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    input[type="text"], input[type="password"], button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    button {
      background-color: #4CAF50;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }

    /* Popup */
    #popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 300px;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      z-index: 1000;
      text-align: center;
    }

    #popup h3 {
      margin-bottom: 10px;
    }

    #popup button {
      background-color: #d9534f;
    }

    #popup button:hover {
      background-color: #c9302c;
    }

    /* Mờ nền khi popup xuất hiện */
    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 999;
    }
  </style>
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
                <li><a href="login.php">Đăng nhập</a></li>
                <li><a href="register.php">Đăng ký</a></li>
            </ul>
        </nav>
    </header>
<!-- Form đăng nhập -->
<form id="loginForm">
  <input type="text" name="username" placeholder="Tên đăng nhập" required>
  <input type="password" name="password" placeholder="Mật khẩu" required>
  <button type="submit">Đăng nhập</button>
</form>

<!-- Popup -->
<div id="overlay"></div>
<div id="popup">
  <h3>Đăng nhập thành công!</h3>
  <p>Chào mừng bạn quay trở lại!</p>
  <button onclick="closePopup()">Đóng</button>
</div>

<script>
  const loginForm = document.getElementById('loginForm');
  const popup = document.getElementById('popup');
  const overlay = document.getElementById('overlay');

  // Giả lập kiểm tra đăng nhập
  loginForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Ngăn form gửi yêu cầu lên server
    
    // Hiển thị popup
    overlay.style.display = 'block';
    popup.style.display = 'block';
  });

  // Đóng popup
  function closePopup() {
    popup.style.display = 'none';
    overlay.style.display = 'none';
  }
  loginForm.addEventListener('submit', function(event) {
  event.preventDefault(); // Ngăn form gửi yêu cầu
  
  const formData = new FormData(loginForm);

  fetch('login.php', {
    method: 'POST',
    body: formData,
  })
    .then(response => response.text())
    .then(result => {
      if (result === 'success') {
        overlay.style.display = 'block';
        popup.style.display = 'block';
      } else {
        alert('Sai tên đăng nhập hoặc mật khẩu.');
      }
    })
    .catch(error => console.error('Lỗi:', error));
});

</script>
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "storyofphoto");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            echo 'success'; // Trả về kết quả cho JavaScript
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
}
$conn->close();
?>

</body>
</html>
