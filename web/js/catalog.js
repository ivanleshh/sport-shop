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
  
$(() => {
  $('#catalog-pjax').on('keyup', '#productsearch-title', function(e) {
    if (e.key == 'Enter' || $(this).val() !== '') {
        $('#catalog-filter').submit();
    }
  })

  $("#catalog-pjax").on("click", ".btn-cart-add", function (e) {
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
    setTimeout(() => {
      $('.alert').remove()
    }, 5000)
    cartItemCount()
  })
})