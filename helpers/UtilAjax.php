<?php

namespace app\helpers;
use Yii;

class UtilAjax  {

    const LIKE = <<< EOT
    $('.clike').on('click', function(event) {
            var self = $(this);
            var id = self.attr('value');
            $.ajax({
                type: 'GET',
                url: '/comentarios/like?cid='+id,
                dataType: 'json',
            }).done(function(data, textStatus, jqXHR) {
                data = JSON.parse(data);
                console.log(data);
                // $('#cfav').html(data.fav);
                // $('#clike').efect();
                // $('#clike').attr('class', (data.icono) ? ('fas fa-thumbs-down') : ('fas fa-thumbs-up')) 
                // $('#clike').attr('title', (data.icono) ? ('No me gusta') : ('Me gusta'))
            }).fail(function(data, textStatus, jqXHR) {
                console.log('Error de la solicitud.');
            });
            return false
    });
    EOT;

}