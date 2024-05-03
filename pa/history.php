<?php 
    require_once('php/db.php');
    require_once('php/check_au-token.php');

    $sql = 'SELECT user_id FROM `users` WHERE token = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="css/style.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">

    <title><?php echo mb_strtoupper($quest_name, 'UTF-8'); ?> | podzamkom</title>

    <script src="https://kit.fontawesome.com/c18eb15ed3.js" crossorigin="anonymous" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="js/alert.js" defer></script>
    <script src="js/navMenu.js" defer></script>
</head>

<body>
    <nav>
        <div class="nav__container container">
            <ul>
                <li class="nav__unwrap--button">
                    <div class="unwrap__button--item"></div>
                    <div class="unwrap__button--item"></div>
                    <div class="unwrap__button--item"></div>
                </li>
                <li class="nav__logo"><img src="img/logo.png" alt="logo" class="nav__logo--img noselect"></li>
            </ul>
        </div>
    </nav>

    <div class="overlay"></div>
    
    <dialog class="nav--menu" id="dialog" open>
        <div class="nav__text--account"><?=mb_strtoupper($_COOKIE['nickname'])?></div>
        <div class="nav__button--xmark" id="closeDialog"><i class='fa-solid fa-xmark'></i></div>
        <div class="nav__stroke"></div>
        <a href="personal_account.php" class="nav__button--quests button--block noselect">КВЕСТЫ</a>
        <div class="nav__button--history button--block noselect notactive">ИСТОРИЯ ЗАКАЗОВ</div>
        <div class="nav__button--settings button--block noselect">НАСТРОЙКИ</div>
        <div class="nav__stroke"></div>
        <div class="nav__button--support button--block noselect">СВЯЗЬ С ПОДДЕРЖКОЙ</div>
        <div class="nav__button--admin button--block noselect">АДМИН-ПАНЕЛЬ</div>
        <div class="nav__button--logout button--block noselect" id="logout">ВЫХОД</div>
    </dialog>

    <section class="history">
        <div class="history__container container">
            <?=showHistory($conn, $user_id)?>
        </div>
    </section>

    <?php 

        function showHistory($conn, $user_id) {

            $sql = 'SELECT * FROM `orders` WHERE user_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['status'];
            }

        }

    ?>
</body>
</html>