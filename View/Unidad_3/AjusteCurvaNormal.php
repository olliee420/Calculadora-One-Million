<?php

if (!isset($pestaña_activa)) {
    $pestaña_activa = 'teoria';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unidad 3 - La Curva Normal </title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<div class="main-content">
    <?php include_once '../menu.php'; ?>
    <h1>La Curva Normal (Ajuste y Área Z)</h1>
    <div class="tabs">
                <button class="tab-button <?php echo ($pestaña_activa == 'teoria') ? 'active' : ''; ?>" onclick="switchTab('teoria')">📖 Zona Teórica</button>
                <button class="tab-button <?php echo ($pestaña_activa == 'practica') ? 'active' : ''; ?>" onclick="switchTab('practica')">⚡ Zona Práctica</button>
            </div>

    <!-- ZONA TEORICA-->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- TARJETA 1: Definición, Propiedades y Curtosis -->
        <div class="card">
            <h3>La Curva Normal y sus Propiedades</h3>
            <p>
                La <strong>curva normal</strong> puede considerarse como el límite de un histograma o representación gráfica de una distribución de frecuencias, cuando el número de clases se hace muy grande y el único factor que interviene es la probabilidad.
            </p>
            <ul>
                <li>Tiene forma de <strong>campana</strong> y es <strong>simétrica</strong> respecto a su eje central (media = mediana = moda).</li>
                <li>Es <strong>asintótica</strong> al eje horizontal (se acerca indefinidamente sin llegar a tocarlo).</li>
                <li>El área total bajo la curva es igual a <strong>1</strong> (o <strong>100%</strong>), repartida en 50% a cada lado de la media.</li>
                <li>Sus puntos de inflexión se encuentran a <strong>±1 desviación estándar</strong> de la media, y queda determinada por <strong>μ</strong> y <strong>σ</strong>.</li>
            </ul>
            <p>
                <strong>Tipos de curtosis (forma de la curva):</strong> <em>Leptocúrtica</em> (muy apuntada), <em>Mesocúrtica</em> (normal) y <em>Platicúrtica</em> (aplanada).
            </p>
        </div>

        <!-- TARJETA 2: Ecuación de Ajuste de Frecuencias -->
        <div class="card">
            <h3>Ecuación de Ajuste de Frecuencias</h3>
            <p>
                Permite calcular la frecuencia teórica esperada (<strong>Y</strong>) para cada intervalo de clase de una variable estadística (<strong>X</strong>):
            </p>
            <div class="formula-box">
                <h4>Ecuación de la Curva Ajustada</h4>
                <div class="math-expression" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 1.12em;">
                    <span>Y =</span>
                    <span style="display: inline-flex; flex-direction: column; align-items: center; vertical-align: middle;">
                        <span style="border-bottom: 1px solid currentColor; padding: 0 8px 2px;">n · i</span>
                        <span style="padding: 2px 8px 0;">σ · √(2π)</span>
                    </span>
                    <span>· e</span>
                    <sup style="display: inline-flex; flex-direction: column; align-items: center; font-size: 0.78em; margin-top: -14px;">
                        <span>−</span>
                    </sup>
                    <sup style="display: inline-flex; flex-direction: column; align-items: center; font-size: 0.72em; margin-top: -14px;">
                        <span style="border-bottom: 1px solid currentColor; padding: 0 4px;">x<sup>2</sup></span>
                        <span style="padding: 0 4px;">2σ<sup>2</sup></span>
                    </sup>
                </div>
            </div>
            <ul>
                <li><strong>Y<sub>0</sub> = (n · i) / (σ · √2π):</strong> Altura o frecuencia máxima cuando x = 0.</li>
                <li><strong>n:</strong> Número total de observaciones &nbsp;|&nbsp; <strong>i:</strong> Ancho del intervalo de clase.</li>
                <li><strong>Procedimiento:</strong> 1) Hallar X̄ y σ; 2) Calcular altura máxima Y<sub>0</sub>; 3) Estandarizar cada clase con <strong>X<sub>k</sub> = (Pm − X̄) / σ</strong>, multiplicar Y<sub>0</sub> por su ordenada relativa y redondear ajustando para que cierre en <strong>n</strong>.</li>
            </ul>
        </div>

        <!-- TARJETA 3: Área bajo la Curva y Puntuación Z -->
        <div class="card">
            <h3>Área bajo la Curva Normal (Puntuación Z)</h3>
            <p>
                El área bajo la curva representa el <strong>100%</strong> de las observaciones (50% = 0.5000 a cada lado de la media). Para ubicar cualquier punto <strong>X</strong> se estandariza mediante:
            </p>
            <div class="formula-box">
                <h4>Fórmula de Puntuación Z</h4>
                <div class="math-expression" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 1.15em;">
                    <span>Z =</span>
                    <span style="display: inline-flex; flex-direction: column; align-items: center; vertical-align: middle;">
                        <span style="border-bottom: 1px solid currentColor; padding: 0 10px 2px;">X − X̄</span>
                        <span style="padding: 2px 10px 0;">σ</span>
                    </span>
                </div>
            </div>
            <ul>
                <li><strong>Regla de signos:</strong> Si Z es <em>negativo</em>, el área está a la izquierda de X̄; si es <em>positivo</em>, está a la derecha.</li>
                <li><strong>Área entre dos valores:</strong> Si un valor es <strong>(−)</strong> y otro <strong>(+)</strong>, las áreas centrales se <strong>suman</strong>; si ambos tienen el <strong>mismo signo</strong>, se <strong>restan</strong>.</li>
                <li><strong>Colas extremas:</strong> Para hallar áreas en los extremos (Z &gt; +z o Z &lt; −z), se resta el área central a <strong>0.5</strong>.</li>
            </ul>
        </div>

        <!-- TARJETA 4: Ejemplos de Clase -->
        <div class="card">
            <h3>Ejemplos de Clase (Apuntes)</h3>
            <p>
                <strong>1. Ajuste de Frecuencias (Salarios):</strong> Para <strong>n = 25</strong> empleados en 6 clases de ancho <strong>i = 3</strong>, se obtuvo <strong>X̄ = 9.06</strong>, <strong>σ = 3.90</strong> y altura máxima <strong>Y<sub>0</sub> = 7.71</strong>, ajustando las frecuencias teóricas (1, 4, 7, 7, 4, 2) para cerrar en 25.
            </p>
            <p>
                <strong>2. Área y Cantidad Esperada (Pesos):</strong> Para <strong>n = 500</strong> estudiantes con <strong>X̄ = 151 lb</strong> y <strong>σ = 15 lb</strong>, el porcentaje entre 120 y 155 lb (<strong>−2.07 &lt; Z &lt; 0.27</strong>) es 0.4808 + 0.1064 = <strong>58.72%</strong>, lo que equivale a <strong>(500 · 58.72) / 100 ≈ 294</strong> estudiantes.
            </p>
        </div>
    </div>
