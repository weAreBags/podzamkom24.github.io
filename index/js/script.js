$(document).ready(function(){

    $('.questsButton').on('click', function() {
        $('.menu').fadeOut(function() {
            setTimeout(function() {
                $('.quests').fadeIn();
            }, 10);
        });
    });
    

    // Предположим, у нас есть массив с информацией о квестах
    var quests = [
        {
            name: "КВЕСТ-ИГРА «ВИРУС»",
            genre: "Жанр: ХОРРОР",
            legend: "Этот объект давным-давно перестали отмечать на картах, а в военных отчетах его указывали, как крайне опасный. Основной задачей этой лаборатории было исследование нового оружия массового поражения путем выведения вируса, который морально и физически влияет на человека. Вас вызвали, как военных биологов, чтобы вы вместе смогли завершить разработку этих вирусов, но услышав разговоры персонала, вы понимаете, что прибыли сюда с совершенно иной целью... ",
            cost: "Цена: 4 500₽"
        },
        {
            name: "КВЕСТ-ИГРА «ПОБЕГ»",
            genre: "Жанр: ТРИЛЛЕР",
            legend: "Вас ошибочно обвинили в самом ужасном преступлении и поместили в камеры смертников. Ровно через 1,5 часа вас посадят на электрический стул! По чистой случайности Вы попадаете в камеру, из которой одному заключенному удалось сбежать без следов. Вдруг коридоры тюрьмы опустели, у вас появилвся шанс выбраться из заточения и спасти свою жизнь! Удастся ли вам использовать свой последний шанс - зависит только от вас.",
            cost: "Цена: 4 000₽"
        },
        {
            name: "КВЕСТ-ИГРА «СДЕЛКА С ДЬЯВОЛОМ»",
            genre: "Жанр: МИСТИКА",
            legend: "Слухи о пропащих постояльцах этого старого отеля очень быстро расползлись по нашему маленькому городку. И все же ваша команда отчаянных искателей приключений осмеливается заселиться в странный НОМЕР. Вы столкнетесь с настоящим злом! Каждый ваш шаг оставит отпечаток в истории этого старого отеля.",
            cost: "Цена: 4 500₽"
        },
        {
            name: "КВЕСТ-ИГРА «КОМА»",
            genre: "Жанр: ПЕРФОРМАНС",
            legend: "Вы - компания друзей, отправившаяся в автомобильное путешествие по рельефам горного хребта. На одном из поворотов водитель увидел посреди дороги силуэт ребёнка и резко выкрутил руль. По трагическому стечению обстоятельств, на этом участке дороги отсутствовали заградительные отбойники и автомобиль кубарем покатился по склону. К моменту жёсткой остановки все пассажиры находились уже В КОМЕ... Нужно бороться за свою жизнь... а уж выпустит ли вас Кома - этого никто не знает...",
            cost: "Цена: 4 500₽"
        },
    ];

    // Функция для обновления информации о квесте
    function updateQuestInfo(index) {
        var quest = quests[index];
        var nameParts = quest.name.split('«');
        var mainName = nameParts[0].trim();
        var spanName = '«' + nameParts[1].trim();

        // Используем fadeOut для плавного исчезновения текста
        $('.quest_name, .quest_genre, .quest_legend, .quest_cost').fadeOut(400, function() {
            $('.quest_name').contents().filter(function() {
                return this.nodeType === 3; // Node.TEXT_NODE
            })[0].nodeValue = mainName + ' ';
            $('.quest_name span').text(spanName);
            $('.quest_genre').text(quest.genre);
            $('.quest_legend').text(quest.legend);
            $('.quest_cost').text(quest.cost);

            // Используем fadeIn для плавного появления текста
            $('.quest_name, .quest_genre, .quest_legend, .quest_cost').fadeIn(400);
        });
    }


    // Обновляем информацию о квесте при нажатии на кружок
    $('.quest_circle').on('click', function() {
        if (!$(this).hasClass('is_active')) {
            $('.quest_circle').removeClass('is_active');
            $(this).addClass('is_active');
            var index = $('.quest_circle').index(this); // Получаем индекс нажатого кружка
            updateQuestInfo(index);
        };
    });

    // Обновляем информацию о квесте при нажатии на стрелку
    $('.fa-caret-left, .fa-caret-right').on('click', function() {
        var currentActive = $('.quest_circle.is_active');
        var newActive;
        if ($(this).hasClass('fa-caret-left')) {
            newActive = currentActive.prev('.quest_circle');
            if (newActive.length === 0) { // Если это был первый квест
                newActive = $('.quest_circle').last(); // Переходим к последнему квесту
            }
        } else {
            newActive = currentActive.next('.quest_circle');
            if (newActive.length === 0) { // Если это был последний квест
                newActive = $('.quest_circle').first(); // Переходим к первому квесту
            }
        }
        currentActive.removeClass('is_active');
        newActive.addClass('is_active');
        var index = $('.quest_circle').index(newActive); // Получаем индекс нового активного кружка
        updateQuestInfo(index);
    });
});

