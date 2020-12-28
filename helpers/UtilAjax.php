<?php

namespace app\helpers;
use Yii;

class UtilAjax  {

    const LIKE = <<< EOT
    $('.clike').on('click', function(event) {
            var self = $(this);
            var value = self.attr('value');
            var id = self.attr('id');
            $.ajax({
                type: 'GET',
                url: '/comentarios/like?cid='+value,
                dataType: 'json',
            }).done(function(data, textStatus, jqXHR) {
                data = JSON.parse(data);
                $('.fav'+value).html(data.fav);
                self.efect();
                self.attr('class', (data.icono) ? ('fas fa-thumbs-down') : ('fas fa-thumbs-up')) 
                self.attr('title', (data.icono) ? ('No me gusta') : ('Me gusta'))
            }).fail(function(data, textStatus, jqXHR) {
                console.log('Error de la solicitud.');
            });
            return false
    });
    EOT;

}