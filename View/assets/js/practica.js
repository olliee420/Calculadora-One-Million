/* ==========================================================================
   Calculadora One Milion - Zona práctica compartida (AJAX)
   ========================================================================== */
(function () {
    'use strict';

    var ejemplos = {};

    function escapeHtml(valor) {
        return String(valor === null || valor === undefined ? '' : valor).replace(
            /[&<>"']/g,
            function (caracter) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                }[caracter];
            }
        );
    }


    function obtenerDecimalesConfig() {
        var guardado = parseInt(localStorage.getItem('om_decimales') || '4', 10);
        if (guardado >= 1 && guardado <= 4) {
            return guardado;
        }
        return 4;
    }


    function ajustarDecimalesTexto(texto) {
        var dec = obtenerDecimalesConfig();
        return String(texto).replace(/-?\d+\.\d+/g, function (coincidencia) {
            var num = parseFloat(coincidencia);
            if (!Number.isFinite(num)) return coincidencia;
            return Number(num.toFixed(dec)).toString();
        });
    }

    function formatearNumero(valor, formato) {
        if (valor === null || valor === undefined || valor === '') {
            return '—';
        }
        var dec = obtenerDecimalesConfig();
        if (formato === 'texto') {
            return escapeHtml(ajustarDecimalesTexto(valor));
        }
        var numero = Number(valor);
        if (!Number.isFinite(numero)) {
            return escapeHtml(ajustarDecimalesTexto(valor));
        }
        if (formato === 'porcentaje') {
            return (
                (numero * 100).toLocaleString('es-ES', { maximumFractionDigits: dec }) + '%'
            );
        }
        if (formato === 'entero') {
            return numero.toLocaleString('es-ES', { maximumFractionDigits: 0 });
        }
        return numero.toLocaleString('es-ES', { maximumFractionDigits: dec });
    }


    function renderResultado(resultado) {
        var principal = resultado.resultado_principal || {};
        var valor = formatearNumero(principal.valor, principal.formato);
        var html = '';

        html += '<div class="card resultado-card">';
        html += '<h3>' + escapeHtml(resultado.titulo || 'Resultado') + '</h3>';
        html += '<div class="resultado-hero">';
        html += '<span class="resultado-etiqueta">' + escapeHtml(principal.etiqueta || '') + '</span>';
        html += '<strong class="resultado-valor">' + valor + '</strong>';
        html += '</div>';

        if (resultado.metricas && resultado.metricas.length) {
            html += '<div class="metric-grid">';
            resultado.metricas.forEach(function (metrica) {
                html += '<div class="metric-card">';
                html += '<span class="metric-label">' + escapeHtml(metrica.etiqueta) + '</span>';
                html += '<span class="metric-value">' + escapeHtml(metrica.valor) + '</span>';
                if (metrica.detalle) {
                    html += '<span class="metric-detail">' + escapeHtml(metrica.detalle) + '</span>';
                }
                html += '</div>';
            });
            html += '</div>';
        }

        if (resultado.interpretacion) {
            html += '<div class="interpretation-box"><strong>Interpretación:</strong> ';
            html += escapeHtml(resultado.interpretacion) + '</div>';
        }

        if (resultado.pasos && resultado.pasos.length) {
            html += '<h4 class="result-subtitle">Procedimiento</h4>';
            html += '<ul class="steps-list">';
            resultado.pasos.forEach(function (paso) {
                html += '<li>' + escapeHtml(paso) + '</li>';
            });
            html += '</ul>';
        }

        if (resultado.tabla && resultado.tabla.columnas && resultado.tabla.filas) {
            html += '<h4 class="result-subtitle">Tabla de resultados</h4>';
            html += '<div class="table-container"><table class="result-table"><thead><tr>';
            resultado.tabla.columnas.forEach(function (columna) {
                html += '<th>' + escapeHtml(columna) + '</th>';
            });
            html += '</tr></thead><tbody>';
            resultado.tabla.filas.forEach(function (fila) {
                html += '<tr>';
                fila.forEach(function (celda) {
                    html += '<td>' + escapeHtml(celda) + '</td>';
                });
                html += '</tr>';
            });
            html += '</tbody></table></div>';
        }

        if (resultado.graficos && resultado.graficos.length) {
            resultado.graficos.forEach(function (graf) {
                if (!graf.url) return;
                html += '<div class="chart-card">';
                html += '<h4 class="result-subtitle">' + escapeHtml(graf.titulo || 'Visualización') + '</h4>';
                html += '<img src="' + escapeHtml(graf.url) + '?v=' + Date.now() + '" ';
                html += 'alt="' + escapeHtml(graf.titulo || 'Gráfico del resultado estadístico') + '" class="chart-img">';
                html += '</div>';
            });
        } else if (resultado.grafico_url) {
            html += '<div class="chart-card">';
            html += '<h4 class="result-subtitle">Visualización</h4>';
            html += '<img src="' + escapeHtml(resultado.grafico_url) + '?v=' + Date.now() + '" ';
            html += 'alt="Gráfico del resultado estadístico" class="chart-img">';
            html += '</div>';
        }


        if (resultado.notas && resultado.notas.length) {
            html += '<ul class="notas-list">';
            resultado.notas.forEach(function (nota) {
                html += '<li>' + escapeHtml(nota) + '</li>';
            });
            html += '</ul>';
        }

        html += '</div>';
        return html;
    }

    function errorHtml(mensaje) {
        return '<div class="error-box"><strong>No se pudo calcular:</strong> ' + escapeHtml(mensaje) + '</div>';
    }

    async function enviarFormulario(form) {
        var endpoint = form.getAttribute('data-endpoint') || 'controlador_u2.php';
        var action = form.getAttribute('data-action') || '';
        if (!action) {
            throw new Error('El formulario no tiene una acción configurada.');
        }

        var datos = new FormData(form);
        datos.set('action', action);

        var boton = form.querySelector('button[type="submit"]');
        var textoOriginal = boton ? boton.innerHTML : '';
        if (boton) {
            boton.disabled = true;
            boton.innerHTML = 'Calculando…';
        }

        try {
            var respuesta = await fetch(endpoint, {
                method: 'POST',
                body: datos,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            var texto = await respuesta.text();
            var json;
            try {
                json = JSON.parse(texto);
            } catch (error) {
                throw new Error('El servidor devolvió una respuesta no válida.');
            }

            if (!json.ok) {
                throw new Error(json.error || 'No se pudo procesar el cálculo.');
            }
            return json.resultado;
        } finally {
            if (boton) {
                boton.disabled = false;
                boton.innerHTML = textoOriginal;
            }
        }
    }

    function conectar(formId, resultadoId) {
        var form = document.getElementById(formId);
        var contenedor = document.getElementById(resultadoId);
        if (!form || !contenedor) {
            return;
        }

        form.setAttribute('data-resultado', resultadoId);

        form.addEventListener('submit', async function (evento) {
            evento.preventDefault();
            contenedor.hidden = false;
            contenedor.innerHTML = '<div class="card loading-card">Calculando resultado…</div>';

            try {
                var resultado = await enviarFormulario(form);
                contenedor.innerHTML = renderResultado(resultado);
                contenedor.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } catch (error) {
                contenedor.innerHTML = errorHtml(error.message || 'Error desconocido.');
            }
        });
    }

    function rellenarEjemplo(boton) {
        var form = boton.closest('form');
        var datos = ejemplos[boton.getAttribute('data-ejemplo')];
        if (!form || !datos) {
            return;
        }

        Object.keys(datos).forEach(function (nombre) {
            var campo = form.elements.namedItem(nombre);
            if (!campo) {
                return;
            }
            if (campo.type === 'checkbox') {
                campo.checked = Boolean(datos[nombre]);
            } else {
                campo.value = datos[nombre];
            }
            campo.dispatchEvent(new Event('change', { bubbles: true }));
        });
    }

    function limpiarFormulario(boton) {
        var form = boton.closest('form');
        if (!form) {
            return;
        }
        form.reset();

        var resultadoId = form.getAttribute('data-resultado');
        var contenedor = resultadoId ? document.getElementById(resultadoId) : null;
        if (contenedor) {
            contenedor.hidden = true;
            contenedor.innerHTML = '';
        }

        form.querySelectorAll('input, select, textarea').forEach(function (campo) {
            campo.dispatchEvent(new Event('change', { bubbles: true }));
        });
    }

    document.addEventListener('click', function (evento) {
        var botonEjemplo = evento.target.closest('[data-ejemplo]');
        if (botonEjemplo) {
            rellenarEjemplo(botonEjemplo);
            return;
        }

        var botonLimpiar = evento.target.closest('[data-limpiar]');
        if (botonLimpiar) {
            limpiarFormulario(botonLimpiar);
        }
    });

    window.Practica = {
        ejemplos: ejemplos,
        conectar: conectar,
        enviarFormulario: enviarFormulario,
        renderResultado: renderResultado,
        errorHtml: errorHtml,
        escapeHtml: escapeHtml
    };
})();
