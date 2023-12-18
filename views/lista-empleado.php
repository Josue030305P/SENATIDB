<!doctype html>
<html lang="es">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
</head>
<body>

<div class="container mt-5">
    <div class="text-center m-3">
        <a href="./registra-empleado.php"><button class="btn btn-primary fw-bold p-3 m-2">Agregar</button></a>
        <a href="./busca-empleado.php"><button class="btn btn-success fw-bold p-3 m-2">Buscar</button></a>
        <a href="./informe.html"><button class="btn btn-info text-light  fw-bold p-3 m-2">Ver informe</button></a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered" id="tabla-empleado">
            <thead class="table-dark">
            <tr id="cabezera-tabla">
                <th scope="col" class="text-center" id="idempleado">ID</th>
                <th scope="col" class="text-center" id="sede">Sede</th>
                <th scope="col" class="text-center" id="apellidos">Apellidos</th>
                <th scope="col" class="text-center" id="nombres">Nombres</th>
                <th scope="col" class="text-center" id="ndocumento">Número de documento</th>
                <th scope="col" class="text-center" id="fechanac">Fecha nacimiento</th>
                <th scope="col" class="text-center" id="telefono">Teléfono</th>
            </tr>
            </thead>

            <tbody id="contenido-tabla-empleado"></tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        function $(id) {
            return document.querySelector(id);
        }

        (function () {
            fetch(`../controllers/Empleado.controller.php?operacion=listar`)
                .then(respuesta => respuesta.json())
                .then(datos => {
                    console.log(datos);

                    datos.forEach(element => {
                        const tagTr = document.createElement('tr');

                        // Crear una celda para cada propiedad y agregarla a la fila
                        const propiedades = ['idempleado', 'sede', 'apellidos', 'nombres', 'ndocumento', 'fechanacimiento', 'telefono'];

                        propiedades.forEach(propiedad => {
                            const tagTd = document.createElement('td');
                            tagTd.innerText = element[propiedad];
                            tagTr.appendChild(tagTd);
                        });

                        // Asignar la clase 'empleado' a la fila
                        tagTr.classList.add('empleado');

                        $("#contenido-tabla-empleado").appendChild(tagTr);
                    });
                })
                .catch(e => {
                    console.error(e);
                });
        })();
    });
</script>
</body>
</html>
