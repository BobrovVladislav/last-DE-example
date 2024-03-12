<?php
include '../includes/auth.php';
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Устанавливаем значения
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Проверка наличия имени пользователя и пароля
    if (checkUser($login)) {
        $error = "Логин занят";
    }
    // Попытка создания пользователя
    else if (createUser($login, $password, $fullName, $email, $phone)) {
        header("Location: login.php");
    } else {
        $error = "Не удалось создать пользователя";
    }
}

// Закрытие соединения с базой данных
$conn->close();

// Функция для проверки существования пользователя
function checkUser($login)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function createUser($login, $password, $fullName, $email, $phone)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO users (login, password, full_name, email, phone, role) VALUES (?, ?, ?, ?, ?, 'user')");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Хэширование пароля
    $stmt->bind_param("sssss", $login, $hashedPassword, $fullName, $email, $phone);
    return $stmt->execute();
}

?>

<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/styles.css">
    <title>Регистрация</title>
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="container flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="col-md-6 shadow p-3 mb-5 bg-white rounded">
            <h1 class="display-4 text-center">Регистрация</h1>

            <?php if (isset($error)) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <form id="registration-form" method="post" action="">
                <div class="form-group">
                    <label for="login">Логин:</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Введите логин"
                        required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Введите пароль" required>
                </div>
                <div class="form-group">
                    <label for="fullName">ФИО:</label>
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Введите ФИО"
                        required>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон:</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Введите телефон"
                        required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Введите email"
                        required>
                </div>
                <button type="submit" class="btn btn-primary d-block mx-auto mt-3">Зарегистрироваться</button>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</body>

</html>