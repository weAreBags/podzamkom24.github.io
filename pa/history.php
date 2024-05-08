<?php 
    require_once('php/db.php');
    require_once('php/check_au-token.php');
    require_once('php/getUserID.php');

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
    <script src="js/overlays.js" defer></script>
    <script src="js/history/moreInfo.js" defer></script>
    <script src="js/history/buttonActivity.js" defer></script>
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
    <!-- <div class="overlay--transparent"></div> -->
    
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
            <h1 class="history__title">ИСТОРИЯ ЗАКАЗОВ</h1>
            <div class="history__stroke"></div>
            <?=showHistory($conn, $user_id)?>
        </div>
    </section>

    <dialog class="history__info--block close__modal">
        <div class="history__info--xmark"><i class="fa-solid fa-xmark"></i></div>

        <h2 class="history__info--quest">КВЕСТ: <span></span></h2>
        <div class="history__info--date"><span></span></div>

        <div class="history__info--stroke"></div>

        <div class="history__info--players history__info--element">КОЛИЧЕСТВО ИГРОКОВ: <span></span></div>
        <div class="history__info--age history__info--element">ВОЗРАСТ: <span></span></div>
        <div class="history__info--actors history__info--element">НАЛИЧИЕ АКТЁРОВ: <span></span></div>
        <div class="history__info--status history__info--element">СТАТУС: <span></span></div>

        <div class="history__info--stroke"></div>

        <div class="history__info--code" data-code="">КОД ЗАКАЗА: <span></span></div>

        <div class="history__info--stroke"></div>

        <div class="button__wrapper history__button--wrapper">
            <div class="button__wrapper--text history__button--text"></div>
            <div class="button__wrapper--blur history__button--activity"></div>
        </div>
    </dialog>

    <?php
        

        function showHistory($conn, $user_id) {

            $sql = 'SELECT * FROM `orders` WHERE user_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $orders = array();

            if($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $orders[] = $row;
                }
            }

            

            foreach($orders as $order) {
                $date_time = $order['date'] . ' ' . $order['time'];
                $formattedDate = date('d.m.Y H:i', strtotime($date_time));
                $currentDate = date('d.m.Y H:i', strtotime('-1 hour'));

                switch ($order['status']) {
                    case 'pending':
                        $status = ($formattedDate < $currentDate) ? 'ПРОСРОЧЕНО' : 'В ОБРАБОТКЕ';
                        break;
                    case 'confirmed':
                        $status = ($formattedDate < $currentDate) ? 'ПРОВЕДЕНО' : 'ПОДТВЕРЖДЕНО';
                        break;
                    case 'canceled':
                        $status = 'ОТМЕНЕНО';
                        break;
                }

                echo '
                <div class="history__block" data-history="' . $order['code'] . '">
                    <div class="history__info">
                        <div class="history__quest info--item"><span>КВЕСТ: </span>' . mb_strtoupper($order['quest_name']) . '</div>
                        <div class="history__date info--item"><span>ДАТА И ВРЕМЯ ПРОВЕДЕНИЯ: </span>' . $formattedDate . '</div>
                        <div class="history__status info--item"><span>СТАТУС: </span>' . $status . '</div>
                    </div>
                    <button class="history__button--info noselect">ПОДРОБНЕЕ</button>
                </div>
                ';
            }
        }

        require_once('php/alerts.php');

        $conn->close();

    ?>
</body>
</html>