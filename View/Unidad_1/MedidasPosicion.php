<?php
$titulo_pagina = 'Medidas de Posición (Cuartiles y Deciles)';
$descripcion_pagina = 'Cálculo de cuartiles (Q1, Q2, Q3) y deciles (D1 a D9) para series simples y series agrupadas.';
include __DIR__ . '/../partials/head.php';
?>

<h1>🎯 Medidas de Posición</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Los Cuartiles -->
        <div class="card">
            <h3>1. Los Cuartiles (\(Q_1, Q_2, Q_3\))</h3>
            <p>
                Son los valores que dividen a la masa de datos observados en <strong>cuatro partes iguales</strong>.
                Si una serie de datos la dividimos en cuatro partes iguales, cada una contendrá el
                <strong>25%</strong> de los datos observados. Nótese que \(Q_2\) divide los datos en dos áreas
                iguales, por lo que su valor es exactamente igual a la <strong>mediana</strong> (\(Q_2 = Md\)).
            </p>
            <div class="formula-box">
                <h4>Posiciones en Serie Simple vs. Serie Agrupada</h4>
                <ul>
                    <li><strong>Serie Simple:</strong> \(N_1 = \frac{n + 1}{4}\), \(\quad N_2 = \frac{n + 1}{2}\), \(\quad N_3 = \frac{3(n + 1)}{4}\) (si hay fracción, se interpola).</li>
                    <li><strong>Serie Agrupada:</strong> \(N_1 = \frac{n}{4}\), \(\quad N_2 = \frac{2n}{4} = \frac{n}{2}\), \(\quad N_3 = \frac{3n}{4}\).</li>
                </ul>
                <div class="math-expression">\[Q_k = L_i + i \left[ \frac{\frac{k \cdot n}{4} - Faa}{f} \right] \quad (k = 1, 2, 3)\]</div>
            </div>
        </div>

        <!-- Tarjeta 2: Los Deciles -->
        <div class="card">
            <h3>2. Los Deciles (\(D_1, D_2, \dots, D_9\))</h3>
            <p>
                Son aquellos puntos los cuales dividen en <strong>diez partes equivalentes</strong> los datos
                observados y cada parte o área está separada entre sí por un punto o valor llamado <strong>DECIL</strong>.
                Esto significa que el conjunto de datos se ordena de menor a mayor y se divide en 10 grupos con
                el mismo número de observaciones. Habrá <strong>9 deciles</strong> (el \(D_5\) coincide con la mediana).
            </p>
            <div class="formula-box">
                <h4>Fórmula General para Series Agrupadas</h4>
                <div class="math-expression">\[D_k = L_i + i \left[ \frac{No - Faa}{f} \right] \quad (k = 1, 2, \dots, 9)\]</div>
                <p class="formula-caption">
                    Donde el número de orden es \(No = \frac{k \cdot n}{10}\) (por ejemplo: \(D_1 \Rightarrow \frac{n}{10}\),
                    \(D_2 \Rightarrow \frac{2n}{10} = \frac{n}{5}\), \(D_5 \Rightarrow \frac{5n}{10} = \frac{n}{2}\), \(D_7 \Rightarrow \frac{7n}{10}\)).
                </p>
            </div>
        </div>

        <!-- Tarjeta 3: Ejemplos Resueltos de Cuartiles -->
        <div class="card">
            <h3>3. Ejemplos Resueltos: Cuartiles</h3>
            <div class="formula-box">
                <h4>Ejemplo A: Serie Simple (\(n = 8\))</h4>
                <p>Serie ordenada: `2, 3, 5, 7, 10, 13, 18, 20`</p>
                <ul>
                    <li><strong>\(Q_1\):</strong> \(N_1 = \frac{8+1}{4} = 2.25 \implies Q_1 = 3 + 0.25(5 - 3) = \mathbf{3.5}\)</li>
                    <li><strong>\(Q_2\):</strong> \(N_2 = \frac{8+1}{2} = 4.5 \implies Q_2 = 7 + 0.5(10 - 7) = \mathbf{8.5}\)</li>
                    <li><strong>\(Q_3\):</strong> \(N_3 = \frac{3(8+1)}{4} = 6.75 \implies Q_3 = 13 + 0.75(18 - 13) = \mathbf{16.75}\)</li>
                </ul>
            </div>
            <div class="formula-box">
                <h4>Ejemplo B: Serie Agrupada (\(n = 39\), clases `2-4` a `12-14`)</h4>
                <ul>
                    <li><strong>\(Q_1\) (\(\frac{n}{4} = 9.75\), clase `4-6`):</strong> \(Q_1 = 4 + 2\left[\frac{9.75 - 5}{8}\right] = \mathbf{5.18}\)</li>
                    <li><strong>\(Q_2\) (\(\frac{n}{2} = 19.5\), clase `6-8`):</strong> \(Q_2 = 6 + 2\left[\frac{19.5 - 13}{12}\right] = \mathbf{7.08}\)</li>
                    <li><strong>\(Q_3\) (\(\frac{3n}{4} = 29.25\), clase `8-10`):</strong> \(Q_3 = 8 + 2\left[\frac{29.25 - 25}{7}\right] = \mathbf{9.21}\)</li>
                </ul>
            </div>
        </div>

        <!-- Tarjeta 4: Ejemplo Resuelto de Deciles -->
        <div class="card">
            <h3>4. Ejemplo Resuelto: Deciles (\(n = 60\))</h3>
            <p>
                Con la distribución de clases `5-10` hasta `50-55` (amplitud \(i = 5\), \(n = 60\)):
            </p>
            <ul>
                <li><strong>Decil 1 (\(D_1\)):</strong> \(No = \frac{60}{10} = 6\) (clase `10-15`, \(L_i = 10, Faa = 2, f = 4\)) \(\implies D_1 = 10 + 5\left[\frac{6 - 2}{4}\right] = \mathbf{15}\) (debajo del \(D_1\) se tiene el 10% de los datos).</li>
                <li><strong>Decil 2 (\(D_2\)):</strong> \(No = \frac{2(60)}{10} = 12\) (clase `15-20`, \(L_i = 15, Faa = 6, f = 6\)) \(\implies D_2 = 15 + 5\left[\frac{12 - 6}{6}\right] = \mathbf{20}\).</li>
                <li><strong>Decil 7 (\(D_7\)):</strong> \(No = \frac{7(60)}{10} = 42\) (clase `30-35`, \(L_i = 30, Faa = 34, f = 11\)) \(\implies D_7 = 30 + 5\left[\frac{42 - 34}{11}\right] = \mathbf{33.63}\).</li>
            </ul>
        </div>
    </div>
