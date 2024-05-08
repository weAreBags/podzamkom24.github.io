$(document).ready(function() {
    $('.history__button--info').click(function(e) {
        e.preventDefault()

        var history_block = $(this).closest('.history__block')
        var code = history_block.attr('data-history')
        console.log(code)

        $.ajax({
            url: 'php/check_info.php',
            method: 'POST',
            dataType: 'json',
            data: {
                code: code
            },
            success: function(responce) {
                var statusResponce = responce.request[0]

                if(!statusResponce) {
                    var errorMessage = responce.request[1]
                    alertInteraction(false, errorMessage)
                } else {
                    var buttonActivity = responce.request['button']

                    switch (buttonActivity) {
                        case 'review':
                            $('.history__button--text').html('ОСТАВИТЬ ОТЗЫВ').addClass('history__button--review').removeClass('history__button--cancel')
                            $('.history__button--activity').addClass('history__button--review').removeClass('history__button--cancel')
                            $('.history__button--wrapper').css('display', 'block')
                            $('.history__info--block').css('height', '540px')
                            break
                        case 'cancel':
                            $('.history__button--text').html('ОТМЕНИТЬ ЗАПИСЬ').addClass('history__button--cancel').removeClass('history__button--review')
                            $('.history__button--activity').addClass('history__button--cancel').removeClass('history__button--review').attr('id', 'cancel')
                            $('.history__button--wrapper').css('display', 'block')
                            $('.history__info--block').css('height', '540px')
                            break
                        case 'none':
                            $('.history__button--wrapper').css('display', 'none')
                            $('.history__info--block').css('height', '450px')
                            break
                    }

                    setData('quest_name', '.history__info--quest span')
                    setData('date_time', '.history__info--date span')
                    setData('players', '.history__info--players span')
                    setData('age', '.history__info--age span')
                    setData('actors', '.history__info--actors span')
                    setData('status', '.history__info--status span')
                    setData('code', '.history__info--code span')
                    $('.history__info--code').attr('data-code', responce.request['code'])
                    
                    $('.history__info--block, .overlay').fadeIn('fast').css('display', 'flex')

                    function setData(data, htmlClass) {
                        var text = responce.request[data]

                        $(htmlClass).text(text)
                    }
                }
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
    })
})