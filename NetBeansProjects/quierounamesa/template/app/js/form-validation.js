$(function () {
    $(".form-validate").validate({
        errorPlacement: function(error, element)
        {
            error.insertAfter(element);
        }
    });
    $(".form-validate-signin").validate({
        errorPlacement: function(error, element)
        {
            error.insertAfter(element);
        }
    });
    $(".form-validate-signup").validate({
        rules: {
            age: {
                range: [0,100]
            }
        },
        errorPlacement: function(error, element)
        {
            error.insertAfter(element);
        }
    });

});

$(document).ready(function() {
    $.extend(jQuery.validator.messages, {
        required: "Este campo es requerido.",
        remote: "Por favor arregla este campo.",
        email: "Por favor, introduce una dirección de correo electrónico válida.",
        url: "Por favor introduzca un URL válido.",
        date: "Por favor introduzca una fecha valida.",
        dateISO: "Por favor, introduzca una fecha válida (ISO).",
        number: "Por favor ingrese un número valido.",
        digits: "Por favor ingrese solo dígitos.",
        creditcard: "Por favor, introduzca un número de tarjeta de crédito válida.",
        equalTo: "Ingresa el mismo valor.",
        accept: "Por favor, introduzca un valor con una extensión válida.",
        maxlength: $.validator.format("Por favor, introduzca no más de {0} caracteres."),
        minlength: $.validator.format("Por favor, introduzca al menos {0} caracteres."),
        rangelength: $.validator.format("Por favor, introduzca un valor entre {0} y {1} caracteres de longitud."),
        range: $.validator.format("Please enter a value between {0} and {1}."),
        max: $.validator.format("Por favor, introduzca un valor entre {0} y {1}."),
        min: $.validator.format("Por favor, introduzca un valor mayor o igual a {0}.")
    });
});


$.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
$("#fecha").datepicker();
});