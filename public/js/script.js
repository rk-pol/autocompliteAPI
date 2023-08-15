$(document).ready(function() {

    $( function() {
        $( "#inputAutocomplete" ).autocomplete({
            source : function( request, response ) {
                $.ajax({
                    url: "autocomplete",
                    dataType: "json",
                    type: 'POST',
                    data: {
                        keyword: request.term
                    },
                    success: function (data) {
                        if (data.length > 0 ) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.name,
                                    value: item.id,
                                    type: item.type
                                }
                            }))
                        }
                    }
                });
            },
            autoFocus: true,
            delay: 530,
            minLength: 2,
            focus: function( event, ui ) {
                $('ui .item-text').css('colore', 'red')
            }

        }).autocomplete("instance")._renderItem = function(ul, item) {
            var listItem = $(`
                           <div class="list-line-wrapper">
                               <div class="list-item-container">
                                <div class="item-wrapper">
                                  <img class="img-svg ${item.type === 0 ? 'plane-svg': (item.type === 1 ? 'location-svg' : '')}" src="./public/image/svg/${item.type === 0 ? 'plane.svg' : (item.type === 1 ? 'location.svg' : 'seaport.svg')}">
                                  <div class="item-text">${item.label}</div>
                                </div>                         
                              </div>
                              <div class="ui-menu-hline-wrapper"><hr class="ui-menu-hline"></div>
                            </div>
                          
                          
            `);
            return $("<li>").append(listItem).appendTo(ul);
        };
    });
})