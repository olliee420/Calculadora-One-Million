<?php
$titulo_pagina = 'Permutaciones';
$descripcion_pagina = 'Calcula permutaciones sin repetición, con repetición, circulares y con elementos repetidos.';
include __DIR__ . '/../partials/head.php';
?>

<h1>🔢 Permutaciones</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEORICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Apunte principal -->
        <div class="card">
            <h3>Permutaciones</h3>
            <p>
                Una permutación de un número de objetos es cualquiera de los diferentes arreglos de esos
                objetos en un <strong>orden definido</strong>. El número de permutaciones de \(n\) objetos
                tomados de \(r\) en \(r\) viene dado por la siguiente fórmula general:
            </p>
            <div class="formula-box">
                <div class="math-expression">\[P_r^n = \frac{n!}{(n-r)!} \quad ; \quad r \leq n\]</div>
            </div>
        </div>

        <!-- Tarjeta 2: Factorial según tus apuntes -->
        <div class="card">
            <h3>Factorial</h3>
            <p>El factorial de un número entero positivo se define como:</p>
            <div class="formula-box">
                <div class="math-expression">\[n! = n \times (n - 1) \times (n - 2) \times \dots \times 2 \times 1\]</div>
            </div>
            <p><strong>Ejemplos:</strong></p>
            <ul>
                <li>\(3! = 3 \times 2 \times 1 = 6\)</li>
                <li>\(5! = 5 \times 4 \times 3 \times 2 \times 1 = 120\)</li>
            </ul>
        </div>

        <!-- Tarjeta 3: Ejemplos resueltos de tus apuntes -->
        <div class="card">
            <h3>Ejemplos resueltos</h3>
            
            <div class="formula-box">
                <h4>Ejemplo 1: Gerentes en plantas</h4>
                <p>
                    Una empresa quiere colocar a 3 gerentes en 3 de sus 10 plantas. ¿De cuántas maneras
                    diferentes puede hacerlo?
                </p>
                <p><strong>Datos:</strong> \(n = 10\), \(r = 3\)</p>
                <div class="math-expression">
                    \[P_3^{10} = \frac{10!}{(10-3)!} = \frac{10!}{7!} = \frac{10 \times 9 \times 8 \times \cancel{7!}}{\cancel{7!}} = 720\]
                </div>
            </div>

            <div class="formula-box">
                <h4>Ejemplo 2: Elección de cargos en un club</h4>
                <p>
                    Supóngase que un club consta de 25 miembros y que se ha de elegir un presidente y un
                    secretario. Determine el número total de formas posibles en que estos dos cargos se
                    pueden ocupar.
                </p>
                <p><strong>Datos:</strong> \(n = 25\), \(r = 2\)</p>
                <div class="math-expression">
                    \[P_2^{25} = \frac{25!}{(25-2)!} = \frac{25!}{23!} = \frac{25 \times 24 \times \cancel{23!}}{\cancel{23!}} = 600\]
                </div>
            </div>
        </div>

        <!-- Tarjeta 4: Complemento para las demás opciones de la calculadora -->
        <div class="card">
            <h3>Otras variantes de permutación</h3>
            <div class="formula-box">
                <h4>Con repetición</h4>
                <div class="math-expression">\[P = n^r\]</div>
                <p class="formula-caption">Cada posición admite cualquiera de los \(n\) elementos.</p>
            </div>
            <div class="formula-box">
                <h4>Permutación circular</h4>
                <div class="math-expression">\[P_c(n) = (n-1)!\]</div>
                <p class="formula-caption">Las rotaciones del mismo arreglo se consideran equivalentes.</p>
            </div>
            <div class="formula-box">
                <h4>Con elementos repetidos</h4>
                <div class="math-expression">\[P = \frac{n!}{n_1!\,n_2!\cdots n_k!}\]</div>
                <p class="formula-caption">Donde \(n_1, n_2, \dots, n_k\) son las repeticiones de cada elemento y suman \(n\).</p>
            </div>
        </div>
    </div>
</div>

<!-- ZONA DE PRACTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular permutaciones</h3>
        <p class="section-description">
            Elige la variante y completa los datos (recuerda que en permutación sin repetición debe cumplirse \(r \leq n\)).
        </p>

        <form id="form-permutaciones" data-action="u2_permutaciones" data-endpoint="../../Controllers/controlador_u2.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="variante">Variante</label>
                    <select id="variante" name="variante">
                        <option value="sin_repeticion" selected>Sin repetición: P(n, r)</option>
                        <option value="con_repeticion">Con repetición: n^r</option>
                        <option value="circular">Circular: (n - 1)!</option>
                        <option value="elementos_repetidos">Con elementos repetidos</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="n">n (total de elementos)</label>
                    <input type="number" id="n" name="n" value="10" min="0" max="200" step="1" required>
                </div>
                <div class="form-group" id="grupo-r">
                    <label for="r">r (elementos a ordenar)</label>
                    <input type="number" id="r" name="r" value="3" min="0" max="200" step="1">
                </div>
                <div class="form-group" id="grupo-grupos" hidden>
                    <label for="grupos">Grupos de elementos repetidos</label>
                    <input type="text" id="grupos" name="grupos" value="3, 2, 2" placeholder="Ej: 3, 2, 2">
                    <small class="field-hint">La suma de los grupos debe ser igual a n.</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular permutación</button>
                <button type="button" class="btn-secondary" data-ejemplo="perm-sin">Ejemplo 1 (Gerentes)</button>
                <button type="button" class="btn-secondary" data-ejemplo="perm-club">Ejemplo 2 (Club)</button>
                <button type="button" class="btn-secondary" data-ejemplo="perm-con">Ejemplo con repetición</button>
                <button type="button" class="btn-secondary" data-ejemplo="perm-circular">Ejemplo circular</button>
                <button type="button" class="btn-secondary" data-ejemplo="perm-repetidos">Ejemplo con repetidos</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-permutaciones" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    (function () {
        var variante = document.getElementById('variante');
        var grupoR = document.getElementById('grupo-r');
        var grupoGrupos = document.getElementById('grupo-grupos');

        function actualizarCampos() {
            var valor = variante.value;
            grupoR.hidden = valor === 'circular' || valor === 'elementos_repetidos';
            grupoGrupos.hidden = valor !== 'elementos_repetidos';
        }

        variante.addEventListener('change', actualizarCampos);
        actualizarCampos();

        Practica.ejemplos['perm-sin'] = {
            variante: 'sin_repeticion', n: '10', r: '3'
        };
        Practica.ejemplos['perm-club'] = {
            variante: 'sin_repeticion', n: '25', r: '2'
        };
        Practica.ejemplos['perm-con'] = {
            variante: 'con_repeticion', n: '4', r: '2'
        };
        Practica.ejemplos['perm-circular'] = {
            variante: 'circular', n: '6', r: '3'
        };
        Practica.ejemplos['perm-repetidos'] = {
            variante: 'elementos_repetidos', n: '7', r: '3', grupos: '3, 2, 2'
        };

        Practica.conectar('form-permutaciones', 'resultado-permutaciones');
    })();
</script>


<?php include __DIR__ . '/../partials/footer.php'; ?>
