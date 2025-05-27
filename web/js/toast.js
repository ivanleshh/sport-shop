$(() => {

    const toastItem = (text, bg_color, index) =>
        `<div class="toast ${bg_color} border-0 mt-4 bg-opacity-75 text-light" role="alert"
        aria-live="assertive" aria-atomic="true" data-index="${index}" data-bs-delay="6000">
            <div class="d-flex">
                <div class="toast-body p-3">
                    ${text}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" 
                data-bs-dismiss="toast" aria-label="Закрыть"></button>
            </div>
        </div>`;

    const updateToast = (container, container_data) => {
        const count = $(container).find(".toast").length + 1;
        const toast = $(toastItem(container_data.data('text'), container_data.data('bg-color'), count));
        $(container).append(toast);
        $(toast).toast('show');
        setTimeout(() => {
            toast.fadeOut(1000);
            setTimeout(() => toast.remove(), 2000);
        }, 5000)
    }

    $("#toast-pjax").on("pjax:end", () => {
        if ($(".toast-container").length && $(".toast-data").data('text').length) {
            const container = $(".toast-container")
            const container_data = $('.toast-data')
            updateToast(container, container_data)
        }
    })
})