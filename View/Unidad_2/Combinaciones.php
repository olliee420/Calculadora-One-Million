<?php
$titulo_pagina = 'Combinaciones';
$descripcion_pagina = 'Calcula combinaciones sin repetición y con repetición, donde el orden no importa.';
include __DIR__ . '/../partials/head.php';
?>

<h1>🎯 Combinaciones</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEORICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Apunte principal -->
        <div class="card">
            <h3>Combinaciones</h3>
            <p>
                Una combinación de objetos es cualquier selección de ellos en la que
                <strong>no importa el orden</strong>. El número de combinaciones de \(n\) objetos
                tomados de \(r\) en \(r\) viene dado por la fórmula general:
            </p>
            <div class="formula-box">
                <div class="math-expression">\[C_r^n = \frac{n!}{r!\,(n-r)!}\]</div>
            </div>
        </div>

        <!-- Tarjeta 2: Ejemplos resueltos de tus apuntes -->
        <div class="card">
            <h3>Ejemplos resueltos</h3>

            <div class="formula-box">
                <h4>Ejemplo 1: Auditoría de cuentas por pagar</h4>
                <p>
                    Al auditar las 87 cuentas por pagar de una compañía, se inspecciona una muestra de
                    10 cuentas. ¿Cuántas muestras posibles hay?
                </p>
                <p><strong>Datos:</strong> \(n = 87\), \(r = 10\)</p>
                <div class="math-expression">
                    \[C_{10}^{87} = \frac{87!}{10!(87-10)!} = \frac{87!}{10!(77)!} = 4,000,751,045,226\]
                </div>
                <p class="formula-caption">Existen <strong>4,000,751,045,226</strong> muestras posibles.</p>
            </div>

            <div class="formula-box">
                <h4>Ejemplo 2: Comités en un club</h4>
                <p>
                    Si un club tiene 20 miembros, ¿cuántos comités diferentes de 4 miembros posibles
                    pueden existir?
                </p>
                <p><strong>Datos:</strong> \(n = 20\), \(r = 4\)</p>
                <div class="math-expression">
                    \[C_{4}^{20} = \frac{20!}{4!(20-4)!} = \frac{20!}{4!(16)!} = \frac{20 \times 19 \times 18 \times 17 \times 16!}{(4 \times 3 \times 2 \times 1) \times 16!} = 4,845\]
                </div>
            </div>
        </div>

        <!-- Tarjeta 3: Complemento para la calculadora -->
        <div class="card">
            <h3>Otras variantes y propiedades</h3>
            <div class="formula-box">
                <h4>Combinaciones con repetición</h4>
                <div class="math-expression">\[C(n+r-1, r) = \frac{(n+r-1)!}{r!\,(n-1)!}\]</div>
                <p class="formula-caption">
                    Se usan cuando se pueden repetir elementos y el orden sigue sin importar.
                </p>
            </div>
            <ul>
                <li>En una permutación importa el orden: \(ABC \neq CBA\).</li>
                <li>En una combinación no importa el orden: \(ABC = CBA\).</li>
                <li>Propiedad de simetría: \(C_r^n = C_{n-r}^n\).</li>
            </ul>
        </div>
    </div>
</div>


<!-- ZONA DE PRACTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular combinaciones</h3>
        <p class="section-description">
            Elige la variante e ingresa el total de elementos \(n\) y cuántos se seleccionan \(r\).
        </p>

        <form id="form-combinaciones" data-action="u2_combinaciones" data-endpoint="../../Controllers/controlador_u2.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="variante">Variante</label>
                    <select id="variante" name="variante">
                        <option value="sin_repeticion" selected>Sin repetición: C(n, r)</option>
                        <option value="con_repeticion">Con repetición: C(n + r - 1, r)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="n">n (total de elementos)</label>
                    <input type="number" id="n" name="n" value="20" min="0" max="200" step="1" required>
                </div>
                <div class="form-group">
                    <label for="r">r (elementos seleccionados)</label>
                    <input type="number" id="r" name="r" value="4" min="0" max="200" step="1" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit">Calcular combinación</button>
                <button type="button" class="btn-secondary" data-ejemplo="comb-auditoria">Ejemplo 1 (Auditoría)</button>
                <button type="button" class="btn-secondary" data-ejemplo="comb-comite">Ejemplo 2 (Comités)</button>
                <button type="button" class="btn-secondary" data-ejemplo="comb-con">Ejemplo con repetición</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-combinaciones" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    Practica.ejemplos['comb-auditoria'] = {
        variante: 'sin_repeticion', n: '87', r: '10'
    };
    Practica.ejemplos['comb-comite'] = {
        variante: 'sin_repeticion', n: '20', r: '4'
    };
    Practica.ejemplos['comb-con'] = {
        variante: 'con_repeticion', n: '5', r: '2'
    };
    Practica.conectar('form-combinaciones', 'resultado-combinaciones');
</script>


<?php include __DIR__ . '/../partials/footer.php'; ?>
