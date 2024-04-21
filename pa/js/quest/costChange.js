$(document).ready(function() {
    var questCost = $('.cost__result').text()
    var formattedQuestCost = parseInt(questCost.replace(/ /g, ''))

    var slider = $('#players')
    var additionalVal = $('#players').attr('data-additional')
    var additionalPlayers = 0

    var actorList = $('.quest__actors--list')
    var actorItem = $('.quest__actors--item')
    var isActorID = false
    var actorPresence = 0

    var questTime = $('.quest__time--item')
    var additionalTime = 0

    slider.on('input', function () {
        var value = $(this).val()
        
        if (additionalVal) {
            if (Number(value) >= Number(additionalVal)) {
                additionalPlayers = (value - (additionalVal - 1))*500

                let result = formattedQuestCost + additionalPlayers + actorPresence + additionalTime
                changeCost(result)
            } else {
                additionalPlayers = 0

                let result = formattedQuestCost + additionalPlayers + actorPresence + additionalTime
                changeCost(result)
            }
        }
    })

    actorItem.on('click', function() {
        var actorID = actorList.attr('id')

        if (!isActorID) {            
            if (actorID == 'as' || actorID == 'ac') {
                isActorID = true
                actorPresence = 500

                let result = formattedQuestCost + actorPresence + additionalPlayers + additionalTime
                changeCost(result)                
            }
        } else {
            if (actorID != 'as' && actorID != 'ac') {
                isActorID = false
                actorPresence = 0
                
                let result = formattedQuestCost + additionalPlayers + additionalTime
                changeCost(result)
            }
        }
    })

    questTime.on('click', function() {
        if ($(this).attr('id') == 'time--additional') {
            additionalTime = 1500

            let result = formattedQuestCost + additionalTime + additionalPlayers + actorPresence
            changeCost(result)
        } else {
            additionalTime = 0

            let result = formattedQuestCost + additionalPlayers + actorPresence
            changeCost(result)
        }
    })
    


    function changeCost(currentCost) {
        var cost = $('.cost__result')

        currentCost = currentCost.toLocaleString('ru-RU')
        $(cost).html(currentCost)
    }
})