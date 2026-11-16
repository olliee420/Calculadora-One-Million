<?php
$titulo_pagina = 'Probabilidad Clásica';
$descripcion_pagina = 'Calcula probabilidades con la regla de Laplace y visualiza la distribución de casos favorables.';
include __DIR__ . '/../partials/head.php';
?>

<h1>🎲 Probabilidad Clásica</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Tabla de Espacios muestrales y eventos -->
        <div class="card">
            <h3>Espacios muestrales y eventos</h3>
            <div style="overflow-x: auto;">
                <table class="data-table" style="width: 100%; border-collapse: collapse; margin-top: 0.5rem;">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Ideas</th>
                            <th style="text-align: left;">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Experimento</strong></td>
                            <td>Proceso que da lugar a una medición o a una observación.</td>
                        </tr>
                        <tr>
                            <td><strong>Experimento Aleatorio</strong></td>
                            <td>Aquel cuyo resultado es producto de la suerte o el azar. Por ejemplo: arrojar un dado.</td>
                        </tr>
                        <tr>
                            <td><strong>Evento</strong></td>
                            <td>El resultado de un experimento.</td>
                        </tr>
                        <tr>
                            <td><strong>Evento Aleatorio</strong></td>
                            <td>El resultado de un experimento aleatorio. Por ejemplo, el evento de que al arrojar un dado salga número impar.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tarjeta 2: Eventos simples y Puntos muestrales -->
        <div class="card">
            <h3>Eventos simples y puntos muestrales</h3>
            <p>Al arrojar un dado, podemos definir eventos individuales como:</p>
            <ul>
                <li><strong>\(E_1\):</strong> Evento de que al arrojar un dado salga uno.</li>
                <li><strong>\(E_2\):</strong> Evento de que al arrojar un dado salga tres.</li>
                <li><strong>\(E_3\):</strong> Evento de que al arrojar un dado salga cinco.</li>
            </ul>
            <p>
                Los eventos que no pueden descomponerse en otros más sencillos se conocen como
                <strong>eventos simples</strong> (se denotan añadiendo un subíndice después de la letra
                mayúscula del evento). Otra manera de denominar a los eventos simples es la de
                <strong>«puntos muestrales»</strong>, denominación muy útil cuando se representan
                gráficamente los problemas de probabilidad, pues cada evento simple se representa como un punto.
            </p>
        </div>

        <!-- Tarjeta 3: Definición formal y Regla de Laplace -->
        <div class="card">
            <h3>Definición formal de Probabilidad</h3>
            <p>
                Sea \(A\) un evento cualquiera; \(N\) el número de veces que repetimos un experimento en el
                que se puede presentar el evento \(A\); \(n_A\) el número de veces que efectivamente se
                presenta el evento \(A\); y \(P(A)\) la probabilidad de que se presente el evento \(A\):
            </p>
            <div class="formula-box">
                <h4>Definición frecuentista (límite)</h4>
                <div class="math-expression">\[P(A) = \lim_{N \to \infty} \frac{n_A}{N}\]</div>
                <p class="formula-caption">
                    Es la división entre el número de veces que \(A\) apareció y el número de veces que se
                    intentó el experimento (\(N \to \infty\) indica que se intentó muchas veces). El menor
                    valor posible de \(P(A)\) es \(0\) (si nunca aparece) y su límite superior es \(1\).
                </p>
            </div>
            <div class="formula-box">
                <h4>Probabilidad Clásica (Regla de Laplace)</h4>
                <div class="math-expression">\[P(A) = \frac{\text{casos favorables}}{\text{casos posibles}}\]</div>
            </div>
        </div>
    </div>

    <!-- Tarjeta 4: Ejemplos resueltos de tus apuntes -->
    <div class="card">
        <h3>Ejemplos Resueltos (Espacio Muestral)</h3>

        <div class="formula-box">
            <h4>Ejemplo 1: Comité directivo de padres de familia</h4>
            <p>
                El comité directivo de la sociedad de padres de familia de una escuela primaria está compuesto
                por 5 personas: tres mujeres (\(M_1, M_2, M_3\)) y dos hombres (\(H_1, H_2\)). Se van a elegir
                al azar dos miembros del comité para solicitar al delegado que ponga una patrulla a vigilar la
                salida de los niños. <strong>¿Cuál es la probabilidad de que el comité esté compuesto por un
                hombre y una mujer?</strong>
            </p>
            <p><strong>Espacio muestral (10 combinaciones posibles):</strong></p>
            <div class="math-expression">
                \[S = \{M_1M_2,\; M_1M_3,\; M_1H_1,\; M_1H_2,\; M_2M_3,\; M_2H_1,\; M_2H_2,\; M_3H_1,\; M_3H_2,\; H_1H_2\}\]
            </div>
            <p class="formula-caption">
                Existen <strong>10 combinaciones posibles</strong> y <strong>6 cumplen la condición</strong>
                del enunciado (\(M_1H_1, M_1H_2, M_2H_1, M_2H_2, M_3H_1, M_3H_2\)).
                La probabilidad es \(P(A) = \frac{6}{10} = 0.60 = \mathbf{60\%}\).
            </p>
        </div>

        <div class="formula-box">
            <h4>Ejemplo 2: Embarque de refrigeradores</h4>
            <p>
                Una tienda de electrodomésticos va a recibir un embarque de 6 refrigeradores, de los cuales dos
                están descompuestos (\(M_1, M_2\)) y cuatro están buenos (\(B_1, B_2, B_3, B_4\)). El dueño
                someterá a prueba dos refrigeradores al recibir el embarque y solamente lo aceptará si ninguno
                de ellos representa fallas. <strong>¿Qué probabilidad tiene de aceptar el embarque?</strong>
            </p>
            <p><strong>Espacio muestral (15 combinaciones posibles):</strong></p>
            <div class="math-expression">
                \[S = \{B_1B_2,\; B_1B_3,\; B_1B_4,\; B_1M_1,\; B_1M_2,\; B_2B_3,\; B_2B_4,\; B_2M_1,\; B_2M_2,\; B_3B_4,\; B_3M_1,\; B_3M_2,\; B_4M_1,\; B_4M_2,\; M_1M_2\}\]
            </div>
            <p class="formula-caption">
                Existen <strong>15 combinaciones</strong> y <strong>6 cumplen la condición</strong> (Evento \(A\):
                ambos refrigeradores buenos: \(B_1B_2, B_1B_3, B_1B_4, B_2B_3, B_2B_4, B_3B_4\)).
                \[P(A) = \frac{6}{15} = 0.4 \approx \mathbf{40\%}\]
            </p>
        </div>
    </div>
