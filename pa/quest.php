<?php 
    require_once('php/db.php');
    require_once('php/check_au-token.php');

    // ПОЛУЧЕНИЕ НОМЕРА ПОЛЬЗОВАТЕЛЯ

    $sql = 'SELECT number FROM `users` WHERE token = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $number = $row['number'];

        if(is_null($number)) {
            echo '
            <div class="overlay--special" style="display: block"></div>
            ';
        }
    }
    
    // ПОЛУЧЕНИЕ ИНФОРМАЦИИ ПО КВЕСТАМ

    if(isset($_GET['quest'])) {
        $quest = $_GET['quest'];

        $sql = "SELECT * FROM `quests` WHERE quest_link = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $quest);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $quest_name = $row['quest_name'];
            $quest_legend = $row['quest_legend'];
            $quest_price = $row['quest_price'];
            $quest_genre = $row['quest_genre'];
            $quest_first = $row['first_photo'];
            $quest_second = $row['second_photo'];
            $quest_third = $row['third_photo'];
            $quest_min = $row['quest_min'];
            $quest_max = $row['quest_max'];
            $quest_additional = $row['quest_additional'];

            $areAdditional = ($quest_additional != null) ? true : false;

            // получение рейтинга квеста

            $sql = "SELECT rating FROM `reviews` WHERE quest_link = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $quest);
            $stmt->execute();
            $result = $stmt->get_result();
            
            function starsGenerate($topOfCycle, $stars, $img) {
                if ($topOfCycle != 0) {
                    for ($i = 0; $i < $topOfCycle; $i++) {
                        $stars .= $img;
                    }
                    return $stars;
                }
            }
            
            $lightStars = '';
            $darkStars = '';
            $lightStarImg = '<img src="img/quests_order/stars.png" alt="stars">';
            $darkStarImg = '<img src="img/quests_order/1star.png" alt="1star">';

            if($result->num_rows > 0) {                
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                $count = count($rows);
                $arrAmount = 0;

                foreach ($rows as $row) {
                    $arrAmount += $row['rating'];
                }

                $rating = round($arrAmount/$count);
                $remains = 5 - $rating;
            } else {
                $count = 0;
                $remains = 5;
            }

            // Трансформация цены

            $formatted_price = number_format($quest_price, 0, '.', ' ');
        } else {
            header('Location: 404.html');
        }
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
    <script src="js/jquery.validate.min.js" defer></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js" defer></script>
    <script src="js/maskedinput.min.js" defer></script>
    <script src="js/script.js" defer></script>
    <script src="js/pop-ups.js" defer></script>
    <script src="js/navMenu.js" defer></script>
    <script src="js/quest/setTheDate.js" defer></script>
    <script src="js/quest/setPlayersAge.js" defer></script>
    <script src="js/quest/setActors.js" defer></script>
    <script src="js/quest/costChange.js" defer></script>
    <script src="js/quest/submitQuest.js" defer></script>
    <script src="js/quest/legend.js" defer></script>
    <script src="js/quest/slickSettings.js" defer></script>
</head>

