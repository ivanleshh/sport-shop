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

let ategory_id = undefined

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

  $("#catalog-pjax, #favourite-pjax, #compare-pjax").on('pjax:end', function () {
    let alert = $('.alert')
    if (alert.length > 0) {
      setTimeout(() => {
        alert[alert.length - 1].remove()
      }, 5000)
    }
    if ($('#cart-item-count').length > 0) {
      cartItemCount()
    }
  })

  $("#catalog-pjax").on("click", ".btn-favourite, .btn-compare", function (e) {
    e.preventDefault();
    const a = $(this);
    $.ajax({
      url: a.attr("href"),
      type: "POST",
      data: {
        id: a.data("id")
      },
      success() {
        pjax_reload('catalog-pjax')
      },
    });
  });
})