<?php
$pestaña_activa = $pestaña_activa ?? 'teoria';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unidad 3 - Teoría del Muestreo y Tamaño de Muestra</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
    
</head>
<body>
    <?php include_once '../menu.php'; ?>

<div class="main-content">
    <h1>Teoría Elemental del Muestreo y Tamaño de la Muestra</h1>
    <div class="tabs">
                <button class="tab-button <?php echo ($pestaña_activa == 'teoria') ? 'active' : ''; ?>" onclick="switchTab('teoria')">📖 Zona Teórica</button>
                <button class="tab-button <?php echo ($pestaña_activa == 'practica') ? 'active' : ''; ?>" onclick="switchTab('practica')">⚡ Zona Práctica</button>
            </div>

    <!-- ZONA TEORICA-->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- TARJETA 1: Conceptos Fundamentales, Parámetros y Estadígrafos -->
        <div class="card">
            <h3>Teoría Elemental del Muestreo</h3>
            <p>
                Estudia las relaciones que existen entre una <strong>población</strong> (todas las observaciones posibles, ya sea <em>finita</em> o <em>infinita</em>) y las <strong>muestras</strong> extraídas de ella para efectuar una investigación.
            </p>
            <ul>
                <li><strong>Parámetros (Población):</strong> Media poblacional (<strong>μ</strong>), desviación (<strong>σ</strong>), varianza (<strong>σ<sup>2</sup></strong>) y proporción (<strong>P</strong>).</li>
                <li><strong>Estadígrafos (Muestra):</strong> Media muestral (<strong>X̄</strong>), desviación (<strong>s</strong>), varianza muestral (<strong>s<sup>2</sup></strong>) y proporción (<strong>p</strong>).</li>
                <li><strong>Etapas:</strong> <em>Medición</em> (contar, medir o encuestar), <em>Estimación</em> (deducir sobre el total) y <em>Lista</em> (inventario codificado de unidades).</li>
            </ul>
        </div>

        <!-- TARJETA 2: Técnicas de Muestreo Aleatorio -->
        <div class="card">
            <h3>Técnicas de Muestreo Aleatorio</h3>
            <ul>
                <li><strong>a) Aleatorio Simple:</strong> Selección al azar de uno en uno; cada elemento tiene igual probabilidad de inclusión (<strong>n / N</strong>).</li>
                <li><strong>b) Aleatorio Sistemático:</strong> Se define un intervalo <strong>K = N / n</strong>, se elige un arranque aleatorio <strong>r</strong> entre 1 y K, y se seleccionan elementos cada K posiciones.</li>
                <li><strong>c) Aleatorio Estratificado:</strong> Divide la población en estratos homogéneos y reparte <strong>n</strong> proporcionalmente mediante regla de tres: <strong>n<sub>i</sub> = n · (N<sub>i</sub> / N)</strong>.</li>
            </ul>
            <p>
                <strong>Ejemplo Estratificado (Apuntes):</strong> Con <strong>N = 2,030</strong> y <strong>n = 150</strong> repartidos en 7 especialidades (Alimentos 350 → 25, Automotriz 400 → 30, etc.), la suma cierra exactamente en <strong>150</strong>.
            </p>
        </div>

        <!-- TARJETA 3: Cálculo del Tamaño de Muestra y Error Muestral -->
        <div class="card">
            <h3>Tamaño de la Muestra (n) y Error Muestral (E)</h3>
            <p>
                Permite determinar el tamaño óptimo de muestra para evitar costos elevados o resultados no válidos. El <strong>error muestral (E)</strong> es el error máximo permisible (si se conocen medias: <strong>E = |X̄ − μ|</strong>).
            </p>
            <div class="formula-box">
                <h4>Fórmulas para Proporciones (p, q)</h4>
                <div class="math-expression" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 18px; font-size: 1.05em;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span><strong>Infinita:</strong> n =</span>
                        <span style="display: inline-flex; flex-direction: column; align-items: center;">
                            <span style="border-bottom: 1px solid currentColor; padding: 0 6px 2px;">Z<sup>2</sup> · p · q</span>
                            <span style="padding: 2px 6px 0;">E<sup>2</sup></span>
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span><strong>Finita:</strong> n =</span>
                        <span style="display: inline-flex; flex-direction: column; align-items: center;">
                            <span style="border-bottom: 1px solid currentColor; padding: 0 6px 2px;">N · Z<sup>2</sup> · p · q</span>
                            <span style="padding: 2px 6px 0;">E<sup>2</sup>(N − 1) + Z<sup>2</sup> · p · q</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="formula-box">
                <h4>Fórmula con Varianza (σ<sup>2</sup>)</h4>
                <div class="math-expression" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 1.08em;">
                    <span>n =</span>
                    <span style="display: inline-flex; flex-direction: column; align-items: center;">
                        <span style="border-bottom: 1px solid currentColor; padding: 0 8px 2px;">Z<sup>2</sup> · σ<sup>2</sup></span>
                        <span style="padding: 2px 8px 0;">E<sup>2</sup></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content <?php echo (isset($pestaña_activa) && $pestaña_activa == 'practica') ? 'active' : ''; ?>">
    <div class="card practice-card">
        <h3>Calculadora de Tamaño de Muestra y Muestreo Estratificado</h3>
        <p class="section-description">
            Calcula el tamaño de muestra óptimo (<strong>n</strong>) para poblaciones finitas o infinitas, o realiza el <strong>reparto proporcional por estratos</strong> de tus apuntes.
        </p>

        <form id="form-muestra" data-action="tamano_muestra" data-endpoint="../../Controllers/controlador_u3.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="modo_muestreo">Tipo de cálculo</label>
                    <select id="modo_muestreo" name="modo_muestreo">
                        <option value="proporcion" selected>1. Tamaño de Muestra por Proporciones (p, q)</option>
                        <option value="varianza">2. Tamaño de Muestra con Desviación (σ)</option>
                        <option value="estratificado">3. Reparto Estratificado Proporcional</option>
                    </select>
                    <small class="field-hint">Selecciona según los datos disponibles.</small>
                </div>

                <!-- TIPO DE POBLACIÓN (Modos 1 y 2) -->
                <div class="form-group" data-grupo-muestra="proporcion varianza">
                    <label for="tipo_poblacion">Tipo de población</label>
                    <select id="tipo_poblacion" name="tipo_poblacion">
                        <option value="infinita" selected>Infinita (N desconocida o muy grande)</option>
                        <option value="finita">Finita (N conocida)</option>
                    </select>
                    <small class="field-hint">Define si se aplica factor de corrección por N.</small>
                </div>

                <div class="form-group" data-grupo-muestra="proporcion varianza" data-solo-finita="true" hidden>
                    <label for="poblacion_N">Tamaño de la población (N)</label>
                    <input type="number" id="poblacion_N" name="poblacion_N" value="2030" min="2" step="1" placeholder="Ej: 2030">
                    <small class="field-hint">Total de unidades elementales de la población.</small>
                </div>

                <div class="form-group" data-grupo-muestra="proporcion varianza">
                    <label for="confianza">Nivel de confianza (1 − α)</label>
                    <select id="confianza" name="confianza">
                        <option value="0.90">90% (Z = 1.645)</option>
                        <option value="0.95" selected>95% (Z = 1.96)</option>
                        <option value="0.99">99% (Z = 2.576)</option>
                    </select>
                    <small class="field-hint">Determina el valor crítico Z automáticamente.</small>
                </div>

                <div class="form-group" data-grupo-muestra="proporcion varianza">
                    <label for="error_m">Error muestral máximo permisible (E)</label>
                    <input type="number" id="error_m" name="error_m" value="0.05" min="0.0001" step="any" placeholder="Ej: 0.05">
                    <small class="field-hint">En proporciones usa decimal (ej. 5% = 0.05); con σ usa mismas unidades.</small>
                </div>

                <!-- SOLO MODO 1: PROPORCIONES -->
                <div class="form-group" data-grupo-muestra="proporcion">
                    <label for="p">Probabilidad de éxito / proporción (p)</label>
                    <input type="number" id="p" name="p" value="0.5" min="0.001" max="0.999" step="any" placeholder="Ej: 0.5">
                    <small class="field-hint">Si se desconoce, usa 0.5 (varianza máxima).</small>
                </div>
                <div class="form-group" data-grupo-muestra="proporcion">
                    <label for="q">Probabilidad de fracaso (q = 1 − p)</label>
                    <input type="number" id="q" name="q" value="0.5" min="0.001" max="0.999" step="any" placeholder="Ej: 0.5">
                    <small class="field-hint">Complemento de p (p + q = 1).</small>
                </div>

                <!-- SOLO MODO 2: DESVIACIÓN ESTÁNDAR -->
                <div class="form-group" data-grupo-muestra="varianza" hidden>
                    <label for="sigma_muestra">Desviación estándar (σ)</label>
                    <input type="number" id="sigma_muestra" name="sigma_muestra" value="15" min="0.0001" step="any" placeholder="Ej: 15">
                    <small class="field-hint">Desviación típica poblacional o piloto.</small>
                </div>

                <!-- SOLO MODO 3: MUESTREO ESTRATIFICADO -->
                <div class="form-group" data-grupo-muestra="estratificado" hidden>
                    <label for="estratos_nombres">Nombres de los estratos</label>
                    <input type="text" id="estratos_nombres" name="estratos_nombres"
                           value="Alimentos, Automotriz, Eléctrica, Mecánica, Sistemas y Redes, Civil y Arquitectura, Confección">
                    <small class="field-hint">Separa cada estrato con una coma.</small>
                </div>
                <div class="form-group" data-grupo-muestra="estratificado" hidden>
                    <label for="estratos_tamanos">Población de cada estrato (N<sub>i</sub>)</label>
                    <input type="text" id="estratos_tamanos" name="estratos_tamanos"
                           value="350, 400, 300, 250, 380, 200, 150">
                    <small class="field-hint">Cantidad de elementos en cada estrato (suma = N).</small>
                </div>
                <div class="form-group" data-grupo-muestra="estratificado" hidden>
                    <label for="muestra_total_n">Tamaño total de la muestra a repartir (n)</label>
                    <input type="number" id="muestra_total_n" name="muestra_total_n" value="150" min="1" step="1">
                    <small class="field-hint">Muestra total que se distribuirá proporcionalmente.</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular Muestra</button>
                <button type="button" class="btn-secondary" data-ejemplo="muestra">Cargar ejemplo (Estratificado)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-muestra" class="practice-results" hidden aria-live="polite"></div>
