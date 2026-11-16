<?php
$titulo_pagina = 'Medidas de Tendencia Central';
$descripcion_pagina = 'Media aritmética, mediana y moda (punto medio, interpolación y empírica) para series simples y agrupadas.';
include __DIR__ . '/../partials/head.php';
?>

<h1>📈 Medidas de Tendencia Central</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Definición y Media Aritmética -->
        <div class="card">
            <h3>1. Medida de Tendencia Central y Media Aritmética</h3>
            <p>
                <strong>Medida de Tendencia Central:</strong> Es una medida de posición; es un valor de la
                escala de medidas perfectamente definido, puede ser un valor que corresponda al medio o a la
                medida que sobrepase a la mitad de observaciones, las cuales denominan promedio.
            </p>
            <p>
                <strong>Media Aritmética (\(\bar{x}\)):</strong> Se simboliza \(\bar{x}\) que se lee «equis barra».
                Es el valor que se obtiene sumando los valores de las cantidades y dividiendo el resultado
                entre el número de ellas.
            </p>
            <div class="formula-box">
                <h4>Media Aritmética Simple (Serie Simple)</h4>
                <div class="math-expression">\[\bar{x} = \frac{\sum X}{n}\]</div>
                <p class="formula-caption">
                    <strong>Ejemplo (Unidades producidas en una semana):</strong> Lunes (350), Martes (400),
                    Miércoles (370), Jueves (450), Viernes (430), Sábado (200) \(\rightarrow \sum X = 2,200,\; n = 6 \implies \bar{x} = \frac{2,200}{6} = \mathbf{366.66\text{ productos}}\).
                </p>
            </div>
            <div class="formula-box">
                <h4>Media Aritmética para Series Agrupadas</h4>
                <div class="math-expression">\[\bar{x} = \frac{\sum Pm \cdot f}{n}\]</div>
                <p class="formula-caption">
                    Se multiplica el Punto Medio (\(Pm = \frac{L_s + L_i}{2}\)) de cada clase por su frecuencia \(f\)
                    y la sumatoria se divide entre el número de datos \(n\).
                </p>
            </div>
        </div>

        <!-- Tarjeta 2: La Mediana -->
        <div class="card">
            <h3>2. La Mediana (\(Md\))</h3>
            <p>
                Es un valor de la variable que separa el total de las frecuencias en dos partes iguales; es
                decir, que por debajo y por encima de él está el <strong>50%</strong> de las observaciones.
            </p>
            <ul>
                <li><strong>Mediana para Series Simples:</strong>
                    <ul>
                        <li><em>Datos impares:</em> Se toma el número del medio (ej. \(3, 5, \mathbf{6}, 10, 12 \rightarrow Md = 6\)).</li>
                        <li><em>Datos pares:</em> Se toman los 2 datos del medio y se hace la semisuma (ej. \(3, 5, \mathbf{7, 9}, 10, 12 \rightarrow Md = \frac{7+9}{2} = \mathbf{8}\)).</li>
                    </ul>
                </li>
            </ul>
            <div class="formula-box">
                <h4>Mediana para Series Agrupadas</h4>
                <div class="math-expression">\[Md = L_i + i \left[ \frac{\frac{n}{2} - Faa}{f} \right]\]</div>
                <p class="formula-caption">
                    Donde \(L_i\) es el límite inferior de la clase mediana (primera \(Fa \geq \frac{n}{2}\)),
                    \(i\) el intervalo, \(Faa\) la frecuencia acumulada anterior y \(f\) la frecuencia de esa clase.
                </p>
            </div>
        </div>

        <!-- Tarjeta 3: La Moda (3 Métodos) -->
        <div class="card">
            <h3>3. La Moda (\(Mo\))</h3>
            <p>
                <strong>Definición:</strong> Es la cantidad que se repite con más frecuencia (ej. en el concurso
                de belleza, la medida de cintura de <strong>24 pulgadas</strong> tuvo 933 candidatas). En series
                agrupadas se calcula por tres métodos:
            </p>
            <div class="formula-box">
                <h4>a) Método del Punto Medio</h4>
                <p class="formula-caption">
                    La moda de una distribución de frecuencias es el valor del punto medio (\(Pm\)) de la clase
                    modal (la de mayor frecuencia).
                </p>
            </div>
            <div class="formula-box">
                <h4>b) Método de Interpolación</h4>
                <div class="math-expression">\[Mo = L_i + i \left[ \frac{\Delta_1}{\Delta_1 + \Delta_2} \right]\]</div>
                <p class="formula-caption">
                    Donde \(\Delta_1 = f_{\text{modal}} - f_{\text{anterior}}\) y \(\Delta_2 = f_{\text{modal}} - f_{\text{posterior}}\).
                </p>
            </div>
            <div class="formula-box">
                <h4>c) Método Empírico</h4>
                <div class="math-expression">\[Mo = 3Md - 2\bar{x}\]</div>
                <p class="formula-caption">
                    Se utiliza de forma aproximada para distribuciones unimodales y moderadamente asimétricas.
                </p>
            </div>
        </div>

        <!-- Tarjeta 4: Resumen de Ejemplos Resueltos -->
        <div class="card">
            <h3>4. Ejemplos Resueltos del Cuaderno</h3>
            <ul>
                <li><strong>Media Agrupada (Millas al ITCA, \(n = 20\)):</strong> Intervalos de `0-2` a `8-10` con frecuencias `2, 5, 4, 8, 1` \(\rightarrow \sum Pm \cdot f = 102 \implies \bar{x} = \frac{102}{20} = \mathbf{5.1\text{ millas}}\).</li>
                <li><strong>Mediana Agrupada (35 alumnos):</strong> Clase mediana `4 - 6` (\(\frac{35}{2} = 17.5\), \(L_i = 4, i = 2, Faa = 7, f = 14\)) \(\implies Md = 4 + 2\left[\frac{17.5 - 7}{14}\right] = \mathbf{5.5}\).</li>
                <li><strong>Moda Agrupada (\(n = 60\), clases `20-34` a `118-132`):</strong>
                    <ul>
                        <li><em>Punto Medio (clase `48-62`):</em> \(Mo = \mathbf{55}\).</li>
                        <li><em>Interpolación (\(\Delta_1 = 2, \Delta_2 = 2\)):</em> \(Mo = 48 + 14\left[\frac{2}{2+2}\right] = \mathbf{55}\).</li>
                        <li><em>Empírica (\(\bar{x} = 68.53, Md = 65.78\)):</em> \(Mo = 3(65.78) - 2(68.53) = \mathbf{60.28}\).</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular Medidas de Tendencia Central</h3>
        <p class="section-description">
            Elige si trabajarás con una serie simple (datos individuales) o una serie agrupada (intervalos y frecuencias).
        </p>

        <form id="form-tendencia" data-action="u1_tendencia_central" data-endpoint="../../Controllers/controlador_u1.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="tipo_datos">Tipo de serie</label>
                    <select id="tipo_datos" name="tipo_datos">
                        <option value="no_agrupados" selected>Serie Simple (datos individuales)</option>
                        <option value="agrupados">Serie Agrupada (clases y frecuencias)</option>
                    </select>
                </div>

                <div class="form-group" id="grupo-simple" style="grid-column: 1 / -1;">
                    <label for="datos">Datos de la serie simple (separados por comas)</label>
                    <input type="text" id="datos" name="datos" value="350, 400, 370, 450, 430, 200" placeholder="Ej: 350, 400, 370, 450, 430, 200">
                </div>

                <div class="form-group" id="grupo-intervalos" hidden>
                    <label for="intervalos">Intervalos de clase (separados por comas)</label>
                    <input type="text" id="intervalos" name="intervalos" value="20-34, 34-48, 48-62, 62-76, 76-90, 90-104, 104-118, 118-132" placeholder="Ej: 0-2, 2-4, 4-6">
                </div>

                <div class="form-group" id="grupo-frecuencias" hidden>
                    <label for="frecuencias">Frecuencias absolutas f (separadas por comas)</label>
                    <input type="text" id="frecuencias" name="frecuencias" value="7, 9, 11, 9, 8, 10, 4, 2" placeholder="Ej: 2, 5, 14, 8, 6">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular medidas</button>
                <button type="button" class="btn-secondary" data-ejemplo="tc_fabrica">Ej. Simple (Fábrica)</button>
                <button type="button" class="btn-secondary" data-ejemplo="tc_itca">Ej. Agrupado (Millas ITCA)</button>
                <button type="button" class="btn-secondary" data-ejemplo="tc_mediana35">Ej. Mediana (35 alum.)</button>
                <button type="button" class="btn-secondary" data-ejemplo="tc_moda60">Ej. 3 Modas (60 datos)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-tendencia" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    (function () {
        var tipo = document.getElementById('tipo_datos');
        var grupoSimple = document.getElementById('grupo-simple');
        var gruposAgrupados = [
            document.getElementById('grupo-intervalos'),
            document.getElementById('grupo-frecuencias')
        ];

        function actualizarCampos() {
            var esAgrupado = tipo.value === 'agrupados';
            grupoSimple.hidden = esAgrupado;
            gruposAgrupados.forEach(function (el) { el.hidden = !esAgrupado; });
        }

        tipo.addEventListener('change', actualizarCampos);
        actualizarCampos();

        Practica.ejemplos.tc_fabrica = {
            tipo_datos: 'no_agrupados',
            datos: '350, 400, 370, 450, 430, 200'
        };

        Practica.ejemplos.tc_itca = {
            tipo_datos: 'agrupados',
            intervalos: '0-2, 2-4, 4-6, 6-8, 8-10',
            frecuencias: '2, 5, 4, 8, 1'
        };

        Practica.ejemplos.tc_mediana35 = {
            tipo_datos: 'agrupados',
            intervalos: '0-2, 2-4, 4-6, 6-8, 8-10',
            frecuencias: '2, 5, 14, 8, 6'
        };

        Practica.ejemplos.tc_moda60 = {
            tipo_datos: 'agrupados',
            intervalos: '20-34, 34-48, 48-62, 62-76, 76-90, 90-104, 104-118, 118-132',
            frecuencias: '7, 9, 11, 9, 8, 10, 4, 2'
        };

        document.querySelectorAll('[data-ejemplo]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setTimeout(actualizarCampos, 0);
            });
        });

        Practica.conectar('form-tendencia', 'resultado-tendencia');
    })();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
