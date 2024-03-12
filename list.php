<?php
include 'includes/auth.php';
include 'includes/db_connect.php';


// Получаем заявления для текущего пользователя
$userID = $_SESSION['userID'];
$stmt = $conn->prepare("SELECT * FROM items WHERE userID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();

$allegations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <title>Ваши заявления</title>
</head>

<body style="position: relative;">

    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="flex-grow-1 d-flex justify-content-center align-items-center pb-5">
            <div class="col-md-6">
                <h1 class="display-4 text-center">Ваши заявления</h1>
                <?php if (isset($allegations)) : ?>
                <ul class="list-group">
                    <?php foreach ($allegations as $allegation) : ?>
                    <li class="list-group-item mt-4 shadow-sm">
                        <h3><strong>Серийный номер: <?php echo $allegation['serial_number']; ?></strong></h3>
                        <p>Описание: <?php echo $allegation['description']; ?></p>
                        <p>Статус: <?php echo $allegation['status']; ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <div class="text-center mt-3">
                    <a href="/create.php" class="btn btn-primary mt-3 mb-3">Создать новое
                        заявление</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>

</html>