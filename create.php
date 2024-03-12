<?php
include 'includes/auth.php';
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Устанавливаем значения
    $serial_number = $_POST['serialNumber'];
    $description = $_POST['description'];

    $userID = $_SESSION['userID'];

    // Создать новое заявление
    $stmt = $conn->prepare("INSERT INTO items (userID, serial_number, description, status) VALUES (?, ?, ?, 'новое')");
    $stmt->bind_param("iss", $userID, $serial_number, $description);
    $result = $stmt->execute();

    if ($result) {
        // Покажем сообщение о том, что сообщение было создано
        $success = "Заявление было успешно создано";
        header("Location: list.php");
    } else {
        $error = "Ошибка при создании заявления";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Создать новое заявление</title>
    <link rel="stylesheet" type="text/css" href="styles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="flex-grow-1 d-flex justify-content-center align-items-center pb-5">
            <div class="col-md-6 shadow p-3 mb-5 bg-white rounded">
                <h1 class="display-5 text-center">Создать новое заявление</h1>
                <div class="text-center mt-3 mb-3">
                    <a href="/list.php" class="btn btn-secondary">Назад</a>
                </div>

                <?php if (isset($error)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
                <?php endif; ?>
                <?php if (isset($success)) : ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>
                <?php endif; ?>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="serialNumber">Государственный регистрационный номер:</label>
                        <input type="text" class="form-control" id="serialNumber" name="serialNumber"
                            placeholder="Введите номер" required><br>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание нарушения:</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                            placeholder="Введите описание нарушения" required></textarea><br>
                    </div>
                    <button type="submit" class="btn btn-primary d-block mx-auto mt-3">Создать заявление</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>

</html>