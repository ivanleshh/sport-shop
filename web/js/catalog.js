const error_modal = (text) => {
  $('#text-error').html(text)
  $('#info-modal').modal('show')
}

const cartItemCount = () => $.pjax.reload('#cart-item-count', {
  url: $('#cart-item-count').data('url'),
  method: 'POST',
  replace: false,
  push: false,
  timeout: 5000,
})

const pjax_array = [
  'catalog-pjax',
  'recently-viewed-pjax',
  'favourite-pjax',
  'catalog-buttons-pjax',
  'compare-pjax',
  'order-pjax',
]

const pjax_reload = function () {
  for (let i = 0; i < pjax_array.length; i++) {
    let title = `#${pjax_array[i]}`
    if ($(title).length > 0) {
      $.pjax.reload({
        container: title,
        async: false
      })
    }
  }
}

$(() => {
  $("#catalog-pjax, #favourite-pjax, #catalog-buttons-pjax, #compare-pjax, #recently-viewed-pjax").on("click", ".btn-cart-add, .btn-cart-item-dec, .btn-cart-item-inc", function (e) {
    e.preventDefault();
    const a = $(this);
    category_id = a.data('category')
    $.ajax({
      url: a.attr("href"),
      method: 'POST',
      success(data) {
        if (data) {
          if (data.status) {
            pjax_reload()
          } else {
            error_modal(data.message)
          }
        }
      },
    });
  });

  $("#catalog-pjax, #favourite-pjax, #compare-pjax, #catalog-buttons-pjax, #recently-viewed-pjax").on('pjax:end', function () {
    cartItemCount()
  })

  $("#catalog-pjax, #catalog-buttons-pjax, #recently-viewed-pjax").on("click", ".btn-favourite, .btn-compare", function (e) {
    e.preventDefault();
    const a = $(this);
    $.ajax({
      url: a.attr("href"),
      type: "POST",
      data: {
        id: a.data("id")
      },
      success() {
        pjax_reload()
      },
    });
  });
})