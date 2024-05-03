<?php 
    require_once('php/db.php');
    require_once('php/check_au-token.php');
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

    <title>Личный кабинет | podzamkom</title>

    <script src="https://kit.fontawesome.com/c18eb15ed3.js" crossorigin="anonymous" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="js/navMenu.js" defer></script>
    <script src="js/personalaccount/selectQuest.js" defer></script>
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
        <div class="nav__button--quests button--block noselect notactive">КВЕСТЫ</div>
        <a href="history.php" class="nav__button--history button--block noselect">ИСТОРИЯ ЗАКАЗОВ</a>
        <a href="settings.php" class="nav__button--settings button--block noselect">НАСТРОЙКИ</a>
        <div class="nav__stroke"></div>
        <div class="nav__button--support button--block noselect">СВЯЗЬ С ПОДДЕРЖКОЙ</div>
        <a href="admin.php" class="nav__button--admin button--block noselect">АДМИН-ПАНЕЛЬ</a>
        <div class="nav__button--logout button--block noselect" id="logout">ВЫХОД</div>
    </dialog>

    <section class="quests">
        <div class="quests__container container">
            <div class="quests__row row">
                <?php showQuests($conn)?>
            </div>
        </div>
    </section>

    <?php 
        function showQuests($conn) {
            $sql = ("SELECT * FROM quests");
            $result = $conn->query($sql);

            $quests = array();

            if($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $quests[] = $row;
                }
            }

            foreach($quests as $quest) {
                echo "  <div class='col-md-4'>
                            <div class='quests__block' style='background: url(\"".$quest['quest_preview']."\") center center/cover no-repeat; '>
                                <div class='quests__wrapper'>
                                    <div class='quests__wrapper--name noselect'>КВЕСТ-ИГРА <br><span>«".mb_strtoupper($quest['quest_name'])."»</span></div>
                                    <div class='quests__wrapper--button'>
                                        <div class='quests__button--text noselect'>ЗАКАЗАТЬ</div>
                                        <a href='quest.php?quest=".$quest['quest_link']."' class='quests__button--blur'></a>
                                    </div>
                                </div>
                            </div>
                        </div>";
            }            
        }
    ?>

</body>
</html>