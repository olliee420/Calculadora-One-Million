<?php
$titulo_pagina = 'Probabilidad Condicional';
$descripcion_pagina = 'Calcula probabilidades condicionales directas P(B|A), P(A|B) y mediante tabla de intersecciones y complementos.';
include __DIR__ . '/../partials/head.php';
?>

<h1>🎯 Probabilidad Condicional</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Definición y Fórmulas Base -->
        <div class="card">
            <h3>Probabilidad Condicional</h3>
            <p>
                En muchas circunstancias encontramos que la probabilidad de ocurrencia de un evento se ve
                modificada por la ocurrencia de otro evento. Por ejemplo, la probabilidad de pasar un examen
                depende del hecho de que el estudiante haya estudiado para el mismo. A esta probabilidad se
                le conoce como <strong>probabilidad condicional</strong>.
            </p>
            <div class="formula-box">
                <h4>Probabilidad de que ocurra B dado que A ya ocurrió</h4>
                <div class="math-expression">\[P(B \mid A) = \frac{P(A \cap B)}{P(A)}\]</div>
                <p class="formula-caption">
                    Es igual a la probabilidad de que ocurran ambos eventos simultáneamente dividido por la
                    probabilidad de que ocurra \(A\), que en este caso es el <strong>evento antecedente</strong>.
                </p>
            </div>
            <div class="formula-box">
                <h4>Probabilidad de que ocurra A dado que B ya ocurrió</h4>
                <div class="math-expression">\[P(A \mid B) = \frac{P(A \cap B)}{P(B)}\]</div>
                <p class="formula-caption">
                    La línea vertical entre \(A\) y \(B\) significa «dado que», donde \(B\) es ahora el
                    <strong>evento antecedente</strong>.
                </p>
            </div>
        </div>

        <!-- Tarjeta 2: Complementos y Reglas Marginales -->
        <div class="card">
            <h3>Complementos e Intersecciones</h3>
            <p>
                La probabilidad del complemento de un evento \(A\) (denotado \(A'\) o \(A^c\)) es igual a
                \(1 - P(A)\):
            </p>
            <div class="formula-box">
                <h4>Probabilidad del complemento</h4>
                <div class="math-expression">\[P(A') = 1 - P(A)\]</div>
                <p class="formula-caption">
                    Ejemplo rápido: si \(P(A) = 0.30\) (30%), entonces \(P(A') = 1 - 0.30 = 0.70\) (70%).
                </p>
            </div>
            <div class="formula-box">
                <h4>Probabilidades Marginales</h4>
                <div class="math-expression">\[P(A) = P(A \cap B) + P(A \cap B^c)\]</div>
                <div class="math-expression">\[P(A^c) = P(A^c \cap B) + P(A^c \cap B^c)\]</div>
                <div class="math-expression">\[P(B) = P(A \cap B) + P(A^c \cap B)\]</div>
            </div>
        </div>
    </div>

    <!-- Tarjeta 3: Ejemplo completo del cuaderno -->
    <div class="card">
        <h3>Ejemplo Resuelto: Pronóstico Meteorológico</h3>
        
        <h4>1. Definición de eventos</h4>
        <ul>
            <li><strong>Evento \(A\):</strong> Amanece nublado en la región X. (Complemento \(A^c\): amanece despejado).</li>
            <li><strong>Evento \(B\):</strong> Llueve en la tarde en la región X. (Complemento \(B^c\): no llueve en la tarde).</li>
        </ul>

        <h4>2. Información recolectada (Datos)</h4>
        <ul>
            <li>Amanece nublado y llueve: <strong>40%</strong> de los días \(\rightarrow P(A \cap B) = 0.40\)</li>
            <li>Amanece nublado y no llueve: <strong>20%</strong> de los días \(\rightarrow P(A \cap B^c) = 0.20\)</li>
            <li>Amanece despejado y llueve: <strong>10%</strong> de los días \(\rightarrow P(A^c \cap B) = 0.10\)</li>
            <li>Amanece despejado y no llueve: <strong>30%</strong> de los días \(\rightarrow P(A^c \cap B^c) = 0.30\)</li>
        </ul>

        <h4>3. Probabilidades Marginales</h4>
        <ul>
            <li>\(P(A) = 0.40 + 0.20 = 0.60\) (Amanece nublado)</li>
            <li>\(P(A^c) = 0.10 + 0.30 = 0.40\) (Amanece despejado)</li>
            <li>\(P(B) = 0.40 + 0.10 = 0.50\) (Llueve en la tarde)</li>
            <li>\(P(B^c) = 0.20 + 0.30 = 0.50\) (No llueve en la tarde)</li>
        </ul>

        <h4>4. Resolución de los incisos</h4>
        <div class="formula-box">
            <h4>Inciso a) Probabilidad de que llueva en la tarde dado que amaneció nublado: \(P(B \mid A)\)</h4>
            <div class="math-expression">
                \[P(B \mid A) = \frac{P(A \cap B)}{P(A)} = \frac{0.40}{0.60} = 0.667 = 66.7\%\]
            </div>
            <p class="formula-caption">
                Es decir, la probabilidad de que llueva dado que amaneció nublado es del <strong>67% (redondeado)</strong>.
                Amanecer nublado aumenta drásticamente las posibilidades de lluvia (pasa de un 50% general a un 66.7%).
            </p>
        </div>

        <div class="formula-box">
            <h4>Inciso b) Probabilidad de que llueva en la tarde dado que amaneció despejado: \(P(B \mid A^c)\)</h4>
            <div class="math-expression">
                \[P(B \mid A^c) = \frac{P(A^c \cap B)}{P(A^c)} = \frac{0.10}{0.40} = 0.25 = 25\%\]
            </div>
        </div>
    </div>
</div>


<!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular Probabilidad Condicional</h3>
        <p class="section-description">
            Elige si deseas ingresar las probabilidades directamente o resolver a partir de las 4 intersecciones (tabla de complementos).
        </p>

        <form id="form-condicional" data-action="u2_probabilidad_condicional" data-endpoint="../../Controllers/controlador_u2.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="modo_cond">Método de cálculo</label>
                    <select id="modo_cond" name="modo">
                        <option value="tabla" selected>Tabla de intersecciones y complementos (4 eventos)</option>
                        <option value="directo">Fórmula directa: P(B | A) o P(A | B)</option>
                    </select>
                </div>

                <!-- Campos para modo DIRECTO -->
                <div class="form-group" id="grupo-direccion" hidden>
                    <label for="direccion">Probabilidad a calcular</label>
                    <select id="direccion" name="direccion">
                        <option value="b_dado_a" selected>P(B | A) = P(A ∩ B) / P(A)</option>
                        <option value="a_dado_b">P(A | B) = P(A ∩ B) / P(B)</option>
                    </select>
                </div>

                <div class="form-group" id="grupo-directo-inter" hidden>
                    <label for="p_interseccion">Intersección P(A ∩ B)</label>
                    <input type="number" id="p_interseccion" name="p_interseccion" value="0.24" min="0" max="1" step="0.0001">
                </div>

                <div class="form-group" id="grupo-directo-cond" hidden>
                    <label for="p_condicion" id="label-p-condicion">Probabilidad del evento dado P(A)</label>
                    <input type="number" id="p_condicion" name="p_condicion" value="0.60" min="0.0001" max="1" step="0.0001">
                </div>

                <!-- Campos para modo TABLA DE INTERSECCIONES -->
                <div class="form-group" id="grupo-ab">
                    <label for="p_ab">P(A ∩ B) — Ocurre A y ocurre B</label>
                    <input type="number" id="p_ab" name="p_ab" value="0.40" min="0" max="1" step="0.0001">
                </div>

                <div class="form-group" id="grupo-ab-comp">
                    <label for="p_ab_comp">P(A ∩ Bᶜ) — Ocurre A y no ocurre B</label>
                    <input type="number" id="p_ab_comp" name="p_ab_comp" value="0.20" min="0" max="1" step="0.0001">
                </div>

                <div class="form-group" id="grupo-a-comp-b">
                    <label for="p_a_comp_b">P(Aᶜ ∩ B) — No ocurre A y ocurre B</label>
                    <input type="number" id="p_a_comp_b" name="p_a_comp_b" value="0.10" min="0" max="1" step="0.0001">
                </div>

                <div class="form-group" id="grupo-a-comp-b-comp">
                    <label for="p_a_comp_b_comp">P(Aᶜ ∩ Bᶜ) — No ocurre A ni ocurre B</label>
                    <input type="number" id="p_a_comp_b_comp" name="p_a_comp_b_comp" value="0.30" min="0" max="1" step="0.0001">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Calcular resultado</button>
                <button type="button" class="btn-secondary" data-ejemplo="clima">Ejemplo Clima (Cuaderno)</button>
                <button type="button" class="btn-secondary" data-ejemplo="directo">Ejemplo Fórmula Directa</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-condicional" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    (function () {
        var modo = document.getElementById('modo_cond');
        var direccion = document.getElementById('direccion');
        var labelCondicion = document.getElementById('label-p-condicion');

        var camposDirecto = [
            document.getElementById('grupo-direccion'),
            document.getElementById('grupo-directo-inter'),
            document.getElementById('grupo-directo-cond')
        ];

        var camposTabla = [
            document.getElementById('grupo-ab'),
            document.getElementById('grupo-ab-comp'),
            document.getElementById('grupo-a-comp-b'),
            document.getElementById('grupo-a-comp-b-comp')
        ];

        function actualizarVista() {
            var esTabla = modo.value === 'tabla';
            camposTabla.forEach(function (el) { el.hidden = !esTabla; });
            camposDirecto.forEach(function (el) { el.hidden = esTabla; });
        }

        function actualizarEtiquetaDireccion() {
            labelCondicion.textContent = direccion.value === 'b_dado_a'
                ? 'Probabilidad del evento dado P(A)'
                : 'Probabilidad del evento dado P(B)';
        }

        modo.addEventListener('change', actualizarVista);
        direccion.addEventListener('change', actualizarEtiquetaDireccion);
        actualizarVista();

        Practica.ejemplos.clima = {
            modo: 'tabla',
            p_ab: '0.40',
            p_ab_comp: '0.20',
            p_a_comp_b: '0.10',
            p_a_comp_b_comp: '0.30'
        };

        Practica.ejemplos.directo = {
            modo: 'directo',
            direccion: 'b_dado_a',
            p_interseccion: '0.24',
            p_condicion: '0.60'
        };

        // Asegurar que al cargar ejemplo también se actualice la visibilidad de campos
        document.querySelectorAll('[data-ejemplo]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setTimeout(function () {
                    actualizarVista();
                    actualizarEtiquetaDireccion();
                }, 0);
            });
        });

        Practica.conectar('form-condicional', 'resultado-condicional');
    })();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
