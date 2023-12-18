<!doctype html>
<html lang="es">
  <head>
    <title>Buscador de veghiculos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

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


    <h5 class="text-primary">Buscador de vehículos</h5>

  
  <form action=""  style="width:50rem;" class="" id="formbusqueda" autocomplete ="off">

  <div class="mb-3 d-flex">

  <input type="text" class="form-control text-center" id="placa" placeholder="Ingrese una placa de vehículo" autofocus maxlength="7" >
  <button class="btn btn-success" type="button" id="buscar" >Buscar</button>
  </div>
  <small id="status"></small>


  <div class="mb-3">
    <label for="marca" class="form-label">Marca</label>
    <input type="text" class="form-control" id="marca" readonly>
   
  </div>

  <div class="mb-3">
    <label for="modelo" class="form-label">Modelo</label>
    <input type="text" class="form-control" id="modelo" readonly>
   
  </div>
  <div class="mb-3">
    <label for="color" class="form-label">Color</label>
    <input type="text" class="form-control" id="color" readonly>
   
  </div>
  <div class="mb-3">
    <label for="tipocombustible" class="form-label">Tipo combustible</label>
    <input type="text" class="form-control" id="tipocombustible" readonly >
   
  </div>
  <div class="mb-3">
    <label for="peso" class="form-label">Peso</label>
    <input type="text" class="form-control" id="peso" readonly>
   
  </div>


  <div class="mb-3">
    <label for="afabricacion" class="form-label">Año de fabricación</label>
    <input type="text" class="form-control" id="afabricacion" readonly>
  </div>

  
</form>

</div>





<script>
  document.addEventListener("DOMContentLoaded",()=>{

    function $(id){
      return document.querySelector(id);
    }


  function buscarPlaca(){

    const placa = $("#placa").value;

    if(placa != ""){

      const parametros = new FormData();
      parametros.append('operacion','search');
      parametros.append('placa',placa);

      $("#status").innerHTML = "Buscando, por favor espere....."

      fetch(`../controllers/Vehiculo.controller.php`,{
        method : "POST",
        body:parametros
      })
      .then(respuesta => respuesta.json())
      .then(datos =>{

        $("#status").innerHTML = "No se encontró el registro";

        if(!datos){
          $("#formbusqueda").reset();
          $("#placa").focus();
          
        }else{
        $("#status").innerHTML= "Vehículo encontrado"
      
        $("#marca").value = datos.marca;
        $("#modelo").value = datos.modelo;
        $("#color").value = datos.color;
        $("#tipocombustible").value = datos.tipocombustible;
        $("#peso").value = datos.peso;
        $("#afabricacion").value = datos.afabricacion;

        }        
      })
      .catch(e => {
        console.error(e);
      })
    }
    
  }


  
  $("#placa").addEventListener('keypress',(e) => {
    if(e.keyCode == 13){
      buscarPlaca();
    }
  })


  $("#buscar").addEventListener('click',buscarPlaca);

})


</script>




   
  </body>


</html>
