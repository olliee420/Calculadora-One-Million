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
    <title>Unidad 3 - Distribución Normal Estándar</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<div class="main-content">
    <?php include_once '../menu.php'; ?>
    <h1>Distribución Normal Estándar</h1>
    <div class="tabs">
                <button class="tab-button <?php echo ($pestaña_activa == 'teoria') ? 'active' : ''; ?>" onclick="switchTab('teoria')">📖 Zona Teórica</button>
                <button class="tab-button <?php echo ($pestaña_activa == 'practica') ? 'active' : ''; ?>" onclick="switchTab('practica')">⚡ Zona Práctica</button>
            </div>

    <!-- ZONA TEORICA-->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <div class="card">
            <h3>Distribución Normal Estándar</h3>
            <p>
                Es una <strong>distribución de probabilidad continua</strong> cuya gráfica tiene forma de campana simétrica (campana de Gauss), donde la media, la mediana y la moda coinciden en el centro.
            </p>
            <div class="formula-box">
                <h4>Fórmula General</h4>
                <div class="math-expression" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 1.15em;">
                    <span>Y =</span>
                    <span style="display: inline-flex; flex-direction: column; align-items: center; vertical-align: middle;">
                        <span style="border-bottom: 1px solid currentColor; padding: 0 8px 2px;">1</span>
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
        </div>

        <div class="card">
            <h3>Identificación de Componentes de la Fórmula</h3>
            <p>
                Cada elemento que interviene en la ecuación general representa:
            </p>
            <ul>
                <li><strong>Y:</strong> Función de densidad de probabilidad.</li>
                <li><strong>n:</strong> En este contexto de la función continua, representa el tamaño de la población, aunque no se usa directamente en la curva estándar Z.</li>
                <li><strong>e:</strong> Base de los logaritmos naturales = <strong>2.71828</strong>.</li>
                <li><strong>σ:</strong> Desviación estándar de la población.</li>
                <li><strong>π:</strong> Constante matemática = <strong>3.14159</strong>.</li>
            </ul>
        </div>


        <div class="card">
            <h3>Estandarización (Puntaje Z)</h3>
            <p>
                Para trabajar cualquier variable normal <strong>X</strong> con media <strong>μ</strong> y desviación <strong>σ</strong> sobre la curva normal estándar, se transforma mediante la fórmula:
            </p>
            <div class="formula-box">
                <h4>Fórmula de estandarización</h4>
                <div class="math-expression">Z = (x − μ) / σ</div>
            </div>
            <p>
                En una distribución normal estándar directa (μ = 0, σ = 1), el valor de <strong>x</strong> coincide directamente con <strong>Z</strong>.
            </p>
        </div>
    </div>
</div>

    <!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content <?php echo (isset($pestaña_activa) && $pestaña_activa == 'practica') ? 'active' : ''; ?>">
    <div class="card practice-card">
        <h3>Calcular Distribución Normal Estándar</h3>
        <p class="section-description">
            Ingresa la media (<strong>μ</strong>), la desviación estándar (<strong>σ</strong>) y el valor a evaluar (<strong>x</strong>). Para la curva normal estándar pura usa <strong>μ = 0</strong> y <strong>σ = 1</strong>.
        </p>

        <form id="form-normal" data-action="u3_normal" data-endpoint="../../Controllers/controlador_u3.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="media">Media poblacional (μ)</label>
                    <input type="number" id="media" name="media" value="0" step="any" placeholder="Ej: 0" required>
                    <small class="field-hint">Usa 0 para la distribución normal estándar.</small>
                </div>
                <div class="form-group">
                    <label for="desviacion">Desviación estándar (σ)</label>
                    <input type="number" id="desviacion" name="desviacion" value="1" min="0.0001" step="any" placeholder="Ej: 1" required>
                    <small class="field-hint">Debe ser mayor que 0 (usa 1 para estándar).</small>
                </div>
                <div class="form-group">
                    <label for="valor_x">Valor a evaluar (x)</label>
                    <input type="number" id="valor_x" name="valor_x" value="1.5" step="any" placeholder="Ej: 1.5" required>
                    <small class="field-hint">Punto sobre el eje horizontal.</small>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit">Calcular Normal</button>
                <button type="button" class="btn-secondary" data-ejemplo="normal">Cargar ejemplo</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-normal" class="practice-results" hidden aria-live="polite"></div>
</div>

<script src="../assets/js/practica.js"></script>
<script>
    Practica.ejemplos.normal = {
        media: '0',
        desviacion: '1',
        valor_x: '1.96'
    };
    Practica.conectar('form-normal', 'resultado-normal');
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
