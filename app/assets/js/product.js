document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('add-to-cart')) {
            e.preventDefault();
            let productId = e.target.dataset.id;
            $.post('/cart/add', {id: productId}, function (data) {
                data = JSON.parse(data);
                const newButton = document.createElement('button');
                newButton.textContent = data['textButton'];
                let classList;
                if (e.target.classList.contains('btn-lg')) {
                    classList = 'btn btn-secondary btn-lg mt-3 in-cart';
                } else {
                    classList = 'btn btn-secondary btn-sm mt-2 in-cart';
                }
                newButton.className = classList;

                e.target.parentNode.replaceChild(newButton, e.target);

                document.querySelectorAll('.cart').forEach((el) => {
                    el.innerHTML = data['count'];
                });
            });
        } else if(e.target.classList.contains(('in-cart'))) {
            e.preventDefault();
            location.href = '/cart';
        }
    });
});