$(() => {
    $('.user-form').on('click', '#user-check', function() {
        if ($('#user-check').prop('checked')) {
            $('.field-user-password').removeClass('collapse')
            $('.field-user-password_repeat').removeClass('collapse')
            $('#user-password').removeClass('is-valid')
            $('#user-password_repeat').removeClass('is-valid')

            $('#form-personal').yiiActiveForm('add', {"id":"user-password","name":"password","container":".field-user-password","input":"#user-password",
            "error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, 
            {"message":"Необходимо заполнить «пароль»."});yii.validation.string(value, messages, {"message":"Значение «пароль» должно быть строкой.","max":255,
            "tooLong":"Значение «пароль» должно содержать максимум 255 символа.","skipOnEmpty":1});yii.validation.regularExpression(value, messages, 
            {"pattern":/^[a-zA-Z\s\d\^\+\-\<\>]+$/,"not":false,"message":"Разрешённые символы: латиница, пробел, ^, +, -, \u003C, \u003E","skipOnEmpty":1});
            yii.validation.string(value, messages, {"message":"Значение «пароль» должно быть строкой.","min":8,
            "tooShort":"Значение «пароль» должно содержать минимум 8 символа.","skipOnEmpty":1});yii.validation.regularExpression(value, messages, 
            {"pattern":/^(?=.*[\d]).+$/,"not":false,"message":"Должна быть хотя бы одна цифра","skipOnEmpty":1});yii.validation.regularExpression(value, messages, 
            {"pattern":/^(?=.*[a-z]).+$/,"not":false,"message":"Должна быть хотя бы одна строчная буква","skipOnEmpty":1});
            yii.validation.regularExpression(value, messages, {"pattern":/^(?=.*[A-Z]).+$/,"not":false,
            "message":"Должна быть хотя бы одна заглавная буква","skipOnEmpty":1});}});

            $('#form-personal').yiiActiveForm('add', {"id":"user-password_repeat","name":"password_repeat","container":".field-user-password_repeat",
            "input":"#user-password_repeat","error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {
            yii.validation.required(value, messages, {"message":"Необходимо заполнить «повтор пароля»."});yii.validation.string(value, messages, 
            {"message":"Значение «повтор пароля» должно быть строкой.","max":255,"tooLong":"Значение «повтор пароля» должно содержать максимум 255 символа.",
            "skipOnEmpty":1});yii.validation.compare(value, messages, {"operator":"==","type":"string","compareAttribute":"user-password",
            "compareAttributeName":"User[password]","skipOnEmpty":1,"message":"Значение «повтор пароля» должно быть равно «пароль»."}, $form);}});
        } else {
            $('.field-user-password').addClass('collapse')
            $('.field-user-password_repeat').addClass('collapse')
            $('#user-password').removeClass('is-invalid')
            $('#user-password_repeat').removeClass('is-invalid')
            $('#user-password').val('')
            $('#user-password_repeat').val('')

            $('#form-personal').yiiActiveForm('remove', "user-password")
            $('#form-personal').yiiActiveForm('remove', "user-password_repeat")
        }
    })
})