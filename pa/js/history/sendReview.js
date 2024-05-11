$(document).ready(function() {
    var itemClass = $('.history__evaluation--item')
    var activate = 'star__style--active fa-solid'
    var disable = 'fa-regular star__style--disabled'

    // ФОРМА ДЛЯ ОТПРАВКИ НА СЕРВЕР

    $('#send_review').submit(function(e) {
        e.preventDefault()

        var content = $('#history__review--content').val()
        var evaluation = $('.history_-evaluation--item.star--selected').length

        if(content.length < 10 || content.length > 2500) {
            alert('соси')
            return // выход из функции
        }

        console.log(321)
    })

    // РЕДАКТОР ЗВЁЗД

    itemClass.hover(function(){
        var index = $(this).index()

        itemClass.eq(index).prevAll('.history__evaluation--item').addBack().addClass(activate).removeClass(disable);

        // Если у какого-то из последующих элементов есть класс star--selected, оставляем им класс activate
        itemClass.eq(index).nextAll('.history__evaluation--item.star--selected').addClass(activate).removeClass(disable);

        // Всем последующим элементам без класса star--selected добавляем класс disable
        itemClass.eq(index).nextAll('.history__evaluation--item:not(.star--selected)').addClass(disable).removeClass(activate);
    }, function(){
        var index = $(this).index()

        if(!itemClass.eq(index).hasClass('star--selected')) {
            itemClass.eq(index).prevAll('.history__evaluation--item:not(.star--selected)').addBack().addClass(disable).removeClass(activate);
        }
    })

    itemClass.on('click', function() {
        var index = $(this).index()

        if(itemClass.eq(index).hasClass('star--selected')) {
            itemClass.eq(index).nextAll('.history__evaluation--item').removeClass(activate + ' star--selected').addClass(disable)
        } else {
            itemClass.eq(index).addClass(activate + ' star--selected').removeClass(disable)
            itemClass.eq(index).prevAll('.history__evaluation--item').addClass('star__style--active fa-solid star--selected').removeClass('fa-regular star__style--disabled')
        }
    })
})