function validarlogin() {
    let email = document.getElementById("floatingInput").value;
    let password = document.getElementById("floatingPassword").value;
    if (email == "" && password == "") {
        swal({
            title: "Error",
            text: "Tienes que introducir tu correo y contraseña",
            icon: "error",
        });
        return false;
    } else if (email == "") {
        swal({
            title: "Error",
            text: "Tienes que introducir tu correo",
            icon: "error",
        });
        return false;
    } else if (password == "") {
        swal({
            title: "Error",
            text: "Tienes que introducir tu contraseña",
            icon: "error",
        });
        return false;
    } else {
        return true;
    }
}

function validaruser() {
    let email = document.getElementById("email").value;
    let contraseña = document.getElementById("contraseña").value;
    let nombre = document.getElementById("nombre").value;
    let apellido = document.getElementById("apellido").value;
    if (email == '' || contraseña == '' || nombre == '' || apellido == '') {
        swal({
            title: "Error",
            text: "Se tienen que rellenar todos los campos",
            icon: "error",
        });
        return false;
    }
}

function validarmoduser() {
    let nombre = document.getElementById("nombre").value;
    let apellido = document.getElementById("apellido").value;
    if (nombre == '' || apellido == '') {
        swal({
            title: "Error",
            text: "Se tienen que rellenar todos los campos",
            icon: "error",
        });
        return false;
    }
}

function validarmesa() {
    let mesa = document.getElementById("mesa").value;
    let silla = document.getElementById("silla").value;
    if (mesa == '' || silla == '') {
        swal({
            title: "Error",
            text: "Se tienen que rellenar todos los campos",
            icon: "error",
        });
        return false;
    }
}

function validarlocalizacion() {
    let nombre = document.getElementById("nombre").value;
    if (nombre == '') {
        swal({
            title: "Error",
            text: "El nombre es obligatorio",
            icon: "error",
        });
        return false;
    }
}

function validarreservaonline() {
    let nombre = document.getElementById("nombre").value;
    let apellido = document.getElementById("apellido").value;
    let email = document.getElementById("email").value;
    let fecha = document.getElementById("fecha").value;
    let hora = document.getElementById("hora").value;
    if (nombre == '' || apellido == '' || email == '' || fecha == '' || hora == '') {
        swal({
            title: "Error",
            text: "Todos los campos son obligatorios",
            icon: "error",
        });
        return false;
    }
}

function validarmodreservaonline() {
    let nombre = document.getElementById("nombre").value;
    let apellido = document.getElementById("apellido").value;
    let email = document.getElementById("email").value;
    let fecha = document.getElementById("fecha").value;
    let hora = document.getElementById("hora").value;
    let silla = document.getElementById("silla").value;
    if (nombre == '' || apellido == '' || email == '' || fecha == '' || hora == '' || silla == '') {
        swal({
            title: "Error",
            text: "Todos los campos son obligatorios",
            icon: "error",
        });
        return false;
    }
}

function yaReservadoOnline() {
    swal({
        title: "Reserva ocupada",
        text: "Ya se ha reservado la mesa introducida a la hora introducida",
        icon: "error",
    })
}

function yaReservado() {
    swal({
        title: "Mesa ocupada",
        text: "Hay una reserva online en la mesa introducida, busca otra mesa",
        icon: "error",
    })
}

function reservaCorrecta() {
    swal({
        title: "Reserva completada",
        text: "Se ha reservado la mesa de manera exitosa",
        icon: "success",
    })
}

function reservaPasado() {
    swal({
        title: "Reservas pasadas",
        text: "No se puede reservar con una hora anterior al día",
        icon: "error",
    })
}