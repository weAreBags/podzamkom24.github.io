$(document).ready(function() {
    var date

    $('#date__input').on('click', function() {
        if ($('.quest__calendar--current').length == 6) {
            $('#date__table').css('height', '455px')
        }
        $('.overlay').fadeIn('fast')
        $('#date__table').fadeIn('fast').css('display', 'flex')
    })

    $('.quest__month--item').on('click', function() {
        if (!$(this).hasClass('quest__month--isactive')) {
            var index = $(this).index()

            switch (index) {
                case 0:
                    $(this).addClass('quest__month--isactive')
                    $(this).siblings().removeClass('quest__month--isactive')
                    if ($('.quest__calendar--current').length == 6) {
                        $('.quest__selectform--table').animate({height: 455}, 200)
                    } else {
                        $('.quest__selectform--table').animate({height: 400}, 200)
                    }
                    $('.quest__calendar--next').css('display', 'none')
                    $('.quest__calendar--current').fadeIn().css('display', 'flex')
                    break
                case 1:
                    $(this).addClass('quest__month--isactive')
                    $(this).siblings().removeClass('quest__month--isactive')
                    if ($('.quest__calendar--next').length == 6) {
                        $('.quest__selectform--table').animate({height: 455}, 200)
                    } else {
                        $('.quest__selectform--table').animate({height: 400}, 200)
                    }
                    $('.quest__calendar--current').css('display', 'none')
                    $('.quest__calendar--next').fadeIn().css('display', 'flex')
                    break
            }
        }
        
    })

    $('.quest__day--actual').on('click', function() {
        var day = $(this).data('no')
        var month = $('.quest__month--isactive').data('month')
        
        if(day >= 1 && day <= 9) {
            redoneDay = '0' + day
        } else {
            redoneDay = day
        }
        date = month + '-' + redoneDay

        $.ajax({
            url: 'php/checkTheDate.php',
            type: 'POST',
            dataType: 'json',
            data: {
                date: date
            },
            success: function(response) {
                const availableTimes = $(response.result)
                const timeItems = $('.quest__time--item')
                const checkTime = response.result.every(element => element === true)
                const monthArray = [
                    'ЯНВАРЯ',
                    'ФЕВРАЛЯ',
                    'МАРТА',
                    'АПРЕЛЯ',
                    'МАЯ',
                    'ИЮНЯ',
                    'ИЮЛЯ',
                    'АВГУСТА',
                    'СЕНТЯБРЯ',
                    'ОКТЯБРЯ',
                    'НОЯБРЯ',
                    'ДЕКАБРЯ'
                ]
                const monthArrayNew = $.makeArray(monthArray)
                
                if (checkTime) {
                    var overlayElement = $('.quest__table--overlay')
                    var overlayCloseElement = $('.button__wrapper--blur')

                    function closeOverlay() {
                        overlayElement.fadeOut('fast')
                    }
                    overlayCloseElement.on('click', closeOverlay)
                    overlayElement.fadeIn('fast', function() {
                        setTimeout(closeOverlay, 10000)
                    }).css('display', 'flex')
                } else {
                    const arrayIndex = $('.quest__month--isactive').data('month-no') - 1
                    const textMonth = monthArrayNew[arrayIndex]

                    $('.quest__title--item').html(day + ' ' + textMonth)
                    $('.quest__day--select').css('display', 'none')
                    $('.quest__time--select').fadeIn()
                    $('.quest__selectform--table').animate({height: 380}, 200)
                    $.each(timeItems, function(index, element) {
                        if (availableTimes[index]) {
                            $(element).addClass('quest__time--busy')
                        } else {
                            $(element).addClass('quest__time--free')
                        }
                    })
                }
            }
        })
    })

    function getBackCalendar() {
        $('.quest__time--select').css('display', 'none')
        $('.quest__day--select').fadeIn()
        $('.quest__selectform--table').animate({height: 400}, 200)
        $('.quest__time--item').removeClass('quest__time--busy').removeClass('quest__time--free')
    }

    $('.quest__title--back').on('click', getBackCalendar)

    $('.quest__time--item').on('click', function() {
        if ($(this).hasClass('quest__time--free')) {
            var dayWithMonth = $('.quest__title--item').text()
            var time = $(this).text()

            $('#date__input').html(dayWithMonth + ' ' + time).css('color', 'white').css('font-weight', '700').attr('data-day', date).attr('data-time', time)
            $('.overlay, .close__modal').fadeOut('fast')

            getBackCalendar()
        }
    })
})