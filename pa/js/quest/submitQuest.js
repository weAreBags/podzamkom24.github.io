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
                'isDateAccepted': '● Введена некорректная дата',
                'isTimeAccepted': '● Введено некорректное время',
                'isAgeAccepted': '● Выбран некорректный возраст',
                'isActorsAccepted': '● Выбрана некорректная группа актёров'
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

                        var status = (responce.error) ? 0 : 1 // надо как-то на сервере поставить status 0 при ошибке, а при алёрте просто 1 и + вывести контент надо

                        alertInteraction(status, responce.request)

                        function alertInteraction(status, content) { // status: 0 - error | 1 - alert
                            var alertBlock = $('.notification__block')
                            var alertTitle = $('.notification__title')
                            var alertDescr = $('.notification__descr')

                            if (status) {
                                alertBlock.removeClass('notification__error').addClass('notification__alert')
                                alertTitle.html('УВЕДОМЛЕНИЕ')
                            } else {
                                alertBlock.removeClass('notification__alert').addClass('notification__error')
                                alertTitle.html('ВНУТРЕННЯЯ ОШИБКА')
                            }

                            alertDescr.html(content)
                            
                            alertBlock.on('click', function() {
                                alertBlock.fadeOut()
                            })

                            alertBlock.fadeIn(function () { 
                                setTimeout(function() {
                                    alertBlock.fadeOut()
                                }, 10000)
                            })
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'Произошла ошибка при выполнении запроса.'
                        if (xhr.status === 500) {
                            errorMessage += ' Ошибка сервера: ' + xhr.statusText
                        } else if (xhr.status === 404) {
                            errorMessage += ' Страница не найдена.'
                        } else {
                            errorMessage += ' Статус ошибки: ' + xhr.status
                        }
                        console.error(errorMessage)
                        alert(errorMessage)
                    }
                })
            } else {
                var fullError = ''
                errors.forEach(function(error) {
                    fullError = fullError + '\n' + errorMessages[error]
                })
                alert('Найдены ошибки: ' + fullError)
            }
        } else {
            console.log('miss')
        }
        
    })
})