<body>
    <!-- <nav>
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
    </nav> -->

    <div class="overlay" style="display: block"></div>

    <div class="phone--confirmation">
        <div class="phone--wrapper">
            <div class="phone__title">Упс.. Номер не подтверждён!</div>
            <label for="" class="label__style--default">ВАШ ДЕЙСТВИТЕЛЬНЫЙ НОМЕР ТЕЛЕФОНА</label>
            <input type="text" class="input__style--default" placeholder="В ФОРМАТЕ 79XXXXXXXXX" maxlenth="3">
            <div class="button__wrapper">
                <div class="button__wrapper--text">ПОДТВЕРДИТЬ</div>
                <button class="button__wrapper--blur"></button>
            </div>
        </div>
    </div>
    
    <dialog class="nav--menu" id="dialog" open>
        <div class="nav__text--account"><?=mb_strtoupper($_COOKIE['nickname'])?></div>
        <div class="nav__button--xmark" id="closeDialog"><i class='fa-solid fa-xmark'></i></div>
        <div class="nav__stroke"></div>
        <a href="personal_account.php" class="nav__button--quests button--block noselect">КВЕСТЫ</a>
        <div class="nav__button--history button--block noselect">ИСТОРИЯ ЗАКАЗОВ</div>
        <div class="nav__button--settings button--block noselect">НАСТРОЙКИ</div>
        <div class="nav__stroke"></div>
        <div class="nav__button--support button--block noselect">СВЯЗЬ С ПОДДЕРЖКОЙ</div>
        <div class="nav__button--admin button--block noselect">АДМИН-ПАНЕЛЬ</div>
        <div class="nav__button--logout button--block noselect" id="logout">ВЫХОД</div>
    </dialog>
    

    <section class="quest">
        <a href="personal_account.php" class="quest__back noselect"><i class="fa-solid fa-angle-left"></i> НАЗАД</a>
        <div class="quest__container container">

            <div class="quest__confirm">
                <div class="quest__about">
                    <div class="quest__wrapper">
                        <div class="quest__quest--title">КВЕСТ-ИГРА <span>«<?php echo mb_strtoupper($quest_name, 'UTF-8'); ?>»</span></div>
                        <div class="quest__quest--genre">ЖАНР: <?php echo mb_strtoupper($quest_genre, 'UTF-8'); ?></div>
                        <div class="quest__quest--rating">
                            <div class="quest__rating--text">РЕЙТИНГ: </div>
                            <div class="quest__rating--stars">
                                <?php 
                                    echo starsGenerate($rating, $lightStars, $lightStarImg);
                                    echo starsGenerate($remains, $darkStars, $darkStarImg);
                                ?>
                            </div>
                            <div class="quest__rating--total">(ВСЕГО ОЦЕНОК: <?php echo $count; ?>)</div>
                        </div>

                        <div class="quest__imgs" id="photo-slider">
                            <img src="<?php echo $quest_first; ?>" alt="<?php echo $quest; ?>">
                            <img src="<?php echo $quest_second; ?>" alt="<?php echo $quest; ?>">
                            <img src="<?php echo $quest_third; ?>" alt="<?php echo $quest; ?>">
                        </div>

                        <div class="quest__quest--legend">
                            <div class="quest__legend--button" id="alert">ЛЕГЕНДА КВЕСТ-ИГРЫ</div>
                        </div>
                    </div>

                    <dialog class="quest__legend--block">
                        <div class="quest__legend--xmark" id="legend--xmark"><i class='fa-solid fa-xmark'></i></div>
                        <div class="quest__legend--title">ЛЕГЕНДА ИГРЫ «<?php echo mb_strtoupper($quest_name, 'UTF-8'); ?>»</div>
                        <div class="quest__legend--stroke"></div>
                        <div class="quest__legend--content"><?php echo $quest_legend; ?></div>
                    </dialog>
                </div>

                <!-- ============ ФОРМА ЗАПИСИ ============ -->

                <form action="php/order_quest.php" method="POST" class="quest__form" id="quest__form--order">

                    <!-- ============ ДАТА ЗАПИСИ ============ -->

                    <div class="quest__form--dateposition">
                        <label for="date__input" class="label__style--default quest__input--title quest__title--date noselect">ДАТА ПРОВЕДЕНИЯ ИГРЫ <span>*</span></label>
                        <div class="input__style--default quest__form--date" id="date__input" data-day="" data-time="">НАЖМИТЕ, ЧТОБЫ УСТАНОВИТЬ ДАТУ</div>

                        <table class='quest__selectform--table close__modal' id='date__table'>
                            <?=showTheDate()?>
                            
                        </table>
                        <div class="quest__table--overlay">
                            <div class="quest__overlay--text noselect">Увы, но на этот день свободного времени нет</div>
                            <div class="quest__overlay--button button__wrapper noselect">
                                <div class="button__wrapper--text">ПРОДОЛЖИТЬ</div>
                                <div class="button__wrapper--blur"></div>
                            </div>
                        </div>
                    </div>

                    <!-- ============ ИГРОКИ ============ -->

                    <div class="quest__form--playersposition">
                        <div class="quest__form--title">
                            <label for="players" class="label__style--default quest__input--title quest__title--players noselect">КОЛИЧЕСТВО ИГРОКОВ <span>*</span></label>
                            <?php 
                                if($areAdditional) {
                                    echo '<div class="quest__input--info quest__info--players" id="help--players" data-id="players">?</div>';
                                }
                            ?>
                        </div>
                        <input name="players" type="range" min="<?php echo $quest_min; ?>" max="<?php echo $quest_max; ?>" value="<?php echo $quest_min; ?>" step="1" class="quest__form--players" data-additional="<?php echo $quest_additional; ?>" id="players">
                        <div class="quest__input--substrate">
                            <?php
                                echo '<div class="quest__players--strokes">';
                                for ($i = $quest_min; $i <= $quest_max; $i++) {
                                    echo '<div class="quest__stroke--item noselect"></div>';
                                }
                                echo '</div>';
                                echo '<div class="quest__players--nums">';
                                for ($i = $quest_min; $i <= $quest_max; $i++) {
                                    
                                    echo (isset($quest_additional) && $i >= $quest_additional) ? '<div class="quest__nums--item quest__players--extra noselect">'. $i .'</div>' : '<div class="quest__nums--item noselect">'. $i .'</div>';
                                }
                                echo '</div>';
                            ?>
                        </div>
                    </div>

                    <?php 
                        if ($areAdditional) {
                            echo '
                            <div class="quest__popup--content quest__popup--players" id="popup--players">
                                <div class="quest__popup--wrapper">
                                    <div class="quest__popup--string">Начиная с <span>'. $quest_additional .'-ого</span> человека идёт дополнительная оплата в <span>500₽ за дополнительную персону</span>.</div>
                                </div>
                            </div>
                            ';
                            
                        }
                    ?>

                    <!-- ============ ВОЗРАСТ ============ -->

                    <div class="quest__form--ageposition">
                        <label for="age" class="label__style--default quest__input--title quest__title--age noselect">СРЕДНИЙ ВОЗРАСТ КОМАНДЫ <span>*</span></label>
                        <div class="input__style--default quest__form--age" id="age" data-age="">
                            <div class="quest__age--text noselect">НАЖМИТЕ, ЧТОБЫ УКАЗАТЬ ВОЗРАСТ</div>
                            <div class="quest__age--angle noselect"><i class="fa-solid fa-angle-down"></i></div>
                        </div>

                        <ul class="quest__form--list quest__age--list close__modal">
                            <li class="quest__list--item">
                                <div class="quest__item--text">ДЕТИ</div>
                                <div class="quest__item--age">8-13 ЛЕТ</div>
                            </li>
                            <li class="quest__list--item">
                                <div class="quest__item--text">ПОДРОСТКИ</div>
                                <div class="quest__item--age">14-17 ЛЕТ</div>
                            </li>
                            <li class="quest__list--item">
                                <div class="quest__item--text">ВЗРОСЛЫЕ</div>
                                <div class="quest__item--age">18+ ЛЕТ</div>
                            </li>
                            <li class="quest__list--item">
                                <div class="quest__item--text">СМЕШАННАЯ КОМАНДА</div>
                            </li>
                        </ul>
                    </div>

                    <!-- ============ АКТЁРЫ ============ -->

                    <div class="quest__form--actorsposition">
                        <div class="quest__form--title">
                            <label for="actors" class="label__style--default quest__input--title quest__title--actors noselect">НАЛИЧИЕ АКТЁРОВ <span>*</span></label>
                            <div class="quest__input--info quest__info--actors" id="help--actors" data-id="actors">?</div>
                        </div>
                        <div class="input__style--default quest__form--actors" id="actors" data-actors="">
                            <div class="quest__actors--text noselect">НАЖМИТЕ, ЧТОБЫ ВЫБРАТЬ АКТЁРОВ</div>
                            <div class="quest__actors--angle"><i class="fa-solid fa-angle-down"></i></div>
                        </div>
                        <ul class="quest__form--list quest__actors--list close__modal">
                            <li class="quest__list--item quest__actors--item">
                                <div class="quest__item--text">БЕЗ АКТЁРОВ</div>
                            </li>
                            <li class="quest__list--item quest__actors--item">
                                <div class="quest__item--text">АКТЁР-ПОМОЩНИК</div>
                                <div class="quest__item--cost">+ 500<span>₽</span></div>
                            </li>
                            <li class="quest__list--item quest__actors--item">
                                <div class="quest__item--text">АКТЁРЫ</div>
                                <div class="quest__item--cost">+ 500<span>₽</span></div>
                            </li>
                        </ul>
                    </div>

                    <div class="quest__popup--content quest__popup--actors" id="popup--actors">
                        <div class="quest__popup--wrapper">
                            <div class="quest__popup--string"><span>Без актеров</span> - подходит для детей 9-12 лет, когда в команде игроков присутствует взрослый.</div>
                            <div class="quest__popup--string"><span>Актёр-помощник</span> - персонаж, помогающий проходить квест, подходит для детей 9-14 лет.</div>
                            <div class="quest__popup--string"><span>Актёры</span> - персонажи, добавляющие динамики в игру, подходит для опытных команд от 14+.</div>
                        </div>
                    </div>

                    <!-- ============ ПРОМОКОД ============ -->

                    <div class="quest__form--promoposition">
                        <label for="promo" class="label__style--default quest__input--title quest__title--promo noselect">ПРОМОКОД (НЕОБЯЗАТЕЛЬНО)</label>
                        <input type="text" class="input__style--default quest__form--promo" id="promo" placeholder="ВВЕДИТЕ СЮДА ПРОМОКОД">
                    </div>

                    <!-- ============ ПРАВИЛА ============ -->

                    <div class="quest__form--rulesposition">
                        <input type="checkbox" class="quest__form--rules" id="rules" >
                        <label for="rules" class="label__style--default quest__input--title quest__title--rules noselect">
                            Я подтверждаю, что ознакомлен(а) со всеми <a href="#" class="quest__rules--link">правилами</a>
                        </label>
                    </div>

                    <!-- ============ ПРАЙС И ЗАКАЗ КВЕСТА ============ -->

                    <div class="quest__form--orderposition">
                        <div class="quest__form--cost">СТОИМОСТЬ: <span class="cost__result"><?php echo $formatted_price; ?></span><span class="cost__ruble--color">₽</span></div>

                        <div class="button__wrapper">
                            <div class="button__wrapper--text">ЗАКАЗАТЬ</div>
                            <button class="button__wrapper--blur quest__button--submit"></button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <?php

        function showTheDate() {
            date_default_timezone_set('Europe/Moscow');

            $currentDate = date('Y-m-d'); // текущая дата
            $currentDay = date('d'); // текущий день
            $firstDayOfMonth = date('Y-m-01', strtotime($currentDate)); // первый день месяца
            $dayOfWeek = date('w', strtotime($firstDayOfMonth)); // день недели месяца, где 0 - воскресенье, 6 - суббота
            $daysInMonth = date('t', strtotime($currentDate)); // кол-во дней в месяце
            $monthNoCurrent = date('m', strtotime($currentDate));

            // СЛЕДУЮЩИЕ МЕСЯЦЫ!

            $nextDate = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d')))); // следующая дата
            $firstDayOfNextMonth = date('Y-m-01', strtotime($nextDate));
            $dayOfNextWeek = date('w', strtotime($firstDayOfNextMonth));
            $daysInNextMonth = date('t', strtotime($nextDate)); // кол-во дней в месяце
            $monthNoNext = date('m', strtotime($nextDate));

            // ------------------
            
            if($dayOfWeek != 0) // для лучшего отображения тогда, когда месяц начинается с понедельника/воскресенья, А ТАКЖЕ ДЛЯ ЛУЧШЕГО ОТОБРАЖЕНИЯ ПУСТЫХ МЕСТ В КАЛЕНДАРЕ В САМОМ НАЧАЛЕ МЕСЯЦА!!!!!
                $dayOfWeek--;
            else
                $dayOfWeek = $dayOfWeek + 6;

            // ~~~~~~~~

            if($dayOfNextWeek != 0)
                $dayOfNextWeek--;
            else
                $dayOfNextWeek = $dayOfNextWeek + 6;

            // ------------------
                
            $currentMonthData = date('Y-m'); // название текущего месяца
            $nextMonthData = date('Y-m', strtotime('+1 month')); // название следующего месяца

            $monthArr = [
                'ЯНВАРЬ',
                'ФЕВРАЛЬ',
                'МАРТ',
                'АПРЕЛЬ',
                'МАЙ',
                'ИЮНЬ',
                'ИЮЛЬ',
                'АВГУСТ',
                'СЕНТЯБРЬ',
                'ОКТЯБРЬ',
                'НОЯБРЬ',
                'ДЕКАБРЬ'
            ];
            $currentMonth = date('n', strtotime($currentDate)) - 1; // текущий месяц
            $nextMonth = date('n', strtotime($currentDate)); // следующий месяц

            // ---- МЕСЯЦЫ ---- //

            echo "<thead class='quest__table--title quest__day--select'><th colspan='7' class='quest__title--month noselect'><span class='quest__month--item quest__month--first quest__month--isactive' data-month-no='" . $monthNoCurrent . "' data-month='" . $currentMonthData . "'>$monthArr[$currentMonth]</span> &nbsp <span class='quest__month--item quest__month--second' data-month-no='" . $monthNoNext . "' data-month='" . $nextMonthData . "'>$monthArr[$nextMonth]</span></th></thead>";

            // ---- ДНИ НЕДЕЛИ ---- //

            echo "<tbody class='quest__table--content quest__day--select'><tr class='quest__content--subtitle'><th class='quest__subtitle--item noselect'>ПН</th><th class='quest__subtitle--item noselect'>ВТ</th><th class='quest__subtitle--item noselect'>СР</th><th class='quest__subtitle--item noselect'>ЧТ</th><th class='quest__subtitle--item noselect'>ПТ</th><th class='quest__subtitle--item noselect'>СБ</th><th class='quest__subtitle--item noselect'>ВС</th></tr>";

            // [!] ГЕНЕРАЦИЯ ТЕКУЩЕГО МЕСЯЦА [!]

            echo "<tr class='quest__content--calendar quest__calendar--current'>";
    
            for($i = 0; $i < $dayOfWeek; $i++) {
                echo "<td class='quest__calendar--null'></td>";
            }
    
            for($day = 1; $day <= $daysInMonth; $day++) {
                if($day < $currentDay) 
                    echo "<td class='quest__calendar--day quest__day--expired noselect'>$day</td>";
                else
                    echo "<td class='quest__calendar--day quest__day--actual noselect' data-no='$day'>$day</td>";
                
                if ($day != 30 && $day != 31) {
                    if (($dayOfWeek + $day) % 7 == 0) {
                        echo "</tr><tr class='quest__content--calendar quest__calendar--current'>";
                    }
                }
            }
    
            if (($dayOfWeek + $daysInMonth) % 7 != 0) {
                for ($i = 0; ($dayOfWeek + $daysInMonth + $i) % 7 != 0; $i++) {
                    echo "<td class='quest__calendar--null'></td>";
                }
            }

            echo "</tr>";

            // [!] ГЕНЕРАЦИЯ СЛЕДУЮЩЕГО МЕСЯЦА [!]

            echo "<tr class='quest__content--calendar quest__calendar--next'>";

            for($i = 0; $i < $dayOfNextWeek; $i++) {
                echo "<td class='quest__calendar--null'></td>";
            }

            for($day = 1; $day <= $daysInNextMonth; $day++) {
                echo "<td class='quest__calendar--day quest__day--actual noselect' data-no='$day'>$day</td>";

                if ($day != 30 && $day != 31) {
                    if(($dayOfNextWeek + $day) % 7 == 0) {
                        echo "</tr><tr class='quest__content--calendar quest__calendar--next'>";
                    }
                }
            }
    
            if (($dayOfNextWeek + $daysInNextMonth) % 7 != 0) {
                for ($i = 0; ($dayOfNextWeek + $daysInNextMonth + $i) % 7 != 0; $i++) {
                    echo "<td class='quest__calendar--null'></td>";
                }
            }
            
            echo "</tbody>";

            // [!] ГЕНЕРАЦИЯ ВРЕМЕНИ [!]

            // ---- МЕСЯЦ ---- //

            echo "<thead class='quest__table--title'><th colspan='7' class='quest__title--month quest__time--select noselect'><span class='quest__title--back'><i class=\"fa-solid fa-angle-left\"></i></span><span class='quest__title--item'>29 ФЕВРАЛЯ</span></th></thead>";

            // ---- СУБТАЙТЛ ОБЫЧНОЕ ВРЕМЯ ---- //

            echo "<tbody class='quest__table--content quest__time--select'><tr class='quest__content--subtitle quest__subtitle--time'><th class='quest__subtitle--item noselect'>ЖЕЛАЕМОЕ ВРЕМЯ</th></tr>";

            // ---- ОБЫЧНОЕ ВРЕМЯ ---- //

            echo "<tr class='quest__content--time'><td class='quest__time--item noselect'>10:00</td><td class='quest__time--item noselect'>12:00</td><td class='quest__time--item noselect'>14:00</td></tr><tr class='quest__content--time'><td class='quest__time--item noselect'>16:00</td><td class='quest__time--item noselect'>18:00</td><td class='quest__time--item noselect'>20:00</td></tr>";

            // ---- СУБТАЙТЛ ДОПОЛНИТЕЛЬНОЕ ВРЕМЯ ---- //

            echo "<tr class='quest__content--subtitle quest__subtitle--time'><th class='quest__subtitle--item noselect'>ДОПОЛНИТЕЛЬНОЕ ВРЕМЯ</th></tr>";

            // ---- ДОПОЛНИТЕЛЬНОЕ ВРЕМЯ ---- //

            echo "<tr class='quest__content--time'><td class='quest__time--item noselect' id='time--additional'>22:00</td></tr>";

            // -------------
    
            echo "</tr></tbody>";
        }

        $conn->close();
    ?>
</body>
</html>