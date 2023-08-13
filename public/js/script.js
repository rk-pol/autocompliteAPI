$(document).ready(function() {

    $( function() {
        $( "#inputAutocomplete" ).autocomplete({
            source : function( request, response ) {
                $.ajax({
                    url: "/autocomplete",
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
                        console.log('Data not found.')
                    }
                });
            },
            autoFocus: true,
            delay: 530,
            minLength: 2,
        }).autocomplete("instance")._renderItem = function(ul, item) {
            var item = $(`
                          <div class="list_item_container">
                            <div class="item-wrapper">
                              <img class="img-svg" src="./public/image/svg/${item.type === 0 ? 'plane.svg' : (item.type === 1 ? 'location.svg' : 'seaport.svg')}">
                              <div class="item-text">${item.label}</div>
                            </div>
                          </div>
            `);
            return $("<li>").append(item).appendTo(ul);
        };
    });
})