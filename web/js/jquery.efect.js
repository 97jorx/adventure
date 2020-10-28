jQuery.fn.efect = function() {
    this.each(function(){
       elem = $(this);
       elem.mouseover(function() {
         $(this).addClass("efectoEscalar")
         .removeClass("efectoEntrada")
         .css("-webkit-transform", "scale(1.1)");
         })
         elem.mouseout(function() {
         $(this).removeClass("efectoEscalar")
          .addClass("efectoSalida")
          .css("-webkit-transform","scale(1)");
         })
         elem.click(function() {
         $(this).removeClass("efectoSalida").
            addClass("jello-horizontal")
         })
    });
    return this;
 };