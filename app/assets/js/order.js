document.addEventListener('DOMContentLoaded', function () {
    $('#warehouses').autocomplete({
        source: []
    });

    $('#city').autocomplete({
        source: function (request, response) {
            if (request.term.length < 3) {
                return;
            }
            let selectWarehouse = document.getElementById('warehouse');
            selectWarehouse.innerHTML = '';
            $('#warehouses').autocomplete({
                source: []
            });

            $.ajax({
                method: 'POST',
                url: '/order/getCities',
                data: {city: request.term},
                success: function (data) {
                    data = JSON.parse(data);
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $('#city').val(ui.item.label);

            $.post('/order/getWarehouses', {cityRef: ui.item.value}, function (data) {
                data = JSON.parse(data);

                $('#warehouse').autocomplete({
                    source: function (request, response) {
                        const filtered = $.ui.autocomplete.filter(data, request.term);
                        response(filtered.slice(0, 50));
                    },
                    minLength: 0,
                    select: function (event, ui) {
                        $('#warehouse').val(ui.item.label);
                    }
                });
            });
            return false;
        }
    });

    $('#warehouse').on('click', function () {
        if ($(this).data('uiAutocomplete')) {
            $(this).autocomplete('search', '');
        }
    });

    $('#phone').mask('+380(00) 000-00-00');
});