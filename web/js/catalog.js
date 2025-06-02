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

const toastReload = () => $.pjax.reload({
  container: '#toast-pjax',
  timeout: 5000,
})

const pjax_array = [
  'catalog-pjax',
  'recently-viewed-pjax',
  'favourite-pjax',
  'compare-pjax',
  'order-pjax',
]

const pjax_reload = function () {
  for (let i = 0; i < pjax_array.length; i++) {
    let title = `#${pjax_array[i]}`
    if ($(title).length > 0) {
      $.pjax.reload({
        container: title,
      })
    }
  }
}

$(() => {
  $("#catalog-pjax, #favourite-pjax, #product-buttons-pjax, #compare-pjax, #recently-viewed-pjax")
    .on("click", ".btn-cart-add, .btn-cart-item-dec, .btn-cart-item-inc", function (e) {
      e.preventDefault();
      const a = $(this);
      $.ajax({
        url: a.attr("href"),
        method: 'POST',
        success(data) {
          if (data) {
            if (data.status) {
              $.pjax.reload({
                container: a.data('pjx'),
              })
            } else {
              error_modal(data.message)
            }
          }
        },
      });
    });

  $("#catalog-pjax, #product-buttons-pjax, #recently-viewed-pjax")
.on("click", ".btn-favourite, .btn-compare", function (e) {
    e.preventDefault();
    const a = $(this);
    $.ajax({
      url: a.attr("href"),type: "POST",data: {id: a.data("id")},
      success(data) {
        if (typeof(a.data('pjx')) !== 'undefined') {
          $.pjax.reload({container: a.data('pjx')})
        } else {
          if (a.hasClass('btn-favourite')) {
            a.html(`<i class="bi bi-suit-heart-fill ${data.status ? 'text-danger' : 'text-secondary'}"></i>`)
          } else if (a.hasClass('btn-compare')) {
            a.html(`<i class="bi bi-bar-chart-line-fill ${data.status ? 'text-warning' : 'text-secondary'}"></i>`)
          }
          toastReload()
        }
      }
    })
  });

  $("#catalog-pjax, #favourite-pjax, #compare-pjax, #product-buttons-pjax, #recently-viewed-pjax, #product-reviews-pjax, #personal-pjax, #order-pjax").on('pjax:end', function () {
    toastReload()
  })

  $('#toast-pjax').on('pjax:end', function () {
    cartItemCount()
  })
})