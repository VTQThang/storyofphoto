<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>
<style>
    form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}
</style>
<body>
<form action="register.php" method="POST" class="dangky">
    <input type="text" name="username" placeholder="Tên đăng nhập" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
    <button type="submit">Đăng ký</button>
</form>
            <?php
            // Kết nối cơ sở dữ liệu
            $conn = new mysqli("localhost", "root", "", "storyofphoto");
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $conn->real_escape_string($_POST['username']);
                $email = $conn->real_escape_string($_POST['email']);
                $password = $conn->real_escape_string($_POST['password']);
                $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

                // Kiểm tra mật khẩu khớp
                if ($password !== $confirm_password) {
                    echo "Mật khẩu không khớp.";
                    exit;
                }

                // Mã hóa mật khẩu
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Thêm vào cơ sở dữ liệu
                $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
                if ($conn->query($sql) === TRUE) {
                    echo "Đăng ký thành công!";
                    header("Location: login.php");
                    exit;
                } else {
                    echo "Lỗi: " . $sql . "<br>" . $conn->error;
                }
            }
            $conn->close();
            ?>

</body>
</html>