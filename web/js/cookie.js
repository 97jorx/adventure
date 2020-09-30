function setCookie(nombre, valor, dias, ruta, dominio, secure) {
    if (dias) {
        var fecha = new Date();
        fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
        var caducidad = '; expira=' + fecha.toGMTString();
    }
    else var caducidad = '';
    document.cookie = nombre + '=' + valor + ';' + caducidad + '; ruta=/' + 
    ((ruta == null) ? '' : '; ruta=' + ruta) +
    ((dominio == null) ? '' : '; dominio=' + dominio) +
    ((secure == null) ? '' : '; secure');
}

function getCookie(nombreCookie) {
    var nombre = nombreCookie + '=';
    var cookieArray = document.cookie.split(';');
    for (var i = 0; i < cookieArray.length; i++) {
        var parteCookie = cookieArray[i];
        while (parteCookie.charAt(0) == ' ') {
            parteCookie = parteCookie.substring(1);
        }
        if (parteCookie.indexOf(nombre) == 0) {
            return parteCookie.substring(nombre.length, parteCookie.length);
        }
    }
    return '';
}


