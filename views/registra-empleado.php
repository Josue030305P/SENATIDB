<!DOCTYPE html>
<html lang="es">

<head>
    <title>Registrar empleados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

    <div class="container mt-5">
        <div class="border p-4 rounded" style="max-width: 50rem; margin: 0 auto;">
            <h5 class="text-primary fw-bold text-center">Registro de empleados</h5>

            <form action="" class="" id="formEmpleados" autocomplete="off">

                <div class="mb-3">
                    <label for="sede" class="form-label">Sedes</label>
                    <select name="sede" id="sede" class="form-select" required>
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" required>
                </div>
                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="nombres" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="ndocumento" class="form-label">Número de documento</label>
                        <input type="text" inputmode="numeric" class="form-control text-end" id="ndocumento" required
                            maxlength="8">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fnacimiento" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control text-end" id="fnacimiento" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" inputmode="numeric" class="form-control text-center" id="telefono" required
                            maxlength="9" minlength="9">
                    </div>
                </div>

                <div class="mb-3 text-end">
                    <button class="btn btn-primary" id="guardar" type="submit">Guardar Datos</button>
                    <button class="btn btn-danger" id="" type="reset">Cancelar</button>
                    <a href="./lista-empleado.php"><button class="btn btn-warning text-light" id="" type="button">Regresar</button></a>
                </div>
            </form>

            <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3">
                <
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>





    <script>
      document.addEventListener('DOMContentLoaded', () => {
        function $(id) {
          return document.querySelector(id);
        }

        (function () {
          fetch(`../controllers/Sede.controller.php?operacion=listar`)
            .then(respuesta => respuesta.json())
            .then(datos => {
              datos.forEach(element => {
                const tagOption = document.createElement('option');
                tagOption.value = element.idsede;
                tagOption.innerText = element.sede;
                $("#sede").appendChild(tagOption);
              });
            })
            .catch(e => {
              console.error(e);
            });
        })();

        $("#formEmpleados").addEventListener('submit', (e) => {
          e.preventDefault();

          const parametros = new FormData();
          parametros.append("operacion", "registrar");
          parametros.append("idsede", $("#sede").value);
          parametros.append("apellidos", $("#apellidos").value);
          parametros.append("nombres", $("#nombres").value);
          parametros.append("ndocumento", $("#ndocumento").value);
          parametros.append("fechanacimiento", $("#fnacimiento").value);
          parametros.append("telefono", $("#telefono").value);

          fetch(`../controllers/Empleado.controller.php`, {
              method: "POST",
              body: parametros
            })
            .then(respuesta => respuesta.json())
            .then(datos => {
              if (datos.idempleado > 0) {
                $("#formEmpleados").reset();
                mostrarToast(`Empleado registrado con el id: ${datos.idempleado}`, 'success');
              }
            })
            .catch(e => {
              console.error(e);
              mostrarToast('Hubo un error al procesar la solicitud', 'danger');
            });
        });

        function mostrarToast(mensaje, tipo) {
          const toast = document.createElement('div');
          toast.classList.add('toast', `bg-${tipo}`, 'text-white');
          toast.setAttribute('role', 'alert');
          toast.setAttribute('aria-live', 'assertive');
          toast.setAttribute('aria-atomic', 'true');
          toast.innerHTML = `
            <div class="toast-header">
              <strong class="me-auto">Mensaje</strong>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
              ${mensaje}
            </div>
          `;
          $("#toastContainer").appendChild(toast);

          const bootstrapToast = new bootstrap.Toast(toast);
          bootstrapToast.show();

          setTimeout(() => {
            $("#toastContainer").removeChild(toast);
          }, 5000);
        }
      });
    </script>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

  </body>
</html>