</div>


<!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular probabilidad clásica</h3>
        <p class="section-description">
            Introduce el nombre del evento y la cantidad de casos favorables y posibles del experimento.
        </p>

        <form id="form-clasica" data-action="u2_clasica" data-endpoint="../../Controllers/controlador_u2.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="evento">Evento (opcional)</label>
                    <input type="text" id="evento" name="evento" value="comité compuesto por un hombre y una mujer"
                           placeholder="Ej: obtener un as">
                </div>
                <div class="form-group">
                    <label for="favorables">Casos favorables</label>
                    <input type="number" id="favorables" name="favorables" value="6"
                           min="0" step="1" required placeholder="Ej: 6">
                </div>
                <div class="form-group">
                    <label for="posibles">Casos posibles</label>
                    <input type="number" id="posibles" name="posibles" value="10"
                           min="1" step="1" required placeholder="Ej: 10">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit">Calcular probabilidad</button>
                <button type="button" class="btn-secondary" data-ejemplo="comite">Ejemplo 1 (Comité)</button>
                <button type="button" class="btn-secondary" data-ejemplo="refrigeradores">Ejemplo 2 (Refrigeradores)</button>
                <button type="button" class="btn-secondary" data-ejemplo="clasica">Ejemplo Baraja (As)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-clasica" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    Practica.ejemplos.comite = {
        evento: 'comité compuesto por un hombre y una mujer',
        favorables: '6',
        posibles: '10'
    };
    Practica.ejemplos.refrigeradores = {
        evento: 'aceptar el embarque (ambos refrigeradores buenos)',
        favorables: '6',
        posibles: '15'
    };
    Practica.ejemplos.clasica = {
        evento: 'obtener un as',
        favorables: '4',
        posibles: '52'
    };
    Practica.conectar('form-clasica', 'resultado-clasica');
</script>


<?php include __DIR__ . '/../partials/footer.php'; ?>
