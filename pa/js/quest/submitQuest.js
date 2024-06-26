$(document).ready(function() {
    $('#quest__form--order').submit(function(event) {
        event.preventDefault()

        var dataDay = $('#date__input').attr('data-day')
        var dataTime = $('#date__input').attr('data-time')
        var players = $('#players').val()
        var dataAge = $('#age').attr('data-age')
        var dataActors = $('#actors').attr('data-actors')
        var promocode = $('#promo').val()
        var checkbox = $('#rules').prop('checked')

        if (dataDay && dataTime && dataAge && dataActors && checkbox) {
            var ageArray = ['child', 'teens', 'adult', 'mixed', '12312']
            var actorsArray = ['wa', 'as', 'ac', '12']

            function isValidDate(date) {
                return /^\d{4}-\d{2}-\d{2}$/.test(date)
            }
            
            function isValidTime(time) {
                return /^\d{2}:\d{2}$/.test(time)
            }
            
            function isInArray(value, array) {
                return array.includes(value)
            }

            var validationResult = {
                'isDateAccepted': isValidDate(dataDay),
                'isTimeAccepted': isValidTime(dataTime),
                'isAgeAccepted': isInArray(dataAge, ageArray),
                'isActorsAccepted': isInArray(dataActors, actorsArray)
            }

            var errorMessages = {
                'isDateAccepted': 'Введена некорректная дата',
                'isTimeAccepted': 'Введено некорректное время',
                'isAgeAccepted': 'Выбран некорректный возраст',
                'isActorsAccepted': 'Выбрана некорректная группа актёров'
            }

            var errors = []

            for (var key in validationResult) {
                if (!validationResult[key]) {
                    errors.push(key)
                }
            }

            var getQuestParam = function(url) {
                var parser = document.createElement('a')
                parser.href = url

                var params = parser.search.substring(1).split('&')
                
                for (var i = 0; i < params.length; i++) {
                    var pair = params[i].split('=')
                    if (pair[0] === 'quest') {
                        return decodeURIComponent(pair[1])
                    }
                }
                return null
            }

            var quest = getQuestParam(window.location.href)

            if(errors.length === 0) {
                $.ajax({
                    url: 'php/order_quest.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        quest: quest,
                        day: dataDay,
                        time: dataTime,
                        players: players,
                        age: dataAge,
                        actors: dataActors,
                        promocode: promocode
                    },
                    success: function(responce) {
                        var status = responce.request[0]
                        var message = responce.request[1]

                        alertInteraction(status, message)
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            errorMessage = 'Страница обработки запроса не найдена. Пожалуйста, обновите страницу или обратитесь в техническую поддержку.'
                        } else {
                            errorMessage = 'Статус ошибки: ' + xhr.status + '. Пожалуйста, обновите страницу или обратитесь в тех. поддержку.'
                        }

                        alertInteraction(false, errorMessage)
                    }
                })
            } else {
                var fullError = ''
                errors.forEach(function(error) {
                    fullError += ' ● ' + errorMessages[error]
                })
                
                alertInteraction(false, fullError)
            }
        } else {
            message = 'Вы заполнили не все поля. Пожалуйста, перепроверьте данные и повторите попытку.'
            alertInteraction(false, message)
        }
        
    })
})