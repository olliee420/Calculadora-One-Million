<?php
$titulo_pagina = $titulo_pagina ?? 'Calculadora One Milion';
$descripcion_pagina = $descripcion_pagina ?? 'Calculadora estadística y de probabilidad.';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($descripcion_pagina, ENT_QUOTES, 'UTF-8'); ?>">
    <title><?php echo htmlspecialchars($titulo_pagina, ENT_QUOTES, 'UTF-8'); ?> | Calculadora One Milion</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['\\(', '\\)'], ['$', '$']],
                displayMath: [['\\[', '\\]'], ['$$', '$$']]
            },
            svg: { fontCache: 'global' }
        };
    </script>
    <script defer src="https://cloudflare.com"></script>
    <script src="../assets/js/tabs.js"></script>
    <script src="../assets/js/practica.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            function fraccionHtml(num, den) {
                return '<span style="display:inline-flex;flex-direction:column;vertical-align:middle;text-align:center;margin:0 5px;font-size:0.92em;">' +
                    '<span style="border-bottom:1px solid currentColor;padding:0 5px;">' + num + '</span>' +
                    '<span style="padding:0 5px;">' + den + '</span>' +
                '</span>';
            }

            function convertirLatex(expr) {
                var s = expr.trim();

                // Símbolos y operadores frecuentes
                s = s.replace(/\\bar\{x\}/g, 'x&#772;')
                     .replace(/\\tilde\{X\}/g, 'X&#771;')
                     .replace(/\\hat\{X\}/g, 'X&#770;')
                     .replace(/\\sum/g, '&sum;')
                     .replace(/\\sigma/g, '&sigma;')
                     .replace(/\\Delta/g, '&Delta;')
                     .replace(/\\lambda/g, '&lambda;')
                     .replace(/\\mu/g, '&mu;')
                     .replace(/\\pi/g, '&pi;')
                     .replace(/\\times/g, '&times;')
                     .replace(/\\cdot/g, '&middot;')
                     .replace(/\\approx/g, '&approx;')
                     .replace(/\\geq|\\ge/g, '&ge;')
                     .replace(/\\leq|\\le/g, '&le;')
                     .replace(/\\neq/g, '&ne;')
                     .replace(/\\implies|\\Rightarrow/g, '&rArr;')
                     .replace(/\\rightarrow|\\to/g, '&rarr;')
                     .replace(/\\dots|\\ldots/g, '&hellip;')
                     .replace(/\\lvert/g, '|')
                     .replace(/\\rvert/g, '|')
                     .replace(/\\circ/g, '&deg;')
                     .replace(/\\quad|\\;|\\,/g, ' ')
                     .replace(/\\left\[/g, '[')
                     .replace(/\\right\]/g, ']')
                     .replace(/\\left\(/g, '(')
                     .replace(/\\right\)/g, ')')
                     .replace(/\\mathbf\{([^{}]+)\}/g, '<strong>$1</strong>')
                     .replace(/\\text\{([^{}]+)\}/g, '$1')
                     .replace(/\\log_\{10\}/g, 'log<sub>10</sub>')
                     .replace(/\\log/g, 'log');

                // Fracciones anidadas o simples \frac{a}{b}
                for (var pass = 0; pass < 3; pass++) {
                    s = s.replace(/\\frac\{([^{}]+)\}\{([^{}]+)\}/g, function (_, a, b) {
                        return fraccionHtml(a, b);
                    });
                }

                // Raíz cuadrada \sqrt{...}
                s = s.replace(/\\sqrt\{([^{}]+)\}/g, '<span style="white-space:nowrap;">&radic;<span style="border-top:1px solid currentColor;padding:0 3px;">$1</span></span>');

                // Subíndices y superíndices con llaves o de un carácter
                s = s.replace(/_\{([^{}]+)\}/g, '<sub>$1</sub>')
                     .replace(/\^\{([^{}]+)\}/g, '<sup>$1</sup>')
                     .replace(/_([A-Za-z0-9]+)/g, '<sub>$1</sub>')
                     .replace(/\^([A-Za-z0-9]+)/g, '<sup>$1</sup>');

                return s;
            }

            // Procesar bloques de texto en teoría y práctica sin alterar inputs ni scripts
            var contenedores = document.querySelectorAll('.main-content');
            contenedores.forEach(function (contenedor) {
                var walker = document.createTreeWalker(contenedor, NodeFilter.SHOW_TEXT, null, false);
                var nodos = [];
                var nodo;
                while ((nodo = walker.nextNode())) {
                    if (nodo.nodeValue && (nodo.nodeValue.indexOf('\\(') !== -1 || nodo.nodeValue.indexOf('\\[') !== -1)) {
                        var padre = nodo.parentElement ? nodo.parentElement.tagName : '';
                        if (padre !== 'SCRIPT' && padre !== 'STYLE' && padre !== 'TEXTAREA' && padre !== 'INPUT') {
                            nodos.push(nodo);
                        }
                    }
                }

                nodos.forEach(function (n) {
                    var html = n.nodeValue
                        .replace(/\\\[([\s\S]+?)\\\]/g, function (_, eq) {
                            return '<span class="math-block" style="display:inline-block;margin:4px 0;">' + convertirLatex(eq) + '</span>';
                        })
                        .replace(/\\\(([\s\S]+?)\\\)/g, function (_, eq) {
                            return '<span class="math-inline" style="font-weight:500;">' + convertirLatex(eq) + '</span>';
                        });

                    var span = document.createElement('span');
                    span.innerHTML = html;
                    n.parentNode.replaceChild(span, n);
                });
            });
        });
    </script>
</head>

<body>
<div class="layout-container">
    <?php include_once __DIR__ . '/../menu.php'; ?>
    <main class="main-content">
