<?php
include 'includes/auth.php';
include 'includes/db_connect.php';

// Получаем заявления 
$stmt = $conn->prepare("SELECT * FROM items");
$stmt->execute();
$allegations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['allegationID']) && isset($_POST['newStatus'])) {
    $allegationID = $_POST['allegationID'];
    $newStatus = $_POST['newStatus'];

    $sql = "UPDATE Allegation SET status = :status WHERE id = :allegationID";
    $stmt = $conn->prepare("UPDATE items SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $newStatus, $allegationID);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM items");
    $stmt->execute();
    $allegations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

?>

<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <title>Панель администратора</title>
</head>

<body style="position: relative;">

    <?php include 'includes/header.php'; ?>


    <div class="container">
        <div class="flex-grow-1 d-flex justify-content-center align-items-center pb-5">
            <div class="col-md-6">
                <h1 class="display-4 text-center">Панель администратора</h1>
                <?php if (isset($allegations)) : ?>
                <ul class="list-group mb-3">
                    <?php foreach ($allegations as $allegation) : ?>
                    <li class="list-group-item mt-4 shadow-sm">
                        <h3><strong>Серийный номер: <?php echo $allegation['serial_number']; ?></strong></h3>
                        <p>Описание: <?php echo $allegation['description']; ?></p>
                        <p>Статус: <?php echo $allegation['status']; ?></p>
                        <form method="post" action="">
                            <input type="hidden" name="allegationID" value="<?php echo $allegation['id']; ?>">
                            <div class="d-flex">
                                <select name="newStatus" class="form-select w-25 me-3">
                                    <option value="подтверждено">Подтвердить</option>
                                    <option value="отклонено">Отклонить</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Изменить статус</button>
                            </div>
                        </form>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>

</html>