/* Search */
var products = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: '%QUERY',
        url: path + '/search/typeahead?query=%QUERY'
    }
});

products.initialize();

$("#typeahead").typeahead({
    highlight: true
}, {
    name: 'products',
    display: 'title',
    limit: 10,
    source: products
});

$('#typeahead').bind('typeahead:select', function (ev, suggestion) {
    window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
});


/* Cart */
$('body').on('click', '.add-to-cart', function (e) {
    e.preventDefault();
    let id = $(this).data('id'),
        quantity = $('.product_quantity input').val() ? $('.product_quantity input').val() : 1;

    $.ajax({
        url: '/cart/add',
        data: {id: id, quantity: quantity},
        type: 'GET',
        success: function (response) {
            showCart(response)
        }, error: function () {
            alert('Что-то пошло не так! Попробуйте ещё раз.')
        }
    });
});

$('#cart-modal .modal-body').on('click', '.delete-item', function () {
    let id = $(this).data('id');
    $.ajax({
        url: '/cart/delete',
        data: {id: id},
        type: 'GET',
        success: function (response) {
            showCart(response)
        }, error: function () {
            alert('Что-то пошло не так! Попробуйте ещё раз.')
        }
    });
});

$('.cart_items').on('click', '.delete-item', function () {
    let id = $(this).data('id');
    $.ajax({
        url: '/cart/delete',
        data: {id: id},
        type: 'GET',
        success: function () {
            document.location.reload(true);
        }, error: function () {
            alert('Что-то пошло не так! Попробуйте ещё раз.')
        }
    });
});

function showCart(cart) {
    if ($.trim(cart) == '<h3 class="text-center">Корзина пуста</h3>') {
        $('#cart-modal .modal-footer a, #cart-modal .modal-footer .remove-from-cart-btn').css('display', 'none');
    } else {
        $('#cart-modal .modal-footer a, #cart-modal .modal-footer .remove-from-cart-btn').css('display', 'inline-block');
    }
    $('#cart-modal .modal-body').html(cart);
    $('#cart-modal').modal();
    if ($('.cart-sum').text()) {
        $('.cart_price').text($('#cart-modal .cart-sum').text());
        $('.cart_count span').text($('#cart-modal .cart-quantity').text());
    } else {
        $('.cart_price').text('0 $');
        $('.cart_count span').text('0');
    }

}

function getCart() {
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: function (response) {
            showCart(response)
        }, error: function () {
            alert('Что-то пошло не так! Попробуйте ещё раз.')
        }
    });
}

function clearCart() {
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function (response) {
            showCart(response)
        }, error: function () {
            alert('Что-то пошло не так! Попробуйте ещё раз.')
        }
    });
}

function clearCartPage() {
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function () {
            document.location.reload(true);
        }, error: function () {
            alert('Что-то пошло не так! Попробуйте ещё раз.')
        }
    });
}

/* End Cart */

let inputName = $('#order-customer-name');
let inputEmail = $('#order-email');
let inputAddress = $('#order-address');
let inputComment = $('#order-comment');

let RegExpName = /^[a-zA-zа-яА-Я ]+$/;
let RegExpEmail = /^[a-zA-z0-9._]+@[a-zA-z0-9._]+\.[a-zA-z]{2,6}$/;
let RegExpMessage = /^[a-zA-Z0-9?$@#()'!,+\-=_:.&*%\s]+$/;

$(document).ready(function () {

    inputValidation(inputName, RegExpName);
    inputValidation(inputEmail, RegExpEmail);
    inputValidation(inputAddress, RegExpMessage);
    inputValidation(inputComment, RegExpMessage);


    $('#make-order').click(function (event) {
        event.preventDefault();
        if($(inputName).hasClass('input-valid') && inputName.val() !==''
            && $(inputEmail).hasClass('input-valid') && inputEmail.val() !==''
            && $(inputAddress).hasClass('input-valid') && inputAddress.val() !==''
            && $(inputComment).hasClass('input-valid') && inputComment.val() !=='' ){
            let formData = $('#order-form').serialize();
            $.ajax({
                url: '/cart/checkout',
                method: 'post',
                data: formData,
                success: function (response) {
                    if (response){
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                }
            })
        } else {
            Swal.fire({
                text: 'Необходимо корректно заполнить все поля формы.',
                icon: 'error',
                confirmButtonText: 'Закрыть'
            });
        }
    });


    $('#send-recall').click(function (event) {
        event.preventDefault();
        Swal.fire({
            text: 'Спасибо! Ваше сообщение успешно отправлено.',
            icon: 'success',
            confirmButtonText: 'Закрыть'
        }).then(function () {
                window.location = '/contacts';
        });
    });
});

/* Input Validation */

function inputValidation(input, RegExp) {
    input.on('input', function () {
        if (RegExp.test(input.val())) {
            input.removeClass("input-invalid");
            input.addClass("input-valid");
        } else {
            input.addClass("input-invalid");
            input.removeClass("input-valid");
        }
    });
}
