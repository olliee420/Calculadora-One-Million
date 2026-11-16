<?php
$titulo_pagina = 'Configuración y Utilidades';
$descripcion_pagina = 'Personaliza el tema visual, la precisión decimal y utiliza el generador y organizador de datos crudos.';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo_pagina, ENT_QUOTES, 'UTF-8'); ?> | Calculadora One Milion</title>
    <script>
        (function () {
            var tema = localStorage.getItem('om_tema') || 'oscuro';
            if (tema !== 'oscuro') {
                document.documentElement.setAttribute('data-tema', tema);
            }
        })();
    </script>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <script defer src="https://unpkg.com" onload="lucide.createIcons()"></script>
</head>
<body>
<div class="layout-container">
    <?php include_once __DIR__ . '/menu.php'; ?>
    <main class="main-content">
        <h1>⚙️ Configuración y Herramientas de Datos</h1>

        <div class="theory-grid">
            <!-- TARJETA 1: APARIENCIA Y PRECISIÓN DECIMAL -->
            <div class="card">
                <h3>1. Personalización del Sistema</h3>
                <p class="section-description">
                    Los cambios se guardan automáticamente en tu navegador y aplican a todas las unidades.
                </p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="cfg_tema">Tema visual de la interfaz</label>
                        <select id="cfg_tema">
                            <option value="oscuro">Oscuro Cyber (Verde Neón — Predeterminado)</option>
                            <option value="claro">Claro Profesional (Modo Día / Proyector)</option>
                            <option value="indigo">Índigo Analítico (Morado / Azul)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cfg_decimales">Precisión decimal en resultados</label>
                        <select id="cfg_decimales">
                            <option value="1">1 decimal (ej. 12.3)</option>
                            <option value="2">2 decimales (ej. 12.35)</option>
                            <option value="3">3 decimales (ej. 12.346)</option>
                            <option value="4" selected>4 decimales (ej. 12.3457 — Predeterminado)</option>
                        </select>
                    </div>
                </div>

                <div class="formula-box" style="margin-top: 1rem;">
                    <h4>Vista previa de precisión decimal</h4>
                    <p id="preview_decimales" style="margin: 0; font-size: 1.05rem;">
                        Ejemplo con \(\pi \approx 3.141592\): <strong>3.1416</strong> | Probabilidad: <strong>66.6667%</strong>
                    </p>
                </div>
            </div>

            <!-- TARJETA 2: GENERADOR DE DATOS CRUDOS -->
            <div class="card">
                <h3>2. Generador de Datos Crudos Aleatorios</h3>
                <p class="section-description">
                    Crea series de prueba listas para copiar y pegar en Tablas de Frecuencia, Tendencia Central o Dispersión.
                </p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="gen_n">Cantidad de datos (N)</label>
                        <input type="number" id="gen_n" value="50" min="2" max="500" step="1">
                    </div>
                    <div class="form-group">
                        <label for="gen_min">Valor mínimo</label>
                        <input type="number" id="gen_min" value="100" step="any">
                    </div>
                    <div class="form-group">
                        <label for="gen_max">Valor máximo</label>
                        <input type="number" id="gen_max" value="198" step="any">
                    </div>
                    <div class="form-group">
                        <label for="gen_tipo">Tipo de números</label>
                        <select id="gen_tipo">
                            <option value="enteros" selected>Números enteros</option>
                            <option value="decimales">Números con decimales</option>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label for="gen_dist">Comportamiento de los datos</label>
                        <select id="gen_dist">
                            <option value="uniforme" selected>Uniforme (dispersos equitativamente entre mínimo y máximo)</option>
                            <option value="normal">Concentrados al centro (tipo campana de Gauss)</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" id="btn_generar">Generar serie</button>
                    <button type="button" class="btn-secondary" id="btn_copiar_gen">Copiar lista</button>
                    <button type="button" class="btn-ghost" id="btn_enviar_ordenar">Enviar al organizador ↓</button>
                </div>

                <div class="form-group" style="margin-top: 0.9rem;">
                    <label for="salida_generador">Serie generada (separada por comas)</label>
                    <textarea id="salida_generador" rows="3" readonly placeholder="Haz clic en 'Generar serie'..."></textarea>
                </div>
            </div>
        </div>

        <!-- TARJETA 3: ORGANIZADOR DE DATOS CRUDOS -->
        <div class="card">
            <h3>3. Organizador y Analizador Rápido de Datos Crudos</h3>
            <p class="section-description">
                Pega una lista desordenada de números (separados por comas, espacios o saltos de línea) para obtener el arreglo ordenado y sus estadísticos básicos.
            </p>

            <div class="form-grid">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="entrada_ordenar">Datos crudos desordenados</label>
                    <textarea id="entrada_ordenar" rows="3" placeholder="Ej: 45, 12, 89, 12, 34, 67, 23, 89, 10"></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" id="btn_ordenar">Ordenar y analizar</button>
                <button type="button" class="btn-secondary" id="btn_copiar_asc">Copiar ascendente</button>
                <button type="button" class="btn-secondary" id="btn_copiar_desc">Copiar descendente</button>
                <button type="button" class="btn-ghost" id="btn_limpiar_ord">Limpiar</button>
            </div>

            <div id="panel_resultado_orden" hidden style="margin-top: 1.2rem;">
                <div class="metric-grid" id="metricas_orden" style="margin-bottom: 1rem;"></div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="salida_asc">Arreglo Ascendente (Menor a Mayor)</label>
                        <textarea id="salida_asc" rows="3" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="salida_desc">Arreglo Descendente (Mayor a Menor)</label>
                        <textarea id="salida_desc" rows="3" readonly></textarea>
                    </div>
                </div>

                <div class="formula-box" style="margin-top: 0.8rem;">
                    <h4>Conteo de valores únicos y repeticiones (Frecuencia Simple)</h4>
                    <div id="conteo_unicos" style="font-size: 0.95rem; line-height: 1.6;"></div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    (function () {
        // 1. Preferencias: Tema y Decimales
        var selTema = document.getElementById('cfg_tema');
        var selDec = document.getElementById('cfg_decimales');
        var previewDec = document.getElementById('preview_decimales');

        var temaGuardado = localStorage.getItem('om_tema') || 'oscuro';
        var decGuardado = localStorage.getItem('om_decimales') || '4';

        selTema.value = temaGuardado;
        selDec.value = decGuardado;

        function actualizarPreviewDecimales() {
            var d = parseInt(selDec.value, 10) || 4;
            var piEj = (Math.PI).toFixed(d);
            var pctEj = (200 / 3).toFixed(d) + '%';
            previewDec.innerHTML = 'Ejemplo con π: <strong>' + piEj + '</strong> &nbsp;|&nbsp; Porcentaje (2/3): <strong>' + pctEj + '</strong>';
        }

        selTema.addEventListener('change', function () {
            var nuevoTema = selTema.value;
            localStorage.setItem('om_tema', nuevoTema);
            if (nuevoTema === 'oscuro') {
                document.documentElement.removeAttribute('data-tema');
            } else {
                document.documentElement.setAttribute('data-tema', nuevoTema);
            }
        });

        selDec.addEventListener('change', function () {
            localStorage.setItem('om_decimales', selDec.value);
            actualizarPreviewDecimales();
        });

        actualizarPreviewDecimales();

        // 2. Generador de Datos Crudos
        var salidaGen = document.getElementById('salida_generador');

        function aleatorioNormal(min, max) {
            var u = 0, v = 0;
            while (u === 0) u = Math.random();
            while (v === 0) v = Math.random();
            var z = Math.sqrt(-2.0 * Math.log(u)) * Math.cos(2.0 * Math.PI * v);
            var media = (min + max) / 2;
            var desv = (max - min) / 6;
            var val = media + z * desv;
            return Math.min(max, Math.max(min, val));
        }

        document.getElementById('btn_generar').addEventListener('click', function () {
            var n = Math.min(500, Math.max(2, parseInt(document.getElementById('gen_n').value, 10) || 20));
            var min = parseFloat(document.getElementById('gen_min').value);
            var max = parseFloat(document.getElementById('gen_max').value);
            var tipo = document.getElementById('gen_tipo').value;
            var dist = document.getElementById('gen_dist').value;
            var dec = parseInt(selDec.value, 10) || 2;

            if (!Number.isFinite(min) || !Number.isFinite(max) || max <= min) {
                alert('El valor máximo debe ser mayor que el valor mínimo.');
                return;
            }

            var lista = [];
            for (var i = 0; i < n; i++) {
                var raw = dist === 'normal'
                    ? aleatorioNormal(min, max)
                    : min + Math.random() * (max - min);
                if (tipo === 'enteros') {
                    lista.push(Math.round(raw));
                } else {
                    lista.push(Number(raw.toFixed(dec)));
                }
            }
            salidaGen.value = lista.join(', ');
        });

        function copiarTexto(texto, boton) {
            if (!texto) return;
            navigator.clipboard.writeText(texto).then(function () {
                var orig = boton.textContent;
                boton.textContent = '¡Copiado!';
                setTimeout(function () { boton.textContent = orig; }, 1400);
            });
        }

        document.getElementById('btn_copiar_gen').addEventListener('click', function () {
            copiarTexto(salidaGen.value, this);
        });

        document.getElementById('btn_enviar_ordenar').addEventListener('click', function () {
            if (!salidaGen.value) return;
            document.getElementById('entrada_ordenar').value = salidaGen.value;
            document.getElementById('btn_ordenar').click();
        });

        // 3. Organizador de Datos Crudos
        document.getElementById('btn_ordenar').addEventListener('click', function () {
            var raw = document.getElementById('entrada_ordenar').value;
            var nums = raw.split(/[\s,;]+/).map(Number).filter(function (x) {
                return raw.trim() !== '' && Number.isFinite(x);
            });

            if (nums.length < 2) {
                alert('Ingresa al menos 2 números válidos para organizar.');
                return;
            }

            var asc = nums.slice().sort(function (a, b) { return a - b; });
            var desc = asc.slice().reverse();
            var menor = asc[0];
            var mayor = asc[asc.length - 1];
            var rango = Number((mayor - menor).toFixed(6));

            document.getElementById('salida_asc').value = asc.join(', ');
            document.getElementById('salida_desc').value = desc.join(', ');

            document.getElementById('metricas_orden').innerHTML =
                '<div class="metric-card"><span class="metric-label">Total datos (N)</span><span class="metric-value">' + nums.length + '</span></div>' +
                '<div class="metric-card"><span class="metric-label">Dato menor</span><span class="metric-value">' + menor + '</span></div>' +
                '<div class="metric-card"><span class="metric-label">Dato mayor</span><span class="metric-value">' + mayor + '</span></div>' +
                '<div class="metric-card"><span class="metric-label">Rango (R)</span><span class="metric-value">' + rango + '</span></div>';

            var conteos = {};
            asc.forEach(function (v) { conteos[v] = (conteos[v] || 0) + 1; });
            var badges = Object.keys(conteos).sort(function (a, b) { return Number(a) - Number(b); }).map(function (k) {
                return '<strong>' + k + '</strong> (f=' + conteos[k] + ')';
            });
            document.getElementById('conteo_unicos').innerHTML = badges.join(' &nbsp;•&nbsp; ');
            document.getElementById('panel_resultado_orden').hidden = false;
        });

        document.getElementById('btn_copiar_asc').addEventListener('click', function () {
            copiarTexto(document.getElementById('salida_asc').value, this);
        });

        document.getElementById('btn_copiar_desc').addEventListener('click', function () {
            copiarTexto(document.getElementById('salida_desc').value, this);
        });

        document.getElementById('btn_limpiar_ord').addEventListener('click', function () {
            document.getElementById('entrada_ordenar').value = '';
            document.getElementById('panel_resultado_orden').hidden = true;
        });
    })();
</script>
</body>
</html>
