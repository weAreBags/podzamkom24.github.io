$(document).ready(function() {
    $('.history__button--activity').click(function(e) {
        e.preventDefault()

        var cancellationForm = `
        <div class="history__cancellation--block">
            <div class="history__cancellation--title">ПОДТВЕРДИТЕ ДЕЙСТВИЕ</div>
            <div class="history__cancellation--stroke"></div>
            <div class="history__cancellation--descr">ВЫ УВЕРЕНЫ, ЧТО ХОТИТЕ ОТМЕНИТЬ ДЕЙСТВУЮЩУЮ ЗАПИСЬ НА КВЕСТ?</div>
            <div class="history__buttons--wrapper">
                <div class="button__wrapper history__button--wrapper">
                    <div class="button__wrapper--text history__button--submit">ДА, ОТМЕНИТЬ</div>
                    <div class="button__wrapper--blur history__button--submit" id="history__button--submit"></div>
                </div>
                <div class="button__wrapper history__button--wrapper">
                    <div class="button__wrapper--text history__button--back">НАЗАД</div>
                    <div class="button__wrapper--blur history__button--back" id="history__button--back"></div>
                </div>
            </div>
        </div>
        `
        var transparentOverlay = `<div class="overlay--transparent"></div>`
        var buttonID = $(this).attr('id')

        switch(buttonID) {
            case 'cancel':
                $('body').append(cancellationForm).append(transparentOverlay)
                $('.history__info--block').fadeOut('fast')
                $('.history__cancellation--block, .overlay--transparent').fadeIn('fast')
                break
            case 'review':
                $('.history__info--wrapper').css('display', 'none')
                $('.history__info--block').animate({width: 850}, 200)
                break
            default:
                errorMessage = 'Указан неправильный индетификатор. Пожалуйста, перезагрузите страницу и повторите попытку.'
                alertInteraction(false, errorMessage)
                break
        }

        
    })

    // КНОПКА SUBMIT

    $(document).on('click', '#history__button--submit', function() {
        var code = $('.history__info--code').attr('data-code')
        
        $.ajax({
            url: 'php/quest_cancel.php',
            method: 'POST',
            dataType: 'json',
            data: {
                code: code
            },
            success: function(responce) {
                var status = responce.request[0]
                
                if(status) {
                    location.reload()
                } else {
                    var message = responce.request[1]
                    alertInteraction(status, message)
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