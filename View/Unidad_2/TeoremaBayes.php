<?php
$titulo_pagina = 'Teorema de Bayes';
$descripcion_pagina = 'Actualiza la probabilidad de una hipótesis a partir de nueva evidencia usando el teorema de Bayes.';
include __DIR__ . '/../partials/head.php';
?>

<h1>🧠 Teorema de Bayes</h1>

<div class="tabs">
    <button type="button" class="tab-button active" data-tab="teoria">📖 Zona Teórica</button>
    <button type="button" class="tab-button" data-tab="practica">⚡ Zona Práctica</button>
</div>

<!-- ZONA TEÓRICA -->
<div id="teoria" class="tab-content active">
    <div class="theory-grid">
        <!-- Tarjeta 1: Definición literal de tus apuntes -->
        <div class="card">
            <h3>Teorema de Bayes</h3>
            <p>
                Cuando calculamos la probabilidad de \(B\) dado que \(A\) ya ocurrió, de alguna manera se
                piensa que el evento \(A\) es algo que sucede antes que \(B\) y que \(A\) puede ser (tal vez)
                causa de \(B\) o puede contribuir a su aparición. También de algún modo podemos decir que
                \(A\) normalmente ocurre antes que \(B\).
            </p>
            <p>
                Pensemos, por ejemplo, que deseábamos saber la probabilidad de que un estudiante apruebe el
                examen parcial de estadística dado que estudió por lo menos veinte horas antes del mismo.
                En algunas ocasiones sabemos que ocurrió el evento \(B\) y queremos saber cuál es la
                probabilidad de que haya ocurrido el evento \(A\). En el ejemplo anterior la pregunta sería:
                <strong>¿cuál es la probabilidad de que el alumno haya estudiado por lo menos 20 horas dado
                que, efectivamente, aprobó el examen parcial de estadística?</strong>
            </p>
        </div>

        <!-- Tarjeta 2: Fórmula general y definiciones -->
        <div class="card">
            <h3>Fórmula General y Componentes</h3>
            <p>
                Esta probabilidad se encuentra aplicando una regla que se conoce como <strong>Teorema de Bayes</strong>:
            </p>
            <div class="formula-box">
                <div class="math-expression">
                    \[P(A_i \mid B) = \frac{P(B \mid A_i) \cdot P(A_i)}{P(B \mid A_1) \cdot P(A_1) + P(B \mid A_2) \cdot P(A_2) + \dots + P(B \mid A_k) \cdot P(A_k)}\]
                </div>
            </div>
            <ul>
                <li><strong>\(P(A_i)\) — Probabilidad Previa:</strong> Es la probabilidad de un evento posible antes de cualquier otra información.</li>
                <li><strong>\(P(B \mid A_i)\) — Probabilidad Condicional:</strong> Es la probabilidad de que \(B\) ocurra en cada posible suceso de \(A_i\).</li>
                <li><strong>\(P(B \mid A_i) \cdot P(A_i)\) — Probabilidad Conjunta:</strong> La probabilidad de \((A_i \cap B)\) determinada por la regla general de la multiplicación.</li>
                <li><strong>\(P(A_i \mid B)\) — Probabilidad Posterior:</strong> Combina la información provista en la distribución previa con la que se ofrece a través de las probabilidades condicionales para obtener una probabilidad condicional final.</li>
            </ul>
        </div>
    </div>

    <!-- Tarjeta 3: Ejemplo 1 completo de tus apuntes -->
    <div class="card">
        <h3>Ejemplo 1: Riesgos Crediticios (Gerente de Crédito)</h3>
        <p>
            Un gerente de crédito trata con 3 tipos de riesgos crediticios con sus clientes: las personas que
            pagan a tiempo (\(72.3\%\)), las que pagan tarde o morosos (\(18.8\%\)) y las que no pagan (\(8.9\%\)).
            Por experiencia, sabe que el \(82.4\%\) del primer grupo son dueños de sus casas, el \(53.6\%\) de los
            que pagan tarde son dueños de sus casas y el \(17.4\%\) de los que no pagan también son propietarios.
            Calcular la probabilidad de que un nuevo solicitante, <strong>si es dueño de su casa (\(D\))</strong>:
            <strong>a)</strong> Pague a tiempo, <strong>b)</strong> Pague tarde, <strong>c)</strong> No pague, y
            <strong>d)</strong> Elabore la tabla de probabilidades.
        </p>

        <h4>Definiciones y datos (convertidos a decimales)</h4>
        <ul>
            <li>\(P_1\): Pagan a tiempo \(\rightarrow P(P_1) = 0.723 \quad | \quad P(D \mid P_1) = 0.824\)</li>
            <li>\(P_2\): Morosos (pagan tarde) \(\rightarrow P(P_2) = 0.188 \quad | \quad P(D \mid P_2) = 0.536\)</li>
            <li>\(P_3\): No pagan \(\rightarrow P(P_3) = 0.089 \quad | \quad P(D \mid P_3) = 0.174\)</li>
            <li>\(D\): Dueños de sus casas \(\quad | \quad D'\): No son dueños</li>
        </ul>

        <div class="formula-box">
            <h4>a) Probabilidad de que un nuevo solicitante pague a tiempo: \(P(P_1 \mid D)\)</h4>
            <div class="math-expression">
                \[P(P_1 \mid D) = \frac{0.824 \times 0.723}{0.824 \times 0.723 + 0.536 \times 0.188 + 0.174 \times 0.089} = \frac{0.596}{0.712} = 0.837 = 83.7\%\]
            </div>
        </div>

        <div class="formula-box">
            <h4>b) Probabilidad de que pague tarde: \(P(P_2 \mid D)\)</h4>
            <div class="math-expression">
                \[P(P_2 \mid D) = \frac{0.536 \times 0.188}{0.712} = \frac{0.101}{0.712} = 0.142 = 14.2\%\]
            </div>
        </div>

        <div class="formula-box">
            <h4>c) Probabilidad de que no pague: \(P(P_3 \mid D)\)</h4>
            <div class="math-expression">
                \[P(P_3 \mid D) = \frac{0.174 \times 0.089}{0.712} = \frac{0.015}{0.712} = 0.021 = 2.1\%\]
            </div>
        </div>

        <h4>d) Tabla de Probabilidades de Bayes</h4>
        <div style="overflow-x: auto;">
            <table class="data-table" style="width: 100%; border-collapse: collapse; text-align: center; margin-top: 0.75rem;">
                <thead>
                    <tr>
                        <th>Evento (\(P_i\))</th>
                        <th>Prob. Previa \(P(P_i)\)</th>
                        <th>Prob. Condicional \(P(D \mid P_i)\)</th>
                        <th>Prob. Conjunta \(P(P_i \cap D)\)</th>
                        <th>Prob. Posterior \(P(P_i \mid D)\)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>\(P_1\) (A tiempo)</td>
                        <td>0.723</td>
                        <td>0.824</td>
                        <td>0.596</td>
                        <td>0.837 (83.7%)</td>
                    </tr>
                    <tr>
                        <td>\(P_2\) (Tarde)</td>
                        <td>0.188</td>
                        <td>0.536</td>
                        <td>0.101</td>
                        <td>0.142 (14.2%)</td>
                    </tr>
                    <tr>
                        <td>\(P_3\) (No pagan)</td>
                        <td>0.089</td>
                        <td>0.174</td>
                        <td>0.015</td>
                        <td>0.021 (2.1%)</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>1.000</strong></td>
                        <td>—</td>
                        <td><strong>\(P(D) = 0.712\)</strong></td>
                        <td><strong>1.000 (100%)</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ZONA PRÁCTICA -->
