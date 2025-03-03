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

const catalog_reload = function() {
  if ($('#catalog-pjax').length > 0) {
    $.pjax.reload('#catalog-pjax')
  }
}  
  
$(() => {
  $('#catalog-pjax').on('keyup', '#productsearch-title', function(e) {
    if (e.key == 'Enter' || $(this).val() !== '') {
        $('#catalog-filter').submit();
    }
  })

  $("#catalog-pjax").on("click", ".btn-cart-add, .btn-cart-item-dec, .btn-cart-item-inc", function (e) {
  e.preventDefault();
  const a = $(this);
  $.ajax({
    url: a.attr("href"),
    method: 'POST',
    success(data) {
      if (data) {
        if (data.status) {
          $.pjax.reload("#catalog-pjax", {
            push: false,
            timeout: 5000
          })
        } else {
          error_modal(data.message)
        }
      }
    },
  });
  });

  $("#catalog-pjax").on('pjax:end', function() {
    let alert = $('.alert')
    if (alert.length > 0) {
      setTimeout(() => {
        alert[alert.length - 1].remove()
      }, 5000)
    }
    cartItemCount()
  })
})