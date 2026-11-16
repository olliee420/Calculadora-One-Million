<?php
$titulo_pagina = 'Ayuda';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Guía de usuario y preguntas frecuentes de Calculadora One Milion.">
    <title>Ayuda — Calculadora One Milion</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
<div class="layout-container">
    <?php include_once __DIR__ . '/menu.php'; ?>

    <main class="main-content">
        <h1>Centro de Ayuda y Guía de Uso</h1>
        <p class="section-description">
            Aprende a sacar el máximo provecho a cada módulo de la calculadora y consulta el formato correcto para ingresar tus datos.
        </p>

        <div class="theory-grid">
            <!-- TARJETA 1: Flujo de Trabajo -->
            <div class="card">
                <h3>¿Cómo utilizar cada módulo?</h3>
                <ul>
                    <li><strong>1. Selecciona el tema:</strong> Usa el menú superior o lateral para navegar entre la Unidad 1, Unidad 2 y Unidad 3.</li>
                    <li><strong>2. Revisa la Zona Teórica:</strong> Consulta las fórmulas, condiciones de aplicación y ejemplos resueltos antes de calcular.</li>
                    <li><strong>3. Pasa a la Zona Práctica:</strong> Introduce los datos de tu ejercicio y presiona el botón principal de cálculo.</li>
                    <li><strong>4. Usa "Cargar ejemplo":</strong> Si tienes dudas sobre el formato de entrada, pulsa este botón para rellenar el formulario con un ejercicio real de clase.</li>
                </ul>
            </div>

            <!-- TARJETA 2: Reglas de Formato de Datos -->
            <div class="card">
                <h3>Formato Correcto de Entradas</h3>
                <ul>
                    <li><strong>Decimales:</strong> Utiliza el punto decimal (ejemplo: <code>0.15</code>, <code>2.5</code>, <code>1.96</code>).</li>
                    <li><strong>Listas de datos o frecuencias:</strong> Separa cada valor con una coma (ejemplo: <code>1, 4, 9, 6, 2, 3</code> o <code>Bueno, Regular, Malo</code>).</li>
                    <li><strong>Intervalos de clase:</strong> Escribe el límite inferior y superior unidos por guion y separados por comas (ejemplo: <code>0-3, 3-6, 6-9</code>).</li>
                    <li><strong>Probabilidades (p, q):</strong> Deben ser valores entre <code>0</code> y <code>1</code> (por ejemplo, 15% se escribe como <code>0.15</code>).</li>
                </ul>
            </div>

            <!-- TARJETA 3: Preguntas Frecuentes -->
            <div class="card">
                <h3>Preguntas Frecuentes</h3>
                <p>
                    <strong>¿Qué hago si no conozco λ en Poisson?</strong><br>
                    En el módulo de <em>Distribución de Poisson</em> cambia el selector superior a <strong>Regla de tres</strong> (eventos en un intervalo) o <strong>Aproximación Binomial (n · p)</strong> y el sistema calculará λ por ti.
                </p>
                <p>
                    <strong>¿Dónde calculo áreas con la tabla Z?</strong><br>
                    Dentro de <em>La Curva Normal</em> selecciona el modo <strong>Área bajo la Curva</strong> (con datos reales o Z directo) para obtener áreas entre dos valores, colas y cantidad esperada de individuos.
                </p>
                <p>
                    <strong>¿Por qué las frecuencias teóricas se ajustan en 1 unidad?</strong><br>
                    En el ajuste de curva normal y muestreo estratificado, el motor aplica un redondeo convencional para garantizar que la suma final cierre exactamente en el total <strong>n</strong>.
                </p>
            </div>
        </div>
    </main>
</div>
</body>
</html>