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
  'favourite-pjax',
  'catalog-buttons-pjax',
  'compare-pjax',
  'order-pjax',
]

const pjax_reload = function (name = false) {
  if (name) {
    let title = `#${name}`
    if ($(title).length > 0) {
      $.pjax.reload(title)
    }
  } else {
    for (let i = 0; i < pjax_array.length; i++) {
      let title = `#${pjax_array[i]}`
      if ($(title).length > 0) {
        $.pjax.reload(title)
        break
      }
    }
  }
}

$(() => {
  $("#catalog-pjax, #favourite-pjax, #catalog-buttons-pjax, #compare-pjax").on("click", ".btn-cart-add, .btn-cart-item-dec, .btn-cart-item-inc", function (e) {
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

  $("#catalog-pjax, #favourite-pjax, #compare-pjax, #catalog-buttons-pjax").on('pjax:end', function () {
    if ($('#cart-item-count').length > 0) {
      cartItemCount()
    }
  })

  $("#catalog-pjax, #catalog-buttons-pjax").on("click", ".btn-favourite, .btn-compare", function (e) {
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