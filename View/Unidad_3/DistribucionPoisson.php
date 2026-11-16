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
    <title>Unidad 3 - Distribución de Poisson</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<div class="main-content">
    <?php include_once '../menu.php'; ?>
    <h1>Distribución de Poisson</h1>
    <div class="tabs">
                <button class="tab-button <?php echo ($pestaña_activa == 'teoria') ? 'active' : ''; ?>" onclick="switchTab('teoria')">📖 Zona Teórica</button>
                <button class="tab-button <?php echo ($pestaña_activa == 'practica') ? 'active' : ''; ?>" onclick="switchTab('practica')">⚡ Zona Práctica</button>
            </div>
    <!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <div class="card">
            <h3>Distribución de Poisson</h3>
            <p>
                Es una <strong>distribución teórica de probabilidad discreta</strong> con amplios usos en economía y comercio. Fue definida en 1837 por el teórico francés <em>Simeón Poisson</em> como un caso especial (límite) de la distribución binomial.
            </p>
            <p>
                Se utiliza para determinar la probabilidad (<strong>P</strong>) de un número designado de éxitos cuando los eventos ocurren en un <strong>espectro continuo de tiempo y espacio</strong> (en lugar de ensayos discretos como en Bernoulli).
            </p>
            <div class="formula-box">
                <h4>Aproximación de Binomial a Poisson</h4>
                <div class="math-expression">&lambda; = n &middot; p</div>
                <p>Cuando <strong>n</strong> es muy grande y <strong>p</strong> es muy pequeña, la media <strong>&lambda;</strong> se obtiene multiplicando ambos parámetros.</p>
            </div>
        </div>

        <div class="card">
            <h3>Fórmula y Componentes</h3>
            <div class="formula-box">
                <h4>Función de probabilidad de Poisson</h4>
                <div class="math-expression">
                    P(x / &lambda;) = 
                    <span style="display: inline-flex; flex-direction: column; vertical-align: middle; text-align: center; margin: 0 6px;">
                        <span style="border-bottom: 1px solid currentColor; padding: 0 6px;">&lambda;<sup>x</sup> &middot; e<sup>&minus;&lambda;</sup></span>
                        <span style="padding: 0 6px;">x!</span>
                    </span>
                </div>
            </div>
            <ul>
                <li><strong>x:</strong> Representa el número de éxitos cuya probabilidad deseamos calcular.</li>
                <li><strong>&lambda; (lambda):</strong> Es el promedio (media) de éxitos en un tiempo o espacio determinado.</li>
                <li><strong>e:</strong> Es la base de los logaritmos naturales (<strong>2.71828</strong>).</li>
                <li><strong>!:</strong> Representa la operación factorial (regla de conteo).</li>
            </ul>
        </div>

        <div class="card">
            <h3>Ejemplos de Clase (Apuntes)</h3>

            <div class="formula-box">
                <h4>1. Errores en un manuscrito</h4>
                <p>
                    Un texto tiene 40 errores en 400 páginas. Para un capítulo de 25 páginas, el promedio proporcional es 
                    <strong>&lambda; = <span style="display: inline-flex; flex-direction: column; vertical-align: middle; text-align: center; font-size: 0.85em; margin: 0 4px;"><span style="border-bottom: 1px solid currentColor; padding: 0 3px;">40 &middot; 25</span><span style="padding: 0 3px;">400</span></span> = 2.5</strong> errores. 
                    La probabilidad de hallar exactamente <strong>x = 2</strong> errores es:
                </p>
                <div class="math-expression">
                    P(2 / 2.5) = 
                    <span style="display: inline-flex; flex-direction: column; vertical-align: middle; text-align: center; margin: 0 6px;">
                        <span style="border-bottom: 1px solid currentColor; padding: 0 6px;">2.5<sup>2</sup> &middot; e<sup>&minus;2.5</sup></span>
                        <span style="padding: 0 6px;">2!</span>
                    </span>
                    = 
                    <span style="display: inline-flex; flex-direction: column; vertical-align: middle; text-align: center; margin: 0 6px;">
                        <span style="border-bottom: 1px solid currentColor; padding: 0 6px;">6.25 &middot; 0.08208</span>
                        <span style="padding: 0 6px;">2</span>
                    </span>
                    = <strong>0.256 (25.6%)</strong>
                </div>
            </div>

            <div class="formula-box" style="margin-top: 15px;">
                <h4>2. Fábrica de rondanas (Aproximación Binomial a Poisson)</h4>
                <p>
                    Con una muestra de <strong>n = 3,000</strong> y probabilidad <strong>p = 0.001</strong>, se obtiene una media de <strong>&lambda; = 3,000 &middot; 0.001 = 3</strong>. La probabilidad de encontrar un máximo de 3 defectuosas (<strong>x &le; 3</strong>) es:
                </p>
                <div class="math-expression">
                    P(X &le; 3 / 3) = P(0/3) + P(1/3) + P(2/3) + P(3/3) = 0.0498 + 0.149 + 0.224 + 0.224 = <strong>0.647 (64.7%)</strong>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content <?php echo ($pestaña_activa == 'practica') ? 'active' : ''; ?>">
    <div class="card practice-card">
        <h3>Calcular Distribución de Poisson</h3>
        <p class="section-description">
            Elige si ya conoces el promedio (<strong>λ</strong>) o si deseas que la calculadora lo obtenga por <strong>regla de tres</strong> o por <strong>aproximación binomial (n · p)</strong>.
        </p>

        <form id="form-poisson" data-action="u3_poisson" data-endpoint="../../Controllers/controlador_u3.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="modo_lambda">¿Cómo tienes el promedio (λ)?</label>
                    <select id="modo_lambda" name="modo_lambda">
                        <option value="directo" selected>Ya tengo λ directamente</option>
                        <option value="proporcion">Regla de tres (Eventos en un intervalo)</option>
                        <option value="binomial">Aproximación Binomial (n · p)</option>
                    </select>
                    <small class="field-hint">Selecciona según los datos de tu problema.</small>
                </div>

                <!-- MODO 1: Lambda directo -->
                <div class="form-group" data-grupo-poisson="directo">
                    <label for="lam">Promedio de ocurrencias (λ - Lambda)</label>
                    <input type="number" id="lam" name="lam" value="2.5" min="0.0001" step="any" placeholder="Ej: 2.5">
                    <small class="field-hint">Promedio esperado en el intervalo.</small>
                </div>

                <!-- MODO 2: Regla de tres (Ej: 40 errores en 400 pág -> 25 pág) -->
                <div class="form-group" data-grupo-poisson="proporcion" hidden>
                    <label for="eventos_base">Eventos conocidos</label>
                    <input type="number" id="eventos_base" name="eventos_base" value="40" min="0.0001" step="any" placeholder="Ej: 40">
                    <small class="field-hint">Ej: 40 errores encontrados.</small>
                </div>
                <div class="form-group" data-grupo-poisson="proporcion" hidden>
                    <label for="intervalo_base">Intervalo base conocido</label>
                    <input type="number" id="intervalo_base" name="intervalo_base" value="400" min="0.0001" step="any" placeholder="Ej: 400">
                    <small class="field-hint">Ej: en 400 páginas.</small>
                </div>
                <div class="form-group" data-grupo-poisson="proporcion" hidden>
                    <label for="intervalo_objetivo">Nuevo intervalo a evaluar</label>
                    <input type="number" id="intervalo_objetivo" name="intervalo_objetivo" value="25" min="0.0001" step="any" placeholder="Ej: 25">
                    <small class="field-hint">Ej: en un capítulo de 25 páginas.</small>
                </div>

                <!-- MODO 3: Aproximación Binomial (Ej: n = 3000, p = 0.001) -->
                <div class="form-group" data-grupo-poisson="binomial" hidden>
                    <label for="n_binom">Tamaño de muestra (n)</label>
                    <input type="number" id="n_binom" name="n_binom" value="3000" min="1" step="1" placeholder="Ej: 3000">
                    <small class="field-hint">Número grande de ensayos.</small>
                </div>
                <div class="form-group" data-grupo-poisson="binomial" hidden>
                    <label for="p_binom">Probabilidad de éxito (p)</label>
                    <input type="number" id="p_binom" name="p_binom" value="0.001" min="0.000001" max="1" step="any" placeholder="Ej: 0.001">
                    <small class="field-hint">Probabilidad pequeña (entre 0 y 1).</small>
                </div>

                <!-- SIEMPRE VISIBLE: Éxitos x -->
                <div class="form-group">
                    <label for="x">Número de éxitos a evaluar (x)</label>
                    <input type="number" id="x" name="x" min="0" step="1" value="2" placeholder="Ej: 2" required>
                    <small class="field-hint">Entero mayor o igual a 0.</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular Probabilidad</button>
                <button type="button" class="btn-secondary" data-ejemplo="poisson">Cargar ejemplo (Manuscrito)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-poisson" class="practice-results" hidden aria-live="polite"></div>
</div>

<script src="../assets/js/practica.js"></script>
<script>
    (function () {
        const selectModo = document.getElementById('modo_lambda');
        const grupos = document.querySelectorAll('[data-grupo-poisson]');

        function actualizarCamposPoisson() {
            const modo = selectModo.value;
            grupos.forEach(grupo => {
                grupo.hidden = grupo.getAttribute('data-grupo-poisson') !== modo;
            });
        }

        selectModo.addEventListener('change', actualizarCamposPoisson);

        Practica.ejemplos.poisson = {
            modo_lambda: 'proporcion',
            eventos_base: '40',
            intervalo_base: '400',
            intervalo_objetivo: '25',
            x: '2'
        };

        Practica.conectar('form-poisson', 'resultado-poisson');

        // Sincronizar campos visibles cuando se pulse "Cargar ejemplo" o "Limpiar"
        document.getElementById('form-poisson').addEventListener('click', function (e) {
            if (e.target.matches('[data-ejemplo], [data-limpiar]')) {
                setTimeout(actualizarCamposPoisson, 0);
            }
        });
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
