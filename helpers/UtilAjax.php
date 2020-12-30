<?php

namespace app\helpers;
use Yii;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

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


    const COMENTARIOS = <<< EOT
        $('#area-texto, #area-texto-reply').on('input', (event) => {
            event.preventDefault();
            var self = $(this);
            var length = $('#area-texto').val().length;
            $("#length-area-texto").text("Carácteres restantes: " + (255 - length));
            if($('#area-texto').val().length > 0){
                if(length > 255) {
                    $('#submitComent').fadeOut();
                    $("#length-area-texto").text("Carácteres restantes: " + (0));
                    $("#length-area-texto").css("cssText", "color: red;");
                } else {
                    $('#submitComent').fadeIn();
                    $("#length-area-texto").css("cssText", "color: grey;");
                }
                } else {
                    $('#submitComent').fadeOut();
                }
        });

        $('.responder-click').on('click', function(event) {
            event.preventDefault();
            blogid = $('.blogid').val();
            id = this.id;
            respuesta = '#respuesta-'+id;
            reply_id = '#reply-'+id;
            divid = $(reply_id);
            csrf = $('#csrf').val()

            if(!$('#respuesta-'+id).length && $('#area-texto').val().length == 0)  {
            divid.append(`
                <div id='respuesta-\${id}' class='respuesta-form'>
                <h5 class='card-header'>Responder:</h5>
                <div class='card-body'>
                    <form id='respuesta-comentario'  action='/comentarios/comentar' method='post'>
                    <input type='hidden' name='_csrf' value='\${csrf}'>                        
                        <div class='form-group-reply'>
                        <textarea id='area-texto-reply-\${id}' class='form-control' name='texto' rows='3'></textarea>                        
                        <input type='hidden' name='parent' value='\${id}'>
                        <input type='hidden' name='blogid' value='\${blogid}'>                        
                        </div>
                        <button type='button' id='close-\${id}' onclick='$(this).parent().parent().parent().remove();' class='mt-3 btn btn-white'>Cancelar</button>                        
                        <button type='submit' id='submitReply-\${id}' class='btn btn-info'>Responder</button>                         
                    </form>                      
                </div>
                <i id='length-area-texto-\${id}' style='position:absolute; left:70%'></i>
                </div>`);
            } 
        });

        $('body').on('submit', 'form#comentar-form, form#respuesta-comentario',  function(event) {
            var form = $(this);
            event.preventDefault();
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function (data) {
                data = JSON.parse(data);
                $('#submitComent').fadeOut();
                $('#area-texto').val('');
                div = (data.id == null) ? $('#comentarios') : $('.reply-div-'+data.id);
                reply = (data.id == null) ? "mb-4" : "mt-4";
                ml = (data.blog_id == null) ? "ml-5" : "";
                    if(!data.code) {
                        div.prepend(`
                            <div class='row'>
                            <div class="media \${ml} \${reply}">
                                <img class="d-flex mr-3 rounded-circle" src='https://picsum.photos/50/50?random=1' alt="">
                                <div class="media-body">
                                <div class='row'>
                                <h5 class="mt-0 ml-3 pr-2" style="font-size:0.9rem"> \${data.alias} </h5>
                                <i class="minutes" style="color:grey; font-size:0.9rem"> \${data.fecha} </i>
                                </div>
                                <div>\${data.texto}</div>
                                    <div class='container mt-2'>
                                    <div class='row'>
                                        <div class='col-3'>
                                        <a href="#" style="color:grey; font-size:0.9rem"><i class="fas fa-thumbs-up"></i> </a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        `);
                    }
                }
                });
                return false;
            });
        EOT;


}