</div>


    <!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content <?php echo (isset($pestaña_activa) && $pestaña_activa == 'practica') ? 'active' : ''; ?>">
    <div class="card practice-card">
        <h3>Herramientas de la Curva Normal</h3>
        <p class="section-description">
            Selecciona si deseas <strong>ajustar una distribución de frecuencias agrupadas</strong> a la campana normal, o <strong>calcular áreas y porcentajes bajo la curva</strong> mediante puntuaciones Z.
        </p>

        <form id="form-ajuste-normal" data-action="ajuste_normal" data-endpoint="../../Controllers/controlador_u3.php"
>
            <div class="form-grid">
                <div class="form-group">
                    <label for="modo_curva">Tipo de problema a resolver</label>
                    <select id="modo_curva" name="modo_curva">
                        <option value="ajuste" selected>1. Ajuste de Frecuencias (Tabla Agrupada)</option>
                        <option value="area_datos">2. Área bajo la Curva con Datos (X, X̄, σ, n)</option>
                        <option value="area_z">3. Área bajo la Curva con Z Directo</option>
                    </select>
                    <small class="field-hint">Elige según los datos de tu ejercicio.</small>
                </div>

                <!-- ========================================================= -->
                <!-- MODO 1: AJUSTE DE FRECUENCIAS (TABLA AGRUPADA)            -->
                <!-- ========================================================= -->
                <div class="form-group" data-grupo-curva="ajuste">
                    <label for="intervalos">Intervalos de clase (Li - Ls)</label>
                    <input type="text" id="intervalos" name="intervalos" value="0-3, 3-6, 6-9, 9-12, 12-15, 15-18"
                           placeholder="Ej: 0-3, 3-6, 6-9, 9-12, 12-15, 15-18">
                    <small class="field-hint">Separa cada clase con coma usando guion (Li-Ls).</small>
                </div>
                <div class="form-group" data-grupo-curva="ajuste">
                    <label for="frecuencias">Frecuencias reales observadas (f)</label>
                    <input type="text" id="frecuencias" name="frecuencias" value="1, 4, 9, 6, 2, 3"
                           placeholder="Ej: 1, 4, 9, 6, 2, 3">
                    <small class="field-hint">Misma cantidad de valores que los intervalos.</small>
                </div>

                <!-- ========================================================= -->
                <!-- MODO 2 Y 3: ÁREA BAJO LA CURVA (CONDICIÓN E INTERVALOS)   -->
                <!-- ========================================================= -->
                <div class="form-group" data-grupo-curva="area_datos area_z" hidden>
                    <label for="tipo_area">Región / Condición a calcular</label>
                    <select id="tipo_area" name="tipo_area">
                        <option value="entre" selected>Entre dos valores (x₁ &lt; X &lt; x₂)</option>
                        <option value="mayor">Mayor que / Cola derecha (X &gt; x₁)</option>
                        <option value="menor">Menor que / Cola izquierda (X &lt; x₁)</option>
                    </select>
                    <small class="field-hint">Selecciona el caso de área sombreada.</small>
                </div>

                <!-- Parámetros poblacionales (solo Modo 2: area_datos) -->
                <div class="form-group" data-grupo-curva="area_datos" hidden>
                    <label for="media_curva">Media aritmética (X̄)</label>
                    <input type="number" id="media_curva" name="media_curva" value="151" step="any" placeholder="Ej: 151">
                    <small class="field-hint">Promedio de la distribución.</small>
                </div>
                <div class="form-group" data-grupo-curva="area_datos" hidden>
                    <label for="desv_curva">Desviación típica (σ)</label>
                    <input type="number" id="desv_curva" name="desv_curva" value="15" min="0.0001" step="any" placeholder="Ej: 15">
                    <small class="field-hint">Debe ser mayor que 0.</small>
                </div>

                <!-- Límites X o Z -->
                <div class="form-group" data-grupo-curva="area_datos area_z" hidden>
                    <label for="val_1" id="label_val_1">Límite inferior / Valor 1 (x₁)</label>
                    <input type="number" id="val_1" name="val_1" value="120" step="any" placeholder="Ej: 120">
                    <small class="field-hint">Primer punto de corte en el eje horizontal.</small>
                </div>
                <div class="form-group" data-grupo-curva="area_datos area_z" data-solo-entre="true" hidden>
                    <label for="val_2" id="label_val_2">Límite superior / Valor 2 (x₂)</label>
                    <input type="number" id="val_2" name="val_2" value="155" step="any" placeholder="Ej: 155">
                    <small class="field-hint">Segundo punto (solo cuando es "Entre dos valores").</small>
                </div>

                <!-- Población opcional n (solo Modo 2: area_datos) -->
                <div class="form-group" data-grupo-curva="area_datos" hidden>
                    <label for="poblacion_n">Total de individuos n (opcional)</label>
                    <input type="number" id="poblacion_n" name="poblacion_n" value="500" min="1" step="1" placeholder="Ej: 500">
                    <small class="field-hint">Si lo ingresas, calcula la cantidad esperada a = (n · %) / 100.</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular Curva Normal</button>
                <button type="button" class="btn-secondary" data-ejemplo="ajusteNormal">Cargar ejemplo (Pesos n=500)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-ajuste-normal" class="practice-results" hidden aria-live="polite"></div>
