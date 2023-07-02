$(document).ready(function() {
  var preguntas = $('.pregunta');
  var currentPregunta = 0;
  var siguienteBtn = $('#siguiente');
  var anteriorBtn = $('#anterior');
  var enviarBtn = $('button[name="enviar"]');
  var preguntaEspecifica = $('#pregunta-especifica');

  // Ocultar todas las preguntas excepto la primera
  preguntas.not(':first').hide();

  // Habilitar/deshabilitar botones según la pregunta actual
  function actualizarBotones() {
    anteriorBtn.prop('disabled', currentPregunta === 0);
    siguienteBtn.toggle(currentPregunta < preguntas.length - 1);
    enviarBtn.toggle(currentPregunta === preguntas.length - 1);
  }

  // Función para mostrar la pregunta específica según la opción seleccionada
  function mostrarPreguntaEspecifica(opcion) {
    preguntas.eq(currentPregunta).hide(); // Ocultar pregunta actual
    preguntaEspecifica.hide(); // Ocultar pregunta específica anterior
  
    switch (opcion) {
      case 'RA':
        preguntaEspecifica.find('label').text('Incluye los metros totales de la RA del día:');
        preguntaEspecifica.show();
        break;
      case 'RD':
        preguntaEspecifica.find('label').text('Incluye los metros totales de la RD del día:');
        preguntaEspecifica.show();
        break;
      case 'DP':
        preguntaEspecifica.find('label').text('Indica la cantidad de DP (en unidades):');
        preguntaEspecifica.show();
        break;
      case 'BANDEJAS':
        preguntaEspecifica.find('label').text('Incluye la cantidad de bandejas trabajadas en el día:');
        preguntaEspecifica.show();
        break;
      case 'INSTALACIONES':
        preguntaEspecifica.find('label').text('Indica la cantidad de instalaciones realizadas:');
        preguntaEspecifica.show();
        break;
      case 'ACTIVACIONES':
        preguntaEspecifica.find('label').text('Indica la cantidad de activaciones realizadas:');
        preguntaEspecifica.show();
        break;
      case 'BACKBONE':
        preguntaEspecifica.find('label').text('Indica la cantidad de backbone realizadas:');
        preguntaEspecifica.show();
        break;
      case 'FUSIONADO':
        preguntaEspecifica.find('label').text('Indica la cantidad de fusiones realizadas:');
        preguntaEspecifica.show();
        break;
      case 'OTROS':
        // Ocultar la pregunta específica anterior y mostrar la siguiente pregunta directamente
        preguntaEspecifica.hide();
        preguntas.eq(currentPregunta + 2).show();
        currentPregunta++; // Actualizar el índice de la pregunta actual
        break;
    }
  
    // Actualizar el valor del campo oculto respuesta-condicional
    $('#respuesta-condicional').val(opcion);
  }
  


  // Navegar a la siguiente pregunta
  siguienteBtn.click(function() {
    if (currentPregunta < preguntas.length - 1) {
      preguntas.eq(currentPregunta).hide();
      currentPregunta++;
      preguntas.eq(currentPregunta).show();
      preguntaEspecifica.hide(); // Ocultar la pregunta específica si está visible
      actualizarBotones();
    }
  });

  // Navegar a la pregunta anterior
  anteriorBtn.click(function() {
    if (currentPregunta > 0) {
      preguntas.eq(currentPregunta).hide();
      currentPregunta--;
      preguntas.eq(currentPregunta).show();
      preguntaEspecifica.hide(); // Ocultar la pregunta específica si está visible
      actualizarBotones();
    }
  });

  // Manejar la selección de opciones
  $('.pregunta').on('click', '.opcion', function() {
    var selectedOption = $(this).text();

    if (preguntas.eq(currentPregunta).hasClass('trabajaste-en-grupo')) {
      if (selectedOption === 'Sí') {
        preguntas.eq(currentPregunta).hide();
        currentPregunta++;
        preguntas.eq(currentPregunta).show();
      } else if (selectedOption === 'No') {
        preguntas.eq(currentPregunta).hide();
        currentPregunta += 2; // Saltar dos preguntas adicionales
        preguntas.eq(currentPregunta).show();
      }
    } else {
      preguntas.eq(currentPregunta).hide();
      currentPregunta++;
      preguntas.eq(currentPregunta).show();
    }

    actualizarBotones();

    // Mostrar/ocultar pregunta específica si es la pregunta de tipo de trabajo
    if (preguntas.eq(currentPregunta).attr('id') === 'pregunta5') {
      mostrarPreguntaEspecifica(selectedOption);
    }

    // Guardar el tipo de trabajo en la base de datos
    guardarTipoTrabajo(selectedOption);
  });

  // Actualizar botones al cargar la página
  actualizarBotones();

  // Manejar la selección de tipo de trabajo
  $('#tipo-trabajo').on('change', function() {
    var selectedOption = $(this).val();

    mostrarPreguntaEspecifica(selectedOption);
    guardarTipoTrabajo(selectedOption);
  });

  // Función para guardar el tipo de trabajo en la base de datos
  function guardarTipoTrabajo(tipoTrabajo) {
    // Realizar la solicitud AJAX para enviar los datos al archivo PHP
    $.ajax({
      url: 'registrar.php', // Reemplaza 'registrar.php' por la URL correcta del archivo PHP
      method: 'POST',
      data: { tipoTrabajo: tipoTrabajo },
      success: function(response) {
        // Aquí puedes agregar cualquier código que desees ejecutar después de guardar el tipo de trabajo en la base de datos
        console.log('Tipo de trabajo guardado en la base de datos.');
      },
      error: function(xhr, status, error) {
        // Manejar el error de la solicitud AJAX
        console.error('Error al guardar el tipo de trabajo en la base de datos:', error);
      }
    });
  }
});
