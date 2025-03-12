$(() => {
    $("#favourite-pjax").on("click", ".btn-favourite", function (e) {
      e.preventDefault();
      const a = $(this);
        $.ajax({
        url: a.attr("href"),
        type: "POST",
        data: { id: a.data("id") },
        success() {
            $.pjax.reload('#favourite-pjax');
        },
        });
    });
});