<div id="practica" class="tab-content">
    <div class="card practice-card">
        <h3>Calcular probabilidad posterior (Teorema de Bayes)</h3>
        <p class="section-description">
            Elige si deseas evaluar 2 hipótesis complementarias (A y Aᶜ) o múltiples eventos (A₁, A₂, ..., Aₖ) separados por comas.
        </p>

        <form id="form-bayes" data-action="u2_bayes" data-endpoint="../../Controllers/controlador_u2.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="modo_bayes">Tipo de problema</label>
                    <select id="modo_bayes" name="modo">
                        <option value="binario" selected>2 hipótesis complementarias: A y Aᶜ</option>
                        <option value="multiple">Múltiples hipótesis: A₁, A₂, ..., Aₖ</option>
                    </select>
                </div>

                <!-- CAMPOS MODO BINARIO (2 HIPÓTESIS) -->
                <div class="form-group" id="grupo-nombre-a">
                    <label for="nombre_a">Nombre de la hipótesis A</label>
                    <input type="text" id="nombre_a" name="nombre_a" value="enfermedad" placeholder="Ej: enfermedad">
                </div>
                <div class="form-group" id="grupo-nombre-no-a">
                    <label for="nombre_no_a">Nombre del complemento Aᶜ</label>
                    <input type="text" id="nombre_no_a" name="nombre_no_a" value="sano" placeholder="Ej: sano">
                </div>
                <div class="form-group" id="grupo-p-a">
                    <label for="p_a">P(A) previa</label>
                    <input type="number" id="p_a" name="p_a" value="0.01" min="0" max="1" step="0.0001">
                </div>
                <div class="form-group" id="grupo-p-b-a">
                    <label for="p_b_dado_a">P(B | A)</label>
                    <input type="number" id="p_b_dado_a" name="p_b_dado_a" value="0.95" min="0" max="1" step="0.0001">
                </div>
                <div class="form-group" id="grupo-p-b-no-a">
                    <label for="p_b_dado_no_a">P(B | Aᶜ)</label>
                    <input type="number" id="p_b_dado_no_a" name="p_b_dado_no_a" value="0.05" min="0" max="1" step="0.0001">
                </div>

                <!-- CAMPOS MODO MÚLTIPLE (k HIPÓTESIS) -->
                <div class="form-group" id="grupo-nombres-multi" hidden>
                    <label for="nombres">Nombres de los eventos (separados por coma)</label>
                    <input type="text" id="nombres" name="nombres" value="P1 (A tiempo), P2 (Morosos), P3 (No pagan)">
                </div>
                <div class="form-group" id="grupo-previas-multi" hidden>
                    <label for="previas">Probabilidades previas P(Aᵢ) (suman 1)</label>
                    <input type="text" id="previas" name="previas" value="0.723, 0.188, 0.089">
                </div>
                <div class="form-group" id="grupo-condicionales-multi" hidden>
                    <label for="condicionales">Probabilidades condicionales P(B | Aᵢ)</label>
                    <input type="text" id="condicionales" name="condicionales" value="0.824, 0.536, 0.174">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit">Aplicar teorema de Bayes</button>
                <button type="button" class="btn-secondary" data-ejemplo="morosos">Ejemplo Morosos (Cuaderno)</button>
                <button type="button" class="btn-secondary" data-ejemplo="bayes">Ejemplo Clásico (2 hipótesis)</button>
                <button type="button" class="btn-ghost" data-limpiar>Limpiar</button>
            </div>
        </form>
    </div>

    <div id="resultado-bayes" class="practice-results" hidden aria-live="polite"></div>