</div>

<!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular Cuartiles o Deciles</h3>
        <p class="section-description">
            Elige el tipo de serie (simple o agrupada), selecciona si deseas calcular Cuartiles (Q) o Deciles (D)
            e indica el número \(k\) (1 a 3 para cuartiles; 1 a 9 para deciles).
        </p>

        <form id="form-posicion" data-action="u1_posicion" data-endpoint="../../Controllers/controlador_u1.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="tipo_datos_pos">Tipo de serie</label>
                    <select id="tipo_datos_pos" name="tipo_datos">
                        <option value="no_agrupados" selected>Serie Simple (datos individuales)</option>
                        <option value="agrupados">Serie Agrupada (clases y frecuencias)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="medida_pos">Medida de posición</label>
                    <select id="medida_pos" name="medida">
                        <option value="Q" selected>Cuartil (Q1, Q2, Q3)</option>
                        <option value="D">Decil (D1 a D9)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="k_pos" id="label-k-pos">Número de Cuartil (1 a 3)</label>
                    <input type="number" id="k_pos" name="k" value="1" min="1" max="3" step="1" required>
                </div>

                <div class="form-group" id="grupo-simple-pos" style="grid-column: 1 / -1;">
                    <label for="datos_pos">Datos de la serie simple (separados por comas)</label>
                    <input type="text" id="datos_pos" name="datos" value="2, 3, 20, 13, 18, 5, 7, 10">
                </div>

                <div class="form-group" id="grupo-int-pos" hidden>
                    <label for="intervalos_pos">Intervalos de clase (separados por comas)</label>
                    <input type="text" id="intervalos_pos" name="intervalos" value="2-4, 4-6, 6-8, 8-10, 10-12, 12-14">
                </div>

                <div class="form-group" id="grupo-freq-pos" hidden>
                    <label for="frecuencias_pos">Frecuencias absolutas f (separadas por comas)</label>
                    <input type="text" id="frecuencias_pos" name="frecuencias" value="5, 8, 12, 7, 5, 2">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular posición</button>
                <button type="button" class="btn-secondary" data-ejemplo="pos_q_simple">Ej. Cuartiles Simples</button>
                <button type="button" class="btn-secondary" data-ejemplo="pos_q_agrup">Ej. Cuartiles Agrupados (n=39)</button>
                <button type="button" class="btn-secondary" data-ejemplo="pos_d_agrup">Ej. Deciles Agrupados (n=60)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-posicion" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    (function () {
        var tipo = document.getElementById('tipo_datos_pos');
        var medida = document.getElementById('medida_pos');
        var kInput = document.getElementById('k_pos');
        var labelK = document.getElementById('label-k-pos');
        var grupoSimple = document.getElementById('grupo-simple-pos');
        var gruposAgrupados = [
            document.getElementById('grupo-int-pos'),
            document.getElementById('grupo-freq-pos')
        ];

        function actualizarCampos() {
            var esAgrupado = tipo.value === 'agrupados';
            grupoSimple.hidden = esAgrupado;
            gruposAgrupados.forEach(function (el) { el.hidden = !esAgrupado; });
        }

        function actualizarLimiteK() {
            if (medida.value === 'Q') {
                kInput.max = '3';
                if (parseInt(kInput.value, 10) > 3) kInput.value = '3';
                labelK.textContent = 'Número de Cuartil (1 a 3)';
            } else {
                kInput.max = '9';
                labelK.textContent = 'Número de Decil (1 a 9)';
            }
        }

        tipo.addEventListener('change', actualizarCampos);
        medida.addEventListener('change', actualizarLimiteK);
        actualizarCampos();
        actualizarLimiteK();

        Practica.ejemplos.pos_q_simple = {
            tipo_datos: 'no_agrupados',
            medida: 'Q',
            k: '1',
            datos: '2, 3, 20, 13, 18, 5, 7, 10'
        };

        Practica.ejemplos.pos_q_agrup = {
            tipo_datos: 'agrupados',
            medida: 'Q',
            k: '1',
            intervalos: '2-4, 4-6, 6-8, 8-10, 10-12, 12-14',
            frecuencias: '5, 8, 12, 7, 5, 2'
        };

        Practica.ejemplos.pos_d_agrup = {
            tipo_datos: 'agrupados',
            medida: 'D',
            k: '7',
            intervalos: '5-10, 10-15, 15-20, 20-25, 25-30, 30-35, 35-40, 40-45, 45-50, 50-55',
            frecuencias: '2, 4, 6, 9, 13, 11, 7, 4, 3, 1'
        };

        document.querySelectorAll('[data-ejemplo]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setTimeout(function () {
                    actualizarCampos();
                    actualizarLimiteK();
                }, 0);
            });
        });

        Practica.conectar('form-posicion', 'resultado-posicion');
    })();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
