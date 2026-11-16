<?php
$titulo_pagina = 'Regla de la Suma y Multiplicación';
$descripcion_pagina = 'Calcula uniones, intersecciones y probabilidades condicionales con eventos dependientes o independientes.';
include __DIR__ . '/../partials/head.php';
?>

<h1>🔀 Criterio de la Suma y Multiplicación</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <div class="card">
            <h3>Principio de la suma</h3>
            <p>
                Supongamos que un evento "A" se puede realizar de "m" maneras y otro evento "B" se puede 
                realizar de "n" maneras diferentes, además no es posible que ambos eventos se realicen juntos.
            </p>
            <div class="formula-box">
                <h4>Fórmula general</h4>
                <div class="math-expression">\[N = m + n\]</div>
            </div>
            <p>
                Si existen más de dos alternativas excluyentes entre sí, se suman las maneras de cada opción: 
                \(N = n_1 + n_2 + \dots + n_k\).
            </p>
        </div>

        <div class="card">
            <h3>Principio de la multiplicación</h3>
            <p>
                Si un evento o suceso "A" puede ocurrir en forma independiente de "m" maneras diferentes 
                y el suceso "B" de "n" maneras diferentes, entonces el número de maneras distintas en que 
                pueden suceder ambos sucesos es "m" x "n".
            </p>
            <div class="formula-box">
                <h4>Dos sucesos</h4>
                <div class="math-expression">\[N = m \times n\]</div>
            </div>
            <div class="formula-box">
                <h4>Método de casilleros</h4>
                <div class="math-expression">\[N = n_1 \times n_2 \times n_3 \times \dots \times n_k\]</div>
            </div>
        </div>
    </div>

</div>

    
        <!-- ZONA DE PRACTICA -->

<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular principio de suma o multiplicación</h3>
        <p class="section-description">
            Selecciona el principio a aplicar e ingresa las cantidades enteras de maneras u opciones (m y n).
        </p>

        <form id="form-suma-mult" data-action="u2_suma_multiplicacion" data-endpoint="../../Controllers/controlador_u2.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="modo">Principio a aplicar</label>
                    <select id="modo" name="modo">
                        <option value="multiplicacion" selected>Principio de la multiplicación: m × n</option>
                        <option value="suma">Principio de la suma: m + n</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="m">Maneras del evento A (m)</label>
                    <input type="number" id="m" name="m" value="3" min="1" step="1" required>
                </div>
                <div class="form-group">
                    <label for="n">Maneras del evento B (n)</label>
                    <input type="number" id="n" name="n" value="2" min="1" step="1" required>
                </div>
                <div class="form-group">
                    <label for="casilleros">Casilleros extra (opcional, separados por coma)</label>
                    <input type="text" id="casilleros" name="casilleros" placeholder="Ej. 10, 9, 8">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular resultado</button>
                <button type="button" class="btn-secondary" data-ejemplo="suma">Ejemplo de suma</button>
                <button type="button" class="btn-secondary" data-ejemplo="multiplicacion">Ejemplo de multiplicación</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-suma-mult" class="practice-results" hidden aria-live="polite"></div>
</div>


<script>
    (function () {
        Practica.ejemplos.suma = {
            modo: 'suma',
            m: '3',
            n: '2',
            casilleros: ''
        };
        Practica.ejemplos.multiplicacion = {
            modo: 'multiplicacion',
            m: '26',
            n: '25',
            casilleros: '10, 9, 8'
        };

        Practica.conectar('form-suma-mult', 'resultado-suma-mult');
    })();
</script>


<?php include __DIR__ . '/../partials/footer.php'; ?>
