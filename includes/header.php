<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: /auth/login.php");
    exit;
}

$isAuthenticated = isset($_SESSION['userID']);
$fullName = $isAuthenticated ? $_SESSION['fullName'] : '';

?>

<header class="mb-5" style="background-color: #007bff; color: white; padding: 10px;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>Нарушениям<span class="text-danger">.Нет</span></h1>
            </div>
            <nav>
                <ul class="nav">
                    <?php if (isset($_SESSION['userID'])) : ?>
                        <li class="nav-item">
                            <a class="btn btn-secondary mx-2 text-white" href="#"><?php echo $fullName; ?></a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="">
                                <input type="submit" class="btn btn-info mx-2 text-white" name="logout" value="Выйти">
                            </form>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="btn btn-info mx-2 text-white" href="/auth/login.php">Войти</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-info mx-2 text-white" href="/auth/register.php">Зарегистрироваться</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>