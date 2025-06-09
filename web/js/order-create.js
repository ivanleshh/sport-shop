$(() => {
    $('.order-form').on('change', '#orders-check', function() {
        if ($('#orders-check').prop('checked')) {
            $('#orders-pick_up_id option:first').prop('selected', true)
            $('.delivery-fields').removeClass('collapse')
            $('.pickup').addClass('collapse')
            $('#orders-pick_up_id').removeClass('is-invalid')
            $('#orders-address').removeClass('is-valid')
            $('#orders-date_delivery').removeClass('is-valid')
            $('#orders-time_delivery').removeClass('is-valid')
            $('#form-order').yiiActiveForm('remove', 'orders-pick_up_id')
            $('#form-order').yiiActiveForm('add', {"id":"orders-address","name":"address","container":".field-orders-address","input":"#orders-address","error":
            ".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, 
            {"message":"Необходимо заполнить «адрес доставки»."});yii.validation.string(value, messages, 
            {"message":"Значение «адрес доставки» должно быть строкой.","skipOnEmpty":1});}});
            $('#form-order').yiiActiveForm('add', {"id":"orders-date_delivery","name":"date_delivery","container":".field-orders-date_delivery","input":
            "#orders-date_delivery","error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(
            value, messages, {"message":"Необходимо заполнить «дата доставки»."});yii.validation.string(value, messages, {
            "message":"Значение «дата доставки» должно быть строкой.","skipOnEmpty":1});}});
            $('#form-order').yiiActiveForm('add', {"id":"orders-time_delivery","name":"time_delivery","container":".field-orders-time_delivery","input":
            "#orders-time_delivery","error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(
            value, messages, {"message":"Необходимо заполнить «время доставки»."});yii.validation.string(value, messages, {
            "message":"Значение «время доставки» должно быть строкой.","skipOnEmpty":1});}});
        } else {
            $('#form-order').yiiActiveForm('add', {"id":"orders-pick_up_id","name":"pick_up_id","container":".field-orders-pick_up_id","input":"#orders-pick_up_id",
            "error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.number(value, messages, {
            "pattern":/^[+-]?\d+$/,"message":"Значение «Пункт выдачи» должно быть целым числом.","skipOnEmpty":1});yii.validation.required(value, messages, {
            "message":"Необходимо заполнить «Пункт выдачи»."});}});
            $('.pickup').removeClass('collapse')
            $('.delivery-fields').addClass('collapse')
            $('#orders-pick_up_id').removeClass('is-valid')
            $('#orders-address').removeClass('is-invalid')
            $('#orders-date_delivery').removeClass('is-invalid')
            $('#orders-time_delivery').removeClass('is-invalid')
            $('#orders-address').val('')
            $('#orders-date_delivery').val('')
            $('#orders-time_delivery').val('')
            $('#orders-comment').val('')
            $('#form-order').yiiActiveForm('remove', 'orders-address')
            $('#form-order').yiiActiveForm('remove', 'orders-address')
            $('#form-order').yiiActiveForm('remove', 'orders-date_delivery')
            $('#form-order').yiiActiveForm('remove', 'orders-date_delivery')
            $('#form-order').yiiActiveForm('remove', 'orders-time_delivery')
            $('#form-order').yiiActiveForm('remove', 'orders-time_delivery')
        }
    })
})