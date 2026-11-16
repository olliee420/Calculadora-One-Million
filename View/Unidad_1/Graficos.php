<?php
$titulo_pagina = 'Representaciones Gráficas';
$descripcion_pagina = 'Gráficos de línea, histogramas, polígonos de frecuencia, ojivas, barras y diagramas circulares.';
include __DIR__ . '/../partials/head.php';
?>

<h1>📈 Representaciones Gráficas</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Definición y Gráfico de Línea -->
        <div class="card">
            <h3>1. Los Gráficos y Gráfico de Línea</h3>
            <p>
                <strong>Los Gráficos:</strong> Tienen por objetivo ilustrar de forma clara y estética,
                mediante el uso de figuras, el comportamiento de un fenómeno del cual se desea tener conocimiento.
            </p>
            <p>
                <strong>Gráfico de Línea:</strong> Consiste en la representación gráfica de los datos a través
                de la unión de segmentos de recta, considerando las columnas de las clases en el eje \(X\) y
                las columnas de las frecuencias en el eje \(Y\).
            </p>
            <div class="formula-box">
                <h4>Ejemplo: Ventas anuales de un almacén (2006 - 2011)</h4>
                <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: center;">
                    <thead><tr><th>Año (\(X\))</th><th>Ventas (\(Y\))</th></tr></thead>
                    <tbody>
                        <tr><td>2006</td><td>600</td></tr>
                        <tr><td>2007</td><td>1,200</td></tr>
                        <tr><td>2008</td><td>4,000</td></tr>
                        <tr><td>2009</td><td>8,000</td></tr>
                        <tr><td>2010</td><td>10,000</td></tr>
                        <tr><td>2011</td><td>2,000</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tarjeta 2: Histograma y Polígono -->
        <div class="card">
            <h3>2. Histograma y Polígono de Frecuencias</h3>
            <p>
                <strong>Histograma (Gráfico de Pearson):</strong> Está formado por una serie de rectángulos
                cuya base es igual al intervalo de cada clase y cuya altura es igual al número de frecuencias
                correspondientes a cada uno de los intervalos.
            </p>
            <p>
                <strong>Polígono de frecuencias:</strong> Resulta de unir por segmentos de recta los puntos
                medios superiores de los rectángulos de los histogramas.
            </p>
            <div class="formula-box">
                <h4>Ejemplo: Calificaciones de 60 alumnos</h4>
                <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: center;">
                    <thead><tr><th>Calificaciones</th><th>Alumnos (\(f\))</th></tr></thead>
                    <tbody>
                        <tr><td>0 - 2</td><td>5</td></tr>
                        <tr><td>2 - 4</td><td>10</td></tr>
                        <tr><td>4 - 6</td><td>12</td></tr>
                        <tr><td>6 - 8</td><td>3</td></tr>
                        <tr><td>8 - 10</td><td>25</td></tr>
                        <tr><td>10 - 12</td><td>5</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tarjeta 3: Ojivas -->
        <div class="card">
            <h3>3. Ojivas ("Menos que" y "Más que")</h3>
            <p>
                Una <strong>ojiva</strong> es una alternativa gráfica para representar una distribución de
                clases y frecuencias. Consiste en dibujar en el plano un gráfico de frecuencias acumuladas
                contra extremos de cada clase:
            </p>
            <ul>
                <li><strong>1. Ojiva «menos que»:</strong> Se hace utilizando las frecuencias acumuladas en el sentido de la clase menor hacia la clase mayor (\(Fa \uparrow\)).</li>
                <li><strong>2. Ojiva «más que»:</strong> Se hace utilizando las frecuencias acumuladas en el sentido de la clase mayor hacia la clase menor (\(Fa \downarrow\)).</li>
            </ul>
            <h4>Procedimiento de construcción</h4>
            <ol>
                <li>Calcule la frecuencia «más que» y «menos que».</li>
                <li>En el plano cartesiano ubique en el eje vertical las frecuencias acumuladas y en el eje horizontal los límites de las clases:
                    <ul>
                        <li><strong>a) Ojiva «menos que»:</strong> Coloque \(0\) al límite inferior de la primera clase y asigne a los límites superiores las frecuencias acumuladas «menos que».</li>
                        <li><strong>b) Ojiva «más que»:</strong> Asigne \(0\) al límite superior de la última clase y asigne a los límites inferiores las frecuencias acumuladas «más que».</li>
                    </ul>
                </li>
            </ol>
        </div>

        <!-- Tarjeta 4: Gráfico de Barras y Diagrama Circular -->
        <div class="card">
            <h3>4. Gráfico de Barras y Diagrama Circular</h3>
            <p>
                <strong>Gráfico de Barras:</strong> Es idéntico al histograma en su construcción, con la
                única diferencia de que sus rectángulos <strong>no se encuentran unidos</strong> y sus
                respectivas bases no son iguales a los intervalos de clase (también puede presentarse en forma horizontal).
            </p>
            <p>
                <strong>Diagrama Circular:</strong> Consiste en un círculo cuya superficie está dividida en
                sectores circulares. Por regla de tres se encuentra el valor en grados que corresponde a cada clase:
            </p>
            <div class="formula-box">
                <div class="math-expression">\[X = \frac{f \cdot 360^\circ}{n}\]</div>
            </div>
            <div class="formula-box">
                <h4>Ejemplo: Centros de Educación Técnica (2006 - 2008, \(n = 552\))</h4>
                <ul>
                    <li><strong>2006 (184):</strong> \(X_1 = \frac{184 \times 360^\circ}{552} = \mathbf{120^\circ}\)</li>
                    <li><strong>2007 (197):</strong> \(X_2 = \frac{197 \times 360^\circ}{552} = \mathbf{128.48^\circ}\)</li>
                    <li><strong>2008 (171):</strong> \(X_3 = \frac{171 \times 360^\circ}{552} = \mathbf{111.52^\circ}\)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Generar Representación Gráfica</h3>
        <p class="section-description">
            Selecciona el tipo de gráfico e ingresa las etiquetas (eje X) y sus frecuencias o valores (eje Y) separados por comas.
        </p>

        <form id="form-graficos" data-action="u1_graficos" data-endpoint="../../Controllers/controlador_u1.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="tipo_grafico">Tipo de gráfico</label>
                    <select id="tipo_grafico" name="tipo_grafico">
                        <option value="histograma" selected>Histograma y Polígono de frecuencias</option>
                        <option value="linea">Gráfico de Línea</option>
                        <option value="ojivas">Ojivas ("Menos que" y "Más que")</option>
                        <option value="barras">Gráfico de Barras separadas</option>
                        <option value="circular">Diagrama Circular (Grados y %)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="titulo_graf">Título del gráfico</label>
                    <input type="text" id="titulo_graf" name="titulo_graf" value="Calificaciones de 60 alumnos">
                </div>
                <div class="form-group">
                    <label for="etiquetas">Clases o Categorías (separadas por coma)</label>
                    <input type="text" id="etiquetas" name="etiquetas" value="0-2, 2-4, 4-6, 6-8, 8-10, 10-12" required>
                </div>
                <div class="form-group">
                    <label for="frecuencias">Frecuencias o Valores (separados por coma)</label>
                    <input type="text" id="frecuencias" name="frecuencias" value="5, 10, 12, 3, 25, 5" required>
                </div>
                <div class="form-group" id="grupo-limites-ojiva" hidden style="grid-column: 1 / -1;">
                    <label for="limites">Fronteras / Límites de clase para Ojivas (N+1 valores separados por coma)</label>
                    <input type="text" id="limites" name="limites" value="0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Generar gráfico</button>
                <button type="button" class="btn-secondary" data-ejemplo="graf_linea">Ej. Línea (Ventas)</button>
                <button type="button" class="btn-secondary" data-ejemplo="graf_hist">Ej. Histograma (60 alum.)</button>
                <button type="button" class="btn-secondary" data-ejemplo="graf_ojivas">Ej. Ojivas (60 alum.)</button>
                <button type="button" class="btn-secondary" data-ejemplo="graf_barras">Ej. Barras (Matrícula)</button>
                <button type="button" class="btn-secondary" data-ejemplo="graf_circular">Ej. Circular (Centros)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-graficos" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    (function () {
        var tipo = document.getElementById('tipo_grafico');
        var grupoLimites = document.getElementById('grupo-limites-ojiva');

        function actualizarCampos() {
            grupoLimites.hidden = tipo.value !== 'ojivas';
        }

        tipo.addEventListener('change', actualizarCampos);
        actualizarCampos();

        Practica.ejemplos.graf_linea = {
            tipo_grafico: 'linea',
            titulo_graf: 'Ventas anuales de un almacén (2006 - 2011)',
            etiquetas: '2006, 2007, 2008, 2009, 2010, 2011',
            frecuencias: '600, 1200, 4000, 8000, 10000, 2000'
        };

        Practica.ejemplos.graf_hist = {
            tipo_grafico: 'histograma',
            titulo_graf: 'Histograma y Polígono: Calificaciones de 60 alumnos',
            etiquetas: '0-2, 2-4, 4-6, 6-8, 8-10, 10-12',
            frecuencias: '5, 10, 12, 3, 25, 5'
        };

        Practica.ejemplos.graf_ojivas = {
            tipo_grafico: 'ojivas',
            titulo_graf: 'Ojivas "Menos que" y "Más que" (60 alumnos)',
            etiquetas: '0-1, 1-2, 2-3, 3-4, 4-5, 5-6, 6-7, 7-8, 8-9, 9-10',
            frecuencias: '2, 6, 4, 9, 12, 11, 7, 4, 3, 2',
            limites: '0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10'
        };

        Practica.ejemplos.graf_barras = {
            tipo_grafico: 'barras',
            titulo_graf: 'Matrícula inicial por especialidad técnica',
            etiquetas: 'Eléctrica, Mecánica, Civil, Computación',
            frecuencias: '5023, 3680, 732, 423'
        };

        Practica.ejemplos.graf_circular = {
            tipo_grafico: 'circular',
            titulo_graf: 'Centros de Educación Técnica (2006 - 2008)',
            etiquetas: '2006, 2007, 2008',
            frecuencias: '184, 197, 171'
        };

        document.querySelectorAll('[data-ejemplo]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setTimeout(actualizarCampos, 0);
            });
        });

        Practica.conectar('form-graficos', 'resultado-graficos');
    })();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