</div>

<script src="../assets/js/practica.js"></script>
<script>
    (function () {
        const selectModo = document.getElementById('modo_muestreo');
        const selectPob = document.getElementById('tipo_poblacion');
        const grupos = document.querySelectorAll('[data-grupo-muestra]');
        const campoN = document.querySelector('[data-solo-finita="true"]');
        const inputP = document.getElementById('p');
        const inputQ = document.getElementById('q');

        function actualizarCamposMuestra() {
            const modo = selectModo.value;
            const tipoPob = selectPob.value;

            grupos.forEach(grupo => {
                const permitidos = grupo.getAttribute('data-grupo-muestra').split(' ');
                grupo.hidden = !permitidos.includes(modo);
            });

            if (modo === 'proporcion' || modo === 'varianza') {
                campoN.hidden = (tipoPob !== 'finita');
            }
        }

        // Sincronizar automáticamente q = 1 - p cuando el usuario escribe p
        inputP.addEventListener('input', function () {
            const valP = parseFloat(inputP.value);
            if (!isNaN(valP) && valP > 0 && valP < 1) {
                inputQ.value = +(1 - valP).toFixed(6);
            }
        });

        selectModo.addEventListener('change', actualizarCamposMuestra);
        selectPob.addEventListener('change', actualizarCamposMuestra);

        Practica.ejemplos.muestra = {
            modo_muestreo: 'estratificado',
            estratos_nombres: 'Alimentos, Automotriz, Eléctrica, Mecánica, Sistemas y Redes, Civil y Arquitectura, Confección',
            estratos_tamanos: '350, 400, 300, 250, 380, 200, 150',
            muestra_total_n: '150'
        };

        Practica.conectar('form-muestra', 'resultado-muestra');

        document.getElementById('form-muestra').addEventListener('click', function (e) {
            if (e.target.matches('[data-ejemplo], [data-limpiar]')) {
                setTimeout(actualizarCamposMuestra, 0);
            }
        });

        actualizarCamposMuestra();
    })();
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
