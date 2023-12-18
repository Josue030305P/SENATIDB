<!DOCTYPE html>
<html lang="es">

<head>
    <title>Buscador de empleados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <div class="container mt-5 border p-4 mx-auto" style="max-width: 50rem;">

        <h5 class="text-primary text-center fw-bold">Buscador de empleados</h5>

        <form action="" class="" id="formbusqueda" autocomplete="off">

            <div class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="ndocumento"
                        placeholder="Número de documento del empleado" class="text-center" autofocus maxlength="8">
                    <button class="btn btn-success" type="button" id="buscar">Buscar</button>
                </div>
            </div>
            <small id="status"></small>

            <div class="mb-3">
                <label for="sede" class="form-label">Sede</label>
                <input type="text" class="form-control" id="sede" readonly>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" readonly>
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" readonly>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fnacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="text" class="form-control" id="fnacimiento" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" class="form-control" id="telefono" readonly>
                </div>
            </div>

            <div class="mb-3 text-end">
                <a href="./lista-empleado.php"><button class="btn btn-warning text-light" id="" type="button">Regresar</button></a>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            function $(id) {
                return document.querySelector(id);
            }


            function buscarNdocumento() {

                const nDocumento = $("#ndocumento").value;

                if (nDocumento != "") {

                    const parametros = new FormData();
                    parametros.append('operacion', 'buscar');
                    parametros.append('ndocumento', nDocumento);

                    $("#status").innerHTML = "Buscando, por favor espere....."

                    fetch(`../controllers/Empleado.controller.php`, {
                            method: "POST",
                            body: parametros
                        })
                        .then(respuesta => respuesta.json())
                        .then(datos => {
                            console.log(datos);

                            $("#status").innerHTML = "No se encontró el registro";

                            if (!datos) {
                                $("#formbusqueda").reset();
                                $("#ndocumento").focus();

                            } else {
                                $("#status").innerHTML = "Empleado encontrado"

                                $("#sede").value = datos.sede;
                                $("#apellidos").value = datos.apellidos;
                                $("#nombres").value = datos.nombres;
                                $("#fnacimiento").value = datos.fechanacimiento;
                                $("#telefono").value = datos.telefono;

                            }
                        })
                        .catch(e => {
                            console.error(e);
                        })
                }

            }



            $("#ndocumento").addEventListener('keypress', (e) => {
                if (e.keyCode == 13) {
                    buscarNdocumento();
                }
            })


            $("#buscar").addEventListener('click', buscarNdocumento);

        })


    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

</body>

</html>
