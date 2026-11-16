<?php

// --- CONTROLADOR DE COMUNICACIÓN CON PYTHON (SOPORTE BÁSICO) ---
$variable_nombre = "";
$variable_tipo = "";
$pestaña_activa = "teoria";
$clasificacion_resultado = null;

if (isset($_POST['clasificar'])) {
    $variable_nombre = $_POST['nombre_var'];
    $variable_tipo = $_POST['tipo_var'];
    $pestaña_activa = "practica";

    // Lógica rápida de procesamiento interactivo
    if (!empty($variable_nombre)) {
        switch ($variable_tipo) {
            case 'nominal':
                $clasificacion_resultado = "La variable <strong>'$variable_nombre'</strong> es Cualitativa Nominal. No tiene un orden intrínseco (Ej: Colores, Profesiones). Operaciones válidas: Modas y frecuencias.";
                break;
            case 'ordinal':
                $clasificacion_resultado = "La variable <strong>'$variable_nombre'</strong> es Cualitativa Ordinal. Posee una escala o jerarquía natural (Ej: Nivel de estudio, Rangos militares). Operaciones válidas: Medianas y percentiles categóricos.";
                break;
            case 'discreta':
                $clasificacion_resultado = "La variable <strong>'$variable_nombre'</strong> es Cuantitativa Discreta. Proviene de un conteo y solo admite valores enteros aislados. Es ideal para modelarse con la <strong>Distribución Binomial o Poisson</strong>.";
                break;
            case 'continua':
                $clasificacion_resultado = "La variable <strong>'$variable_nombre'</strong> es Cuantitativa Continua. Proviene de una medición y admite infinitos valores decimales. Se modela típicamente mediante la <strong>Distribución Normal</strong>.";
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora One Milion - Variables Aleatorias</title>
    <!-- Enlace maestro a tu CSS general -->
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

    <div class="layout-container">
        <!-- Barra lateral -->
        <?php include_once '../menu.php'; ?>

        <!-- Panel de contenido -->
        <div class="main-content">
            <h1>🎲 Variantes Aleatorias discretas y continuas</h1>
            
            <div class="tabs">
                <button class="tab-button <?php echo ($pestaña_activa == 'teoria') ? 'active' : ''; ?>" onclick="switchTab('teoria')">📖 Zona Teórica</button>
                <button class="tab-button <?php echo ($pestaña_activa == 'practica') ? 'active' : ''; ?>" onclick="switchTab('practica')">⚡ Zona Práctica</button>
            </div>

            <!-- ZONA TEORICA-->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <div class="card">
            <h3>Variable Aleatoria y Clasificación</h3>
            <p>
                Una <strong>variable aleatoria</strong> se define así cuando los valores que toma corresponden a los distintos resultados posibles de un experimento; por ello, el hecho de que tome un valor particular es un evento aleatorio.
            </p>
            <p>
                Se clasifican en dos grandes grupos:
            </p>
            <ul>
                <li><strong>Variables Cuantitativas (Métricas):</strong> Se dividen en <em>Discretas</em> y <em>Continuas</em>.</li>
                <li><strong>Variables Cualitativas (No métricas):</strong> Se dividen en <em>Nominales</em> y <em>Ordinales</em>.</li>
            </ul>
        </div>

        <div class="card">
            <h3>Variables Cuantitativas o Métricas</h3>
            <p>
                Son aquellas que se expresan mediante valores numéricos y permiten realizar operaciones aritméticas. Se dividen en:
            </p>
            <div class="formula-box">
                <h4>Variable Discreta</h4>
                <p>
                    Toman valores enteros y contables de forma exacta. Generalmente surgen del conteo y no admiten valores intermedios (decimales).
                </p>
                <p><strong>Ejemplos:</strong> Número de hijos, cantidad de autos vendidos, número de asignaturas aprobadas.</p>
            </div>
            <div class="formula-box">
                <h4>Variable Continua</h4>
                <p>
                    Pueden tomar cualquier valor numérico (entero o fraccionario/decimal) dentro de un intervalo previamente especificado.
                </p>
                <p><strong>Ejemplos:</strong> El tiempo en una investigación (horas, minutos, segundos), el peso o la estatura de una persona.</p>
            </div>
        </div>

        <div class="card">
            <h3>Variables Cualitativas o No Métricas</h3>
            <p>
                Especifican y miden cualidades, atributos o categorías en individuos, lugares o cosas a partir de su descripción con palabras. Se subclasifican en:
            </p>
            <div class="formula-box">
                <h4>Variables Nominales</h4>
                <p>
                    Describen una característica que no puede ser cuantificada numéricamente ni posee un orden natural implícito. Aunque se les asignen códigos numéricos (como 1 y 2), estos no tienen valor matemático.
                </p>
                <p><strong>Características:</strong> No llevan orden, no sirven para contar de forma aritmética.</p>
                <p><strong>Ejemplos:</strong> Sexo, idioma, religión, carrera universitaria.</p>
            </div>
            <div class="formula-box">
                <h4>Variables Ordinales</h4>
                <p>
                    Describen características diferenciándolas en categorías establecidas bajo un orden de supremacía o jerarquía, sin medir una diferencia cuantitativa exacta entre niveles (solo expresan que algo es "mejor" o "mayor").
                </p>
                <p><strong>Características:</strong> Poseen un orden lógico inherente, pero no cuantifican.</p>
                <p><strong>Ejemplos:</strong> Estatus social (Bajo, Medio, Alto), calidad de servicio (Bueno, Regular, Malo) o la evaluación de un restaurante.</p>
            </div>
        </div>
    </div>
</div>

                <!-- ZONA PRACTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Clasificar y analizar una variable</h3>
        <p class="section-description">
            Ingresa una lista de datos observados separados por comas (pueden ser números enteros, decimales o categorías en texto). El sistema identificará su tipo según la clasificación teórica.
        </p>

        <form id="form-variable" data-action="u3_variable_aleatoria" data-endpoint="../../Controllers/controlador_u3.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="datos">Datos observados</label>
                    <input type="text" id="datos" name="datos" value="0, 1, 2, 1, 3, 0, 2"
                           placeholder="Ej: 0, 1, 2, 1 o Bueno, Regular, Malo" required>
                    <small class="field-hint">Separa cada observación con una coma.</small>
                </div>
                <div class="form-group">
                    <label for="nombre_variable">Nombre de la variable (opcional)</label>
                    <input type="text" id="nombre_variable" name="nombre_variable" value="Número de hijos"
                           placeholder="Ej: Peso, Sexo, Calidad de servicio">
                    <small class="field-hint">Ayuda a contextualizar el resultado.</small>
                </div>
                <div class="form-group">
                    <label for="tiene_orden">¿Posee orden o jerarquía natural?</label>
                    <select id="tiene_orden" name="tiene_orden">
                        <option value="auto" selected>Detectar automáticamente</option>
                        <option value="si">Sí (Ej: Bajo, Medio, Alto)</option>
                        <option value="no">No (Ej: Sexo, Religión, Idioma)</option>
                    </select>
                    <small class="field-hint">Útil para diferenciar variables cualitativas Nominales de Ordinales.</small>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit">Clasificar variable</button>
                <button type="button" class="btn-secondary" data-ejemplo="variable">Cargar ejemplo</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-variable" class="practice-results" hidden aria-live="polite"></div>
</div>

<!-- Agrega esta línea justo antes de <script>Practica.ejemplos... -->
<script src="../assets/js/practica.js"></script>

<script>
    Practica.ejemplos.variable = {
        datos: 'Bueno, Regular, Malo, Bueno, Bueno, Regular',
        nombre_variable: 'Calidad de servicio',
        tiene_orden: 'si'
    };
    Practica.conectar('form-variable', 'resultado-variable');
</script>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        const contenedor = document.getElementById(tabId);
        if (contenedor) contenedor.classList.add('active');
        
        const botones = document.querySelectorAll('.tab-button');
        if (botones.length >= 2) {
            if (tabId === 'teoria') botones[0].classList.add('active');
            else if (tabId === 'practica') botones[1].classList.add('active');
        }
    }
    
    <?php if (isset($_POST['clasificar'])): ?>
        window.onload = function() {
            switchTab('practica');
        };
    <?php endif; ?>
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>
