<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora One Milion - Distribución Binomial</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

    <?php include_once '../menu.php'; ?>

    <div class="main-content">
        <h1>📊 Distribución Binomial</h1>
        
        <div class="tabs">
            <button class="tab-button active" onclick="switchTab('teoria')">📖 Zona Teórica</button>
            <button class="tab-button" onclick="switchTab('practica')">⚡ Zona Práctica</button>
        </div>

        <!-- ZONA TEÓRICA -->
        <div id="teoria" class="tab-content active">
            <div class="theory-grid">
                <div class="card">
                    <h3>Distribución Binomial</h3>
                    <p>
                        Se relaciona con un experimento aleatorio conocido como <strong>experimento de Bernoulli</strong>. Por medio de la distribución binomial tratamos de encontrar un número dado de éxitos en un número igual o menor de pruebas.
                    </p>
                    <div class="formula-box">
                        <h4>Características del Experimento de Bernoulli</h4>
                        <ul>
                            <li>El experimento está constituido por un número de pruebas idénticas (por ejemplo: arrojar una moneda).</li>
                            <li>Cada prueba tiene exactamente dos resultados posibles: uno llamado arbitrariamente <strong>éxito</strong> y el otro <strong>fracaso</strong>.</li>
                            <li>La probabilidad de éxito de cada prueba aislada es constante y se denomina <strong>"p"</strong>.</li>
                            <li>La probabilidad de fracaso es constante para todas las pruebas y se denomina <strong>"q"</strong>.</li>
                        </ul>
                        <div class="math-expression">p + q = 1 &nbsp;&nbsp;|&nbsp;&nbsp; q = 1 &minus; p</div>
                    </div>
                </div>

                <div class="card">
                    <h3>Fórmula y Parámetros</h3>
                    <div class="formula-box">
                        <h4>Función de probabilidad Binomial</h4>
                        <div class="math-expression">
                            P(x) = C<sub>x</sub><sup>n</sup> &middot; p<sup>x</sup> &middot; q<sup>n &minus; x</sup>
                        </div>
                        <p style="margin-top: 8px; font-size: 0.92em;">
                            Donde <strong>C<sub>x</sub><sup>n</sup></strong> representa las combinaciones de <strong>n</strong> elementos tomados de <strong>x</strong> en <strong>x</strong>:
                        </p>
                        <div class="math-expression">
                            <span style="display: inline-flex; align-items: center; vertical-align: middle;">
                                <span style="font-size: 1.8em; font-weight: 300; margin-right: 2px;">(</span>
                                <span style="display: inline-flex; flex-direction: column; text-align: center; line-height: 1.1;">
                                    <span>n</span>
                                    <span>x</span>
                                </span>
                                <span style="font-size: 1.8em; font-weight: 300; margin-left: 2px;">)</span>
                            </span>
                            &nbsp;=&nbsp;
                            <span style="display: inline-flex; flex-direction: column; vertical-align: middle; text-align: center; margin: 0 6px;">
                                <span style="border-bottom: 1px solid currentColor; padding: 0 6px;">n!</span>
                                <span style="padding: 0 6px;">x! &middot; (n &minus; x)!</span>
                            </span>
                        </div>
                    </div>

                    <ul>
                        <li><strong>n:</strong> Número total de pruebas o ensayos realizados.</li>
                        <li><strong>x:</strong> Número de éxitos que se desea obtener en las <strong>n</strong> pruebas.</li>
                        <li><strong>p:</strong> Probabilidad de éxito en cada ensayo.</li>
                        <li><strong>q:</strong> Probabilidad de fracaso en cada ensayo (<strong>1 &minus; p</strong>).</li>
                    </ul>

                    <div class="formula-box" style="margin-top: 15px;">
                        <h4>Parámetros de una Variable Aleatoria Binomial</h4>
                        <div class="math-expression">
                            Media (&mu;) = n &middot; p &nbsp;&nbsp;|&nbsp;&nbsp; Varianza (&sigma;<sup>2</sup>) = n &middot; p &middot; q
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3>Ejemplos de Clase (Apuntes)</h3>

                    <div class="formula-box">
                        <h4>1. Embarque de televisores (Defectuosos)</h4>
                        <p>
                            Un embarque de 20 TV incluye 3 defectuosos. Si se inspeccionan <strong>n = 3</strong> TV al azar, con <strong>p = <span style="display: inline-flex; flex-direction: column; vertical-align: middle; text-align: center; font-size: 0.85em; margin: 0 3px;"><span style="border-bottom: 1px solid currentColor; padding: 0 3px;">3</span><span style="padding: 0 3px;">20</span></span> = 0.15</strong> y <strong>q = 0.85</strong>, la probabilidad de hallar exactamente <strong>x = 2</strong> defectuosos es:
                        </p>
                        <div class="math-expression">
                            P(x = 2) = C<sub>2</sub><sup>3</sup> &middot; (0.15)<sup>2</sup> &middot; (0.85)<sup>1</sup> = 3 &middot; 0.0225 &middot; 0.85 = <strong>0.057 &asymp; 0.06 (6%)</strong>
                        </div>
                    </div>

                    <div class="formula-box" style="margin-top: 15px;">
                        <h4>2. Estudiantes y mapa de Afganistán</h4>
                        <p>
                            El 30% no localiza Afganistán en un mapa (<strong>q = 0.3</strong>), por lo que <strong>p = 0.7</strong> sí lo localiza. Al entrevistar a <strong>n = 6</strong> estudiantes, la probabilidad de que un máximo de dos lo localicen (<strong>X &le; 2</strong>) es:
                        </p>
                        <div class="math-expression">
                            P(X &le; 2) = P(0) + P(1) + P(2) = 0.00073 + 0.01021 + 0.05954 = <strong>0.07048 (&asymp; 7%)</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ZONA PRÁCTICA -->
        <div id="practica" class="tab-content">
            <div class="card">
                <h3>Calcular Distribución Binomial</h3>
                <p>Ingresa el número total de pruebas o ensayos (<strong>n</strong>), la probabilidad de éxito (<strong>p</strong>) y el número de éxitos esperados (<strong>x</strong>).</p>

                <form id="form-binomial" data-action="u3_binomial" data-endpoint="../../Controllers/controlador_u3.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="n">Número de ensayos (n)</label>
                            <input type="number" step="1" min="1" max="200" id="n" name="n" placeholder="Ej. 3" required>
                        </div>

                        <div class="form-group">
                            <label for="p">Probabilidad de éxito (p)</label>
                            <input type="number" step="any" min="0" max="1" id="p" name="p" placeholder="Ej. 0.15" required>
                        </div>

                        <div class="form-group">
                            <label for="x">Número de éxitos deseados (x)</label>
                            <input type="number" step="1" min="0" id="x" name="x" placeholder="Ej. 2" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit">Calcular Probabilidad</button>
                        <button type="button" class="btn-secondary" data-ejemplo="binomial">Cargar ejemplo (Embarque TV)</button>
                        <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
                    </div>
                </form>
            </div>

            <div id="resultado-binomial" class="practice-results" hidden aria-live="polite"></div>
        </div>

    <script src="../assets/js/practica.js"></script>
    <script>
        (function () {
            Practica.ejemplos.binomial = {
                n: '3',
                p: '0.15',
                x: '2'
            };

            Practica.conectar('form-binomial', 'resultado-binomial');
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
    </script>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
