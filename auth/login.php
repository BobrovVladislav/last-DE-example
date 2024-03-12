<?php
include '../includes/auth.php';
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Попытка авторизации
    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ? ");
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Пользователь успешно авторизован
        session_start();
        $_SESSION['userID'] = $user['id']; // Сохранение идентификатора пользователя в сессии
        $_SESSION['fullName'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        // Перенаправление на страницу списка заявлений
        header("Location: ../list.php");
    } else {
        $error = "Неправильное имя пользователя или пароль.";
    }
}

// Закрытие соединения с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../styles/styles.css">
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <div class="container flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="col-md-6 shadow p-3 mb-5 bg-white rounded">
            <h1 class="display-4 text-center">Авторизация</h1>

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
                <button type="submit" class="btn btn-primary d-block mx-auto mt-3">Авторизоваться</button>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</body>

</html>