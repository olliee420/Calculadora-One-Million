<?php
$titulo_pagina = 'Medidas de Dispersión';
$descripcion_pagina = 'Desviación media, desviación estándar, varianza y coeficiente de variabilidad para series simples y agrupadas.';
include __DIR__ . '/../partials/head.php';
?>

<h1>📉 Medidas de Dispersión</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Desviación Media -->
        <div class="card">
            <h3>1. Desviación Media (\(Dm\))</h3>
            <p>
                Las <strong>medidas de dispersión</strong> tienen por objetivo mostrar qué tan dispersos o
                separados se encuentran los datos en una distribución. La <strong>Desviación Media</strong>
                se define como la media aritmética de las desviaciones de todos sus términos respecto a la
                media sin considerar el signo (utilizando valor absoluto). En general, entre menor sea esta
                medida, menos dispersión tienen los datos de la serie.
            </p>
            <div class="formula-box">
                <h4>Fórmulas (Serie Simple y Agrupada)</h4>
                <div class="math-expression">\[Dm = \frac{\sum \lvert x - \bar{x} \rvert}{n} \qquad \text{y} \qquad Dm = \frac{\sum \lvert Pm - \bar{x} \rvert \cdot f}{n}\]</div>
            </div>
        </div>

        <!-- Tarjeta 2: Desviación Estándar y Varianza -->
        <div class="card">
            <h3>2. Desviación Estándar (\(\sigma\)) y Varianza (\(S\))</h3>
            <p>
                En la desviación media se prescinde de los signos con valor absoluto; para que el cálculo
                estuviera basado en la matemática, se ideó la <strong>desviación estándar (\(\sigma\))</strong>,
                donde cada desviación se eleva al cuadrado para que todos los resultados sean positivos.
                La <strong>varianza (\(S = \sigma^2\))</strong> es el cuadrado de la desviación típica.
            </p>
            <div class="formula-box">
                <h4>Fórmulas de Desviación Estándar y Varianza</h4>
                <div class="math-expression">\[\sigma = \sqrt{\frac{\sum(x - \bar{x})^2}{n}} \qquad \text{y} \qquad \sigma = \sqrt{\frac{\sum(Pm - \bar{x})^2 \cdot f}{n}}\]</div>
                <div class="math-expression">\[S = \sigma^2\]</div>
            </div>
        </div>

        <!-- Tarjeta 3: Coeficiente de Variabilidad y Tabla del Cuaderno -->
        <div class="card">
            <h3>3. Coeficiente de Variabilidad (\(CV\))</h3>
            <p>
                Una medida de variabilidad definirá mejor dispersión cuanto menor sea su valor. Para
                establecer diferencia en la dispersión de dos o más variables se utiliza el <strong>coeficiente
                de variabilidad</strong>, que es una medida relativa abstracta:
            </p>
            <div class="formula-box">
                <div class="math-expression">\[CV = \left( \frac{\sigma}{\bar{x}} \right) \cdot 100\]</div>
                <p class="formula-caption">
                    <strong>Ejemplo (120 estudiantes):</strong> Con \(\bar{x} = 44.58\) y \(\sigma = 8.13 \implies CV = \left(\frac{8.13}{44.58}\right) \cdot 100 = \mathbf{18.24\%}\) (Media bastante representativa).
                </p>
            </div>
            <h4>Tabla de Interpretación del CV</h4>
            <div style="overflow-x: auto;">
                <table class="data-table" style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Valor del Coeficiente de Variabilidad</th>
                            <th style="text-align: left;">Grado de representatividad de la \(\bar{x}\)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>De 0 a menos de 10%</td><td>Media altamente representativa</td></tr>
                        <tr><td>De 10 a menos de 20%</td><td>Media bastante representativa</td></tr>
                        <tr><td>De 20 a menos de 30%</td><td>Tiene representatividad</td></tr>
                        <tr><td>De 30 a menos de 40%</td><td>Representatividad dudosa</td></tr>
                        <tr><td>40% o más</td><td>Carente de representatividad</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tarjeta 4: Ejemplos Resueltos del Cuaderno -->
        <div class="card">
            <h3>4. Ejemplos Resueltos del Cuaderno</h3>
            <ul>
                <li><strong>Ejemplo 1 — Datos No Agrupados (`3, 5, 6, 9, 10, 15`, \(n = 6\)):</strong>
                    <ul>
                        <li>Media: \(\bar{x} = \frac{48}{6} = \mathbf{8}\)</li>
                        <li>Desviación Media: \(Dm = \frac{20}{6} = \mathbf{3.33}\)</li>
                        <li>Desviación Estándar: \(\sigma = \sqrt{\frac{92}{6}} = \sqrt{15.33} = \mathbf{3.92}\)</li>
                    </ul>
                </li>
                <li><strong>Ejemplo 2 — Datos Agrupados (clases `5-7` a `17-19`, \(n = 54\)):</strong>
                    <ul>
                        <li>Media: \(\bar{x} = \frac{662}{54} = \mathbf{12.26}\)</li>
                        <li>Desviación Media: \(Dm = \frac{148.6}{54} = \mathbf{2.75}\)</li>
                        <li>Desviación Estándar: \(\sigma = \sqrt{\frac{600.5}{54}} = \sqrt{11.12} = \mathbf{3.33}\)</li>
                        <li>Varianza: \(S = (3.33)^2 = \mathbf{11.12}\)</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular Medidas de Dispersión</h3>
        <p class="section-description">
            Selecciona si deseas evaluar una serie simple o una serie agrupada para obtener la Desviación Media (Dm),
            Varianza (S), Desviación Estándar (σ) y el Coeficiente de Variabilidad (CV) con su diagnóstico.
        </p>

        <form id="form-dispersion" data-action="u1_dispersion" data-endpoint="../../Controllers/controlador_u1.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="tipo_datos_disp">Tipo de serie</label>
                    <select id="tipo_datos_disp" name="tipo_datos">
                        <option value="no_agrupados" selected>Serie Simple (datos individuales)</option>
                        <option value="agrupados">Serie Agrupada (clases y frecuencias)</option>
                    </select>
                </div>

                <div class="form-group" id="grupo-simple-disp" style="grid-column: 1 / -1;">
                    <label for="datos_disp">Datos de la serie simple (separados por comas)</label>
                    <input type="text" id="datos_disp" name="datos" value="3, 5, 6, 9, 10, 15" placeholder="Ej: 3, 5, 6, 9, 10, 15">
                </div>

                <div class="form-group" id="grupo-int-disp" hidden>
                    <label for="intervalos_disp">Intervalos de clase (separados por comas)</label>
                    <input type="text" id="intervalos_disp" name="intervalos" value="5-7, 7-9, 9-11, 11-13, 13-15, 15-17, 17-19">
                </div>

                <div class="form-group" id="grupo-freq-disp" hidden>
                    <label for="frecuencias_disp">Frecuencias absolutas f (separadas por comas)</label>
                    <input type="text" id="frecuencias_disp" name="frecuencias" value="3, 7, 10, 12, 9, 8, 5">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular dispersión</button>
                <button type="button" class="btn-secondary" data-ejemplo="disp_simple">Ej. Simple (Cuaderno)</button>
                <button type="button" class="btn-secondary" data-ejemplo="disp_agrupado">Ej. Agrupado (n=54)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-dispersion" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    (function () {
        var tipo = document.getElementById('tipo_datos_disp');
        var grupoSimple = document.getElementById('grupo-simple-disp');
        var gruposAgrupados = [
            document.getElementById('grupo-int-disp'),
            document.getElementById('grupo-freq-disp')
        ];

        function actualizarCampos() {
            var esAgrupado = tipo.value === 'agrupados';
            grupoSimple.hidden = esAgrupado;
            gruposAgrupados.forEach(function (el) { el.hidden = !esAgrupado; });
        }

        tipo.addEventListener('change', actualizarCampos);
        actualizarCampos();

        Practica.ejemplos.disp_simple = {
            tipo_datos: 'no_agrupados',
            datos: '3, 5, 6, 9, 10, 15'
        };

        Practica.ejemplos.disp_agrupado = {
            tipo_datos: 'agrupados',
            intervalos: '5-7, 7-9, 9-11, 11-13, 13-15, 15-17, 17-19',
            frecuencias: '3, 7, 10, 12, 9, 8, 5'
        };

        document.querySelectorAll('[data-ejemplo]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setTimeout(actualizarCampos, 0);
            });
        });

        Practica.conectar('form-dispersion', 'resultado-dispersion');
    })();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
