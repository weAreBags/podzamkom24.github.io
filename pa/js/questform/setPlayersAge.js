$(document).ready(function() {
    $('#age').on('click', function() {
        $('.overlay, .quest__age--list').fadeIn('fast')
    })
    
    $(".quest__age--list .quest__list--item").click(function() {
        var index = $(this).index()
      
        switch (index) {
            case 0:
                var textAge = 'ДЕТИ'
                var idAge = 'child'
                
                setAgeContent(textAge, idAge)
                break
            case 1:
                var textAge = 'ПОДРОСТКИ'
                var idAge = 'teens'

                setAgeContent(textAge, idAge)
                break
            case 2:
                var textAge = 'ВЗРОСЛЫЕ'
                var idAge = 'adult'

                setAgeContent(textAge, idAge)
                break
            case 3:
                var textAge = 'СМЕШАННАЯ КОМАНДА'
                var idAge = 'mixed'

                setAgeContent(textAge, idAge)
                break
        }

        function setAgeContent(textAge, idAge) {
            $('.overlay').fadeOut('fast')
            $('.quest__age--text').html(textAge).css('font-weight', '700').css('color', '#ffffff')
            $('.quest__age--list').attr('id', idAge).fadeOut('fast')
            $('.quest__form--age').attr('data-age', idAge)
        }
    })
})