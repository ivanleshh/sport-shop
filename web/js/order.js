$(() => {
  $('.order-form').on('change', '#orders-type_pay_id', function () {
    if ($(this).val() == 1) {
      $('.alert-pay').removeClass('d-none')
      $('.btn-form-send').html('Перейти к оплате')
    } else {
      $('.alert-pay').addClass('d-none')
      $('.btn-form-send').html('Оформить заказ')
    }
  })

  $('.create-order').on('click',
    '.btn-cart-item-dec, .btn-cart-item-inc, .btn-cart-item-remove, .btn-cart-clear',
    function (e) {
      e.preventDefault();

      $.ajax({
        url: $(this).attr("href"),
        method: 'POST',
        success(data) {
          if (data) {
            if (data.status) {
              $.pjax.reload({
                container: "#order-pjax"
              });
            } else {
              error_modal(data.message);
            }
          }
        },
      });
    })
})