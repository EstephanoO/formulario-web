<!DOCTYPE html>
<html>
<head>
    <title>Formulario</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
<div class="logo-container">
    <img src="./Imagenes/logoempresa.jpg" alt="Logo de la empresa" class="logo">
</div>
<div class="container">
<div class="pregunta">
    <div class="instrucciones">
        <p>Por favor, completa el siguiente formulario respondiendo las siguientes preguntas:</p>
        <ul>
            <li>Fecha del Trabajo</li>
            <li>Primer nombre y primer apellido del trabajador</li>
            <li>¿Trabajaste en grupo?</li>
            <li>Primer nombre y primer apellido (en mayúsculas y sin tilde) de las personas con las que trabajaste</li>
            <li>Tipo de trabajo realizado</li>
            <li>Pregunta Específica (solo si aplica)</li>
            <li>Ubicación del trabajo realizado</li>
            <li>Observación</li>
        </ul>
        </div>
    </div>
    <form action="registrar.php" method="POST" onsubmit="return validarFecha()">
        <div class="pregunta">
            <label for="fecha" data-label="1.">Fecha del Trabajo</label>
            <div class="fecha-container">
                <input type="number" id="dia" name="dia" min="1" max="31" required>
                <span>/</span>
                <input type="number" id="mes" name="mes" min="1" max="12" required>
                <span>/</span>
                <input type="number" id="anio" name="anio" value="2023" min="1900" required>
            </div>
        </div>

        <div class="pregunta">
            <label for="nombre">Nombre del trabajador:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="pregunta trabajaste-en-grupo">
            <label for="trabajaste">¿Trabajaste en grupo?</label>
            <div class="opciones-container">
                <button type="submit" class="opcion" name="trabajo-grupo" value="Si" data-next="3">Sí</button>
                <button type="submit" class="opcion opcion-no" name="trabajo-grupo" value="No" data-next="5">No</button>
            </div>
        </div>

        <div class="pregunta">
            <label for="personas">Nombre y Apellido de las personas con las que trabajaste:</label>
            <input type="text" id="personas" name="personas">
            <span class="spanNombres">Separar por ',' ejemplo: Nombre1, Nombre2, Nombre3, etc...</span>
        </div>

        <!-- Opciones del trabajo realizado -->
        <div class="pregunta" id="pregunta5">
            <label for="tipo-trabajo">Selecciona el tipo de trabajo que realizaste:</label>
            <div class="select-container">
            <select name="tipo-trabajo" id="tipo-trabajo" onchange="setCasilla(this.value)">
                <option value="RD">RD</option>
                <option value="RA">RA</option>
                <option value="DP">DP</option>
                <option value="BANDEJAS">BANDEJAS</option>
                <option value="INSTALACIONES">INSTALACIONES</option>
                <option value="ACTIVACIONES">ACTIVACIONES</option>
                <option value="BACKBONE">BACKBONE(Soplado RA)</option>
                <option value="FUSIONADO">BACKBONE(Fusiones)</option>
                <option value="OTROS">OTROS</option>
            </select>
            </div>
            <input type="hidden" name="respuesta-condicional" id="respuesta-condicional" value="">
        </div>
        <!-- Fin de opciones del trabajo realizado -->

        <div id="pregunta-especifica" class="pregunta pregunta-especifica">
            <label id="label-especifico" class="label-especifico">Pregunta Específica:</label>
            <div class="input-container">
                <input type="text" id="preguntas-especifica" name="especifica">
            </div>
        </div>

        <div class="pregunta">
            <label for="trabajo-realizado">Especifica la ubicación del trabajo realizado:</label>
            <div class="input-container">
                <input type="text" name="casilla1" id="casillaRD" maxlength="3" placeholder="Letras">
                <input type="text" name="casilla2" id="casillaRA" maxlength="5">
                <input type="text" name="casilla3" id="casillaDP" maxlength="5" value="DP">
            </div>
        </div>

        <div class="pregunta">
            <label for="tiempo-trabajado">Observación</label>
            <textarea id="tiempo-trabajado" name="tiempo-trabajado" rows="4" minlength="1" required></textarea>
        </div>

        <div class="botones">
            <div class="botones-izquierda">
                <button type="button" id="anterior" disabled>←</button>
            </div>
            <div class="botones-derecha">
                <button type="button" id="siguiente">Next</button>
                <button type="submit" name="enviar" style="display: none;">Enviar</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
