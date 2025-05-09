$(() => {
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
              $.pjax.reload("#order-pjax", {
                url: $('#btn-order').attr('href'),
                push: false,
                replace: false,
                timeout: 5000,
              });
            } else {
              error_modal(data.message);
            }
          }
        },
      });
    })

  $('#order-pjax').on('pjax:end', () => {
    cartItemCount();
  })
})