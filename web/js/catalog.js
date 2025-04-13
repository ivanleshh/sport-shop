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

const catalog_reload = function () {
  if ($('#catalog-pjax').length > 0) {
    $.pjax.reload('#catalog-pjax')
  }
}

$(() => {
  $("#catalog-pjax, #favourite-pjax, #product-buttons-pjax").on("click", ".btn-cart-add, .btn-cart-item-dec, .btn-cart-item-inc", function (e) {
    e.preventDefault();
    const a = $(this);
    $.ajax({
      url: a.attr("href"),
      method: 'POST',
      success(data) {
        if (data) {
          if (data.status) {
            if ($('#catalog-pjax').length > 0) {
              $.pjax.reload("#catalog-pjax", {
                push: false,
                timeout: 5000
              })
            } else if ($('#favourite-pjax').length > 0) {
              $.pjax.reload("#favourite-pjax", {
                push: false,
                timeout: 5000
              })
            } else if ($('#product-buttons-pjax').length > 0) {
              $.pjax.reload("#product-buttons-pjax", {
                push: false,
                timeout: 5000
              })
            } 
          } else {
            error_modal(data.message)
          }
        }
      },
    });
  });

  $("#catalog-pjax, #favourite-pjax").on('pjax:end', function () {
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

  $("#catalog-pjax").on("click", ".btn-favourite", function (e) {
    e.preventDefault();
    const a = $(this);
    $.ajax({
      url: a.attr("href"),
      type: "POST",
      data: {
        id: a.data("id")
      },
      success(data) {
        a.html(data == '1' ? "<i class='bi bi-suit-heart-fill text-danger'></i>" : "<i class='bi bi-suit-heart-fill text-light'></i>");
        catalog_reload()
      },
    });
  });
})