</div>

<script src="../assets/js/practica.js"></script>
<script>
    (function () {
        const selectModo = document.getElementById('modo_curva');
        const selectTipoArea = document.getElementById('tipo_area');
        const grupos = document.querySelectorAll('[data-grupo-curva]');
        const campoVal2 = document.querySelector('[data-solo-entre="true"]');
        const labelVal1 = document.getElementById('label_val_1');
        const labelVal2 = document.getElementById('label_val_2');

        function actualizarCamposCurva() {
            const modo = selectModo.value;
            const tipo = selectTipoArea.value;

            grupos.forEach(grupo => {
                const modosPermitidos = grupo.getAttribute('data-grupo-curva').split(' ');
                grupo.hidden = !modosPermitidos.includes(modo);
            });

            if (modo === 'area_datos' || modo === 'area_z') {
                campoVal2.hidden = (tipo !== 'entre');
                const simbolo = (modo === 'area_z') ? 'Z' : 'x';
                labelVal1.textContent = (tipo === 'entre')
                    ? `Límite inferior (${simbolo}₁)`
                    : `Valor a evaluar (${simbolo})`;
                labelVal2.textContent = `Límite superior (${simbolo}₂)`;
            }
        }

        selectModo.addEventListener('change', actualizarCamposCurva);
        selectTipoArea.addEventListener('change', actualizarCamposCurva);

        Practica.ejemplos.ajusteNormal = {
            modo_curva: 'area_datos',
            tipo_area: 'entre',
            media_curva: '151',
            desv_curva: '15',
            val_1: '120',
            val_2: '155',
            poblacion_n: '500'
        };

        Practica.conectar('form-ajuste-normal', 'resultado-ajuste-normal');

        document.getElementById('form-ajuste-normal').addEventListener('click', function (e) {
            if (e.target.matches('[data-ejemplo], [data-limpiar]')) {
                setTimeout(actualizarCamposCurva, 0);
            }
        });

        actualizarCamposCurva();
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
