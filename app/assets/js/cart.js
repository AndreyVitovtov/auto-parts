document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('change-count-product')) {
            let type = e.target.dataset.type;
            let id = e.target.dataset.id;
            let count = document.getElementById('cart-count-product-' + id);
            let countProduct;
            switch (type) {
                case 'plus':
                    countProduct = parseInt(count.innerHTML) + 1;
                    count.innerText = countProduct;
                    break;
                case 'minus':
                    countProduct = parseInt(count.innerHTML) - 1;
                    count.innerText = countProduct;
                    if (countProduct === 0) {
                        document.getElementById('cart-product-' + id).remove();
                    }
                    break;
            }
            $.post('/cart/changeCountProduct', {id: id, count: countProduct}, function (data) {
                data = JSON.parse(data);
                document.querySelector('.cart-total span').innerText = data.total;
                document.querySelectorAll('.cart').forEach((el) => {
                    if (countProduct === 0) {
                        el.innerHTML = parseInt(el.innerHTML) - 1;
                    }
                });
            });
        } else if (e.target.classList.contains('delete-from-cart')) {
            let id = e.target.dataset.id;
            $.post('/cart/deleteFromCart', {id: id}, function (data) {
                data = JSON.parse(data);
                document.querySelector('.cart-total span').innerText = data.total;
                document.getElementById('cart-product-' + id).remove();
                document.querySelectorAll('.cart').forEach((el) => {
                    el.innerHTML = data['count'];
                });
            });
        }
    });
});