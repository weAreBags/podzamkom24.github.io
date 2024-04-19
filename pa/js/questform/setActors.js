$(document).ready(function() {
    $('#actors').on('click', function() {
        $('.overlay, .quest__actors--list').fadeIn('fast')
    })
    
    $(".quest__actors--list .quest__list--item").click(function() {
        var index = $(this).index()
      
        switch (index) {
            case 0:
                var textActors = 'БЕЗ АКТЁРОВ'
                var idActors = 'wa'

                setActorsContent(textActors, idActors)
                break
            case 1:
                var textActors = 'АКТЁР-ПОМОЩНИК'
                var idActors = 'as'

                setActorsContent(textActors, idActors)
                break
            case 2:
                var textActors = 'АКТЁРЫ'
                var idActors = 'ac'

                setActorsContent(textActors, idActors)
                break
        }

        function setActorsContent(textActors, idActors) {
            $('.overlay').fadeOut('fast')
            $('.quest__actors--text').html(textActors).css('font-weight', '700').css('color', '#ffffff')
            $('.quest__actors--list').attr('id', idActors).fadeOut('fast')
            $('.quest__form--actors').attr('data-actors', idActors)
        }
    })
})