</div>

<script>
    (function () {
        var modo = document.getElementById('modo_bayes');
        var camposBinario = [
            document.getElementById('grupo-nombre-a'),
            document.getElementById('grupo-nombre-no-a'),
            document.getElementById('grupo-p-a'),
            document.getElementById('grupo-p-b-a'),
            document.getElementById('grupo-p-b-no-a')
        ];
        var camposMultiple = [
            document.getElementById('grupo-nombres-multi'),
            document.getElementById('grupo-previas-multi'),
            document.getElementById('grupo-condicionales-multi')
        ];

        function actualizarVista() {
            var esMultiple = modo.value === 'multiple';
            camposBinario.forEach(function (el) { el.hidden = esMultiple; });
            camposMultiple.forEach(function (el) { el.hidden = !esMultiple; });
        }

        modo.addEventListener('change', actualizarVista);
        actualizarVista();

        Practica.ejemplos.morosos = {
            modo: 'multiple',
            nombres: 'P1 (A tiempo), P2 (Morosos), P3 (No pagan)',
            previas: '0.723, 0.188, 0.089',
            condicionales: '0.824, 0.536, 0.174'
        };

        Practica.ejemplos.bayes = {
            modo: 'binario',
            nombre_a: 'enfermedad',
            nombre_no_a: 'sano',
            p_a: '0.01',
            p_b_dado_a: '0.95',
            p_b_dado_no_a: '0.05'
        };

        document.querySelectorAll('[data-ejemplo]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                setTimeout(actualizarVista, 0);
            });
        });

        Practica.conectar('form-bayes', 'resultado-bayes');
    })();
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
