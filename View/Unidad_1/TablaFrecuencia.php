<?php
$titulo_pagina = 'Distribución y Tablas de Frecuencia';
$descripcion_pagina = 'Conceptos fundamentales, clasificación de variables y construcción paso a paso de tablas de distribución de frecuencia.';
include __DIR__ . '/../partials/head.php';
?>

<h1>📊 Distribución y Tablas de Frecuencia</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Conceptos Fundamentales -->
        <div class="card">
            <h3>1. Conceptos Fundamentales de Estadística</h3>
            <ul>
                <li><strong>Estadística Descriptiva:</strong> Es aquella que incluye los métodos de recopilación, organización, presentación, análisis e interpretación de un grupo de datos sin ningún intento por hacer una predicción.</li>
                <li><strong>Estadística Inductiva:</strong> Es aquella que incluye los métodos de generalización, estimación o predicción de las características de una población basados en una muestra.</li>
                <li><strong>Población o universo:</strong> Es el área de la cual los datos estadísticos son recopilados.</li>
                <li><strong>Muestra:</strong> Es el conjunto de elementos representativos de la población. <em>Nota: Para que sea representativa, como mínimo la muestra tiene que ser el <strong>30%</strong> de la población (\(N\)).</em></li>
            </ul>
        </div>

        <!-- Tarjeta 2: Clasificación de Variables y Series -->
        <div class="card">
            <h3>2. Variables y Series de Datos</h3>
            <ul>
                <li><strong>Variables cuantitativas:</strong> Son las características cuantitativas; se basan en la medida y ponderación de los hechos (como el peso, la estatura, etc.). Se dividen en:
                    <ul>
                        <li><em>Variable discreta:</em> Sus valores se interrumpen o se separan; no puede tomar cualquier valor entre dos valores dados. Son aquellas que no se miden sino que se cuentan (ej. número de escuelas).</li>
                        <li><em>Variable continua:</em> Sus valores posibles no tienen interrupción y teóricamente puede tomar cualquier valor entre dos valores dados. Son aquellas que se pueden medir (ej. el peso, la talla, fechas).</li>
                    </ul>
                </li>
                <li><strong>Variables cualitativas:</strong> Son las características de los datos en forma cualitativa, las cuales no pueden ser expresadas en cifras (ej. color de ojos, color de pelo).</li>
                <li><strong>Series Simples:</strong> Contienen un número reducido de observaciones de tal manera que la información puede ser expresada al detalle.</li>
                <li><strong>Series Agrupadas:</strong> Llamadas también distribuciones de frecuencia; tienen una cantidad muy numerosa de observaciones por lo que se agrupan por valores o en clases de acuerdo a alguna característica.</li>
            </ul>
        </div>

        <!-- Tarjeta 3: Elementos de la Tabla de Frecuencia -->
        <div class="card">
            <h3>3. Elementos de una Distribución de Frecuencia</h3>
            <ul>
                <li><strong>Datos brutos o crudos:</strong> Datos recopilados que no han sido organizados numéricamente.</li>
                <li><strong>Arreglos:</strong> Datos brutos organizados en los cuales se observa algún fenómeno (ej. \(4-6-2-9-8-4-8-8 \rightarrow 2-4-4-6-8-8-8-9\)).</li>
                <li><strong>Clase y Número de clases:</strong> La <em>clase</em> es cada grupo que se forma con los datos observados. El número de clases no debe ser ni demasiado grande ni demasiado pequeño.</li>
                <li><strong>Límite de Clases:</strong> Valores extremos de cada clase. El valor con el que comienza se llama <em>Límite Inferior (\(L_i\))</em> y con el que termina se llama <em>Límite Superior (\(L_s\))</em>.</li>
                <li><strong>Punto Medio (\(Pm\)):</strong> Es igual a la semisuma de los límites de clase:
                    <div class="math-expression">\[Pm = \frac{L_i + L_s}{2}\]</div>
                </li>
                <li><strong>Intervalo de Clase (\(Ic\)):</strong> Diferencia entre el límite superior menos el inferior.</li>
                <li><strong>Frecuencia relativa (\(Fr\)) y acumulada (\(Fa\)):</strong>
                    <div class="math-expression">\[Fr = \frac{f}{n}\]</div>
                    La frecuencia acumulada (\(Fa\)) se obtiene sumando la frecuencia absoluta de cada clase con la acumulada anterior.
                </li>
            </ul>
        </div>

        <!-- Tarjeta 4: Los 4 Pasos de Construcción -->
        <div class="card">
            <h3>4. Pasos para Construir la Tabla por Intervalos</h3>
            <ol>
                <li><strong>Calcular el rango (\(R\)):</strong> Ordenar los datos (ascendente o descendente) y restar:
                    <div class="math-expression">\[R = D_{\text{mayor}} - D_{\text{menor}}\]</div>
                </li>
                <li><strong>Calcular el número de clases (\(Nc\)) — Regla de Sturges:</strong>
                    <div class="math-expression">\[Nc = 1 + 3.33 \log(N)\]</div>
                    <em>Nota: Debe redondearse a un número natural.</em>
                </li>
                <li><strong>Calcular el intervalo de clases (\(Ic\)):</strong>
                    <div class="math-expression">\[Ic = \frac{R}{Nc}\]</div>
                    <em>Buena práctica: verificar siempre que \(Nc \times Ic \geq R\).</em>
                </li>
                <li><strong>Calcular los límites de clase y contar frecuencias (\(f\)):</strong> Se cuenta cuántos datos caen dentro de cada rango usando la lista ordenada. <strong>Importante: el límite superior no se incluye en esa clase, pasa a la siguiente</strong> \([L_i, L_s)\).</li>
            </ol>
        </div>
    </div>

    <!-- Tarjeta 5: Ejemplos Resueltos de tus Apuntes -->
    <div class="card">
        <h3>Ejemplos Resueltos del Cuaderno</h3>

        <div class="formula-box">
            <h4>Ejemplo 1: Serie de 50 observaciones</h4>
            <p>
                Con \(N = 50\) datos donde \(D_{\text{menor}} = 100\) y \(D_{\text{mayor}} = 198\):
                \(R = 198 - 100 = 98\); \(\;Nc = 1 + 3.33 \log(50) = 6.65 \rightarrow \mathbf{7}\);
                \(\;Ic = \frac{98}{7} = \mathbf{14}\) (Comprobación: \(7 \times 14 = 98 \geq 98\)).
            </p>
            <div style="overflow-x: auto;">
                <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: center; margin-top: 0.5rem;">
                    <thead>
                        <tr>
                            <th>Clases</th>
                            <th>Frecuencia (\(f\))</th>
                            <th>Frec. Relativa (\(Fr\))</th>
                            <th>Punto Medio (\(Pm\))</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>100 - 114</td><td>5</td><td>0.10</td><td>107</td></tr>
                        <tr><td>114 - 128</td><td>11</td><td>0.22</td><td>121</td></tr>
                        <tr><td>128 - 142</td><td>10</td><td>0.20</td><td>135</td></tr>
                        <tr><td>142 - 156</td><td>6</td><td>0.12</td><td>149</td></tr>
                        <tr><td>156 - 170</td><td>9</td><td>0.18</td><td>163</td></tr>
                        <tr><td>170 - 184</td><td>5</td><td>0.10</td><td>177</td></tr>
                        <tr><td>184 - 198</td><td>4</td><td>0.08</td><td>191</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="formula-box">
            <h4>Ejercicio 2: Peso de 50 estudiantes en libras</h4>
            <p>
                Con \(N = 50\) datos donde \(D_{\text{menor}} = 100\) y \(D_{\text{mayor}} = 162\):
                \(R = 162 - 100 = 62\); \(\;Nc = 1 + 3.33 \log(50) \approx \mathbf{7}\);
                \(\;Ic = \frac{62}{7} \approx \mathbf{9}\) (Comprobación: \(7 \times 9 = 63 \geq 62\)).
            </p>
            <div style="overflow-x: auto;">
                <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: center; margin-top: 0.5rem;">
                    <thead>
                        <tr>
                            <th>Clases</th>
                            <th>Frecuencia (\(f\))</th>
                            <th>Frec. Relativa (\(Fr\))</th>
                            <th>Punto Medio (\(Pm\))</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>100 - 109</td><td>4</td><td>0.08</td><td>104.5</td></tr>
                        <tr><td>109 - 118</td><td>11</td><td>0.22</td><td>113.5</td></tr>
                        <tr><td>118 - 127</td><td>11</td><td>0.22</td><td>122.5</td></tr>
                        <tr><td>127 - 136</td><td>11</td><td>0.22</td><td>131.5</td></tr>
                        <tr><td>136 - 145</td><td>6</td><td>0.12</td><td>140.5</td></tr>
                        <tr><td>145 - 154</td><td>6</td><td>0.12</td><td>149.5</td></tr>
                        <tr><td>154 - 163</td><td>1</td><td>0.02</td><td>158.5</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Construir Tabla de Distribución de Frecuencia</h3>
        <p class="section-description">
            Ingresa los datos brutos separados por comas o espacios. El sistema calculará el arreglo ordenado,
            el rango (R), el número de clases (Sturges) y el intervalo (Ic).
        </p>

        <form id="form-tabla-frecuencia" data-action="u1_tabla_frecuencia" data-endpoint="../../Controllers/controlador_u1.php">
            <div class="form-grid">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="datos">Datos brutos (separados por comas)</label>
                    <textarea id="datos" name="datos" rows="3" required placeholder="Ej: 100, 103, 107, 108, 110..."></textarea>
                </div>
                <div class="form-group">
                    <label for="modo_clases">Cálculo de número de clases (Nc)</label>
                    <select id="modo_clases" name="modo">
                        <option value="auto" selected>Automático (Sturges: 1 + 3.33 log N)</option>
                        <option value="manual">Manual (definir Nc)</option>
                    </select>
                </div>
                <div class="form-group" id="grupo-clases-manual" hidden>
                    <label for="clases">Número de clases (Nc)</label>
                    <input type="number" id="clases" name="clases" value="7" min="2" max="30" step="1">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Construir tabla</button>
                <button type="button" class="btn-secondary" id="btn-tabla-completa">📋 Ver Tabla Completa</button>
                <button type="button" class="btn-secondary" data-ejemplo="ej1_cuaderno">Ejemplo 1 (50 datos)</button>
                <button type="button" class="btn-secondary" data-ejemplo="ej2_pesos">Ejercicio 2 (Pesos 50 est.)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-tabla-frecuencia" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    (function () {
        var modo = document.getElementById('modo_clases');
        var grupoManual = document.getElementById('grupo-clases-manual');

        function actualizarModo() {
            grupoManual.hidden = modo.value !== 'manual';
        }

        modo.addEventListener('change', actualizarModo);
        actualizarModo();

        // Datos exactos del Ejemplo 1 de tu cuaderno (50 observaciones)
        Practica.ejemplos.ej1_cuaderno = {
            modo: 'auto',
            datos: '123, 116, 167, 198, 165, 148, 169, 110, 121, 100, 145, 132, 145, 126, 176, 189, 163, 101, 120, 109, 135, 127, 178, 187, 180, 166, 134, 129, 118, 102, 167, 185, 183, 177, 156, 145, 167, 143, 132, 121, 145, 128, 119, 117, 140, 121, 164, 129, 132, 140'
        };

        // Datos exactos del Ejercicio 2 de tu cuaderno (Pesos de 50 estudiantes)
        Practica.ejemplos.ej2_pesos = {
            modo: 'auto',
            datos: '100, 103, 107, 108, 110, 110, 110, 113, 114, 115, 116, 117, 118, 119, 117, 120, 120, 121, 120, 120, 124, 124, 124, 124, 127, 125, 125, 128, 128, 130, 131, 131, 131, 132, 133, 134, 135, 136, 138, 138, 140, 141, 142, 142, 145, 146, 145, 162, 152, 150'
        };

        document.querySelectorAll('[data-ejemplo]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setTimeout(actualizarModo, 0);
            });
        });

        Practica.conectar('form-tabla-frecuencia', 'resultado-tabla-frecuencia');

        // Botón Tabla Completa (lee la tabla renderizada y alterna entre 6 y 11 columnas)
        var btnCompleta = document.getElementById('btn-tabla-completa');
        var htmlTablaOriginal = '';
        var htmlTablaExtendida = '';
        var mostrandoCompleta = false;

        function construirTablaExtendidaDesdeDom(tablaEl) {
            var filasTr = Array.from(tablaEl.querySelectorAll('tbody tr'));
            if (filasTr.length < 2) return null;

            var filasDatos = filasTr.slice(0, -1);
            var filaTotalCeldas = Array.from(filasTr.at(-1).querySelectorAll('td')).map(function (td) {
                return td.textContent.trim();
            });
            var nTotal = parseFloat(filaTotalCeldas.at(2)) || 0;

            var faMenos = 0;
            var faMas = nTotal;
            var sumaPm = 0;
            var sumaPmF = 0;
            var primerLi = '';
            var ultimoLs = '';

            var encabezados = [
                '#',
                'Intervalos',
                'f (fi)',
                'Pm (Xi)',
                'fr (hi)',
                '%',
                'Fa < (↑)',
                'Fra (%)',
                'Fa > (↓)',
                '(x, y) <',
                '(x, y) >',
                'Pm · f',
                'Grados (°)'
            ];

            var html = '<table class="data-table"><thead><tr>';
            encabezados.forEach(function (col) {
                html += '<th>' + col + '</th>';
            });
            html += '</tr></thead><tbody>';

            filasDatos.forEach(function (tr, idx) {
                var c = Array.from(tr.querySelectorAll('td')).map(function (td) {
                    return td.textContent.trim();
                });

                var intervalo = c.at(0) || '';
                var partes = intervalo.split('-').map(function (s) { return s.trim(); });
                var li = partes.at(0) || '';
                var ls = partes.at(1) || '';
                if (idx === 0) primerLi = li;
                ultimoLs = ls;

                var pmTxt = c.at(1) || '0';
                var freqTxt = c.at(2) || '0';
                var fr = c.at(4) || '';
                var porc = c.at(5) || '';

                var pm = parseFloat(pmTxt) || 0;
                var freq = parseFloat(freqTxt) || 0;

                faMenos += freq;
                var fraPct = nTotal > 0 ? Number(((faMenos / nTotal) * 100).toFixed(1)) + '%' : '0%';
                var pmPorF = pm * freq;
                var grados = nTotal > 0 ? Number(((freq * 360) / nTotal).toFixed(1)) + '°' : '0°';
                sumaPmF += pmPorF;
                sumaPm += pm;


                var filaNueva = [
                    'C' + (idx + 1),
                    intervalo,
                    freqTxt,
                    pmTxt,
                    fr,
                    porc,
                    String(faMenos),
                    fraPct,
                    String(faMas),
                    '(' + ls + ', ' + faMenos + ')',
                    '(' + li + ', ' + faMas + ')',
                    Number(pmPorF.toFixed(2)).toString(),
                    grados
                ];

                html += '<tr>';
                filaNueva.forEach(function (val) {
                    html += '<td>' + val + '</td>';
                });
                html += '</tr>';

                faMas -= freq;
            });

            var filaTotalNueva = [
                'Total',
                filaTotalCeldas.at(0) || '',
                String(nTotal),
                Number(sumaPm.toFixed(2)).toString(),
                '1.0000',
                '100%',
                '—',
                '100%',
                '—',
                '(' + primerLi + ', 0)',
                '(' + ultimoLs + ', 0)',
                Number(sumaPmF.toFixed(2)).toString(),
                '360°'
            ];


            html += '<tr>';
            filaTotalNueva.forEach(function (val) {
                html += '<td><strong>' + val + '</strong></td>';
            });
            html += '</tr></tbody></table>';

            return html;
        }


        // Reiniciar estado cada vez que se envía el formulario
        document.getElementById('form-tabla-frecuencia').addEventListener('submit', function () {
            htmlTablaOriginal = '';
            htmlTablaExtendida = '';
            mostrandoCompleta = false;
            if (btnCompleta) {
                btnCompleta.textContent = '📋 Ver Tabla Completa';
            }
        });

        if (btnCompleta) {
            btnCompleta.addEventListener('click', function () {
                var contenedor = document.getElementById('resultado-tabla-frecuencia');
                if (!contenedor) return;

                var tablaEl = contenedor.querySelector('table');
                if (!tablaEl) {
                    alert('Primero presiona "Construir tabla" para generar los resultados.');
                    return;
                }

                var cajaTabla = tablaEl.parentElement;

                if (!htmlTablaOriginal) {
                    htmlTablaOriginal = cajaTabla.innerHTML;
                    htmlTablaExtendida = construirTablaExtendidaDesdeDom(tablaEl);
                }

                if (!htmlTablaExtendida) return;

                mostrandoCompleta = !mostrandoCompleta;
                if (mostrandoCompleta) {
                    cajaTabla.innerHTML = htmlTablaExtendida;
                    btnCompleta.textContent = '📄 Volver a Tabla Estándar';
                } else {
                    cajaTabla.innerHTML = htmlTablaOriginal;
                    btnCompleta.textContent = '📋 Ver Tabla Completa';
                }
            });
        }
    })();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>

