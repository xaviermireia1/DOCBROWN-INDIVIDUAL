document.getElementById('formulario').onsubmit = validar;

function validar() {
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