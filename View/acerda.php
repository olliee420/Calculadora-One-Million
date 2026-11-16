<?php
$titulo_pagina = 'Acerca de';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Información general y arquitectura técnica de Calculadora One Milion.">
    <title>Acerca de — Calculadora One Milion</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
<div class="layout-container">
    <?php include_once __DIR__ . '/menu.php'; ?>

    <main class="main-content">
        <h1>Acerca de Calculadora One Milion</h1>
        <p class="section-description">
            Plataforma educativa interactiva diseñada para resolver, analizar y graficar ejercicios de Estadística Descriptiva, Análisis de Probabilidad y Distribuciones de Probabilidad.
        </p>

        <div class="theory-grid">
            <!-- TARJETA 1: Propósito del Proyecto -->
            <div class="card">
                <h3>Propósito Académico</h3>
                <p>
                    <strong>Calculadora One Milion</strong> nace como una herramienta de apoyo para estudiantes y docentes, combinando fundamentos teóricos claros con motores de cálculo paso a paso basados en los contenidos reales de clase.
                </p>
                <ul>
                    <li><strong>Teoría estructurada:</strong> Fórmulas claras, definición de variables y ejemplos resueltos de cuaderno.</li>
                    <li><strong>Práctica verificable:</strong> Procedimiento detallado, métricas clave, tablas de distribución y gráficas dinámicas.</li>
                    <li><strong>Enfoque didáctico:</strong> Interpretación automática de cada resultado para facilitar la comprensión estadística.</li>
                </ul>
            </div>

            <!-- TARJETA 2: Contenido por Unidades -->
            <div class="card">
                <h3>Módulos y Unidades Cubiertas</h3>
                <ul>
                    <li><strong>Unidad 1 — Estadística Descriptiva:</strong> Tablas de frecuencias, medidas de tendencia central, dispersión y análisis exploratorio.</li>
                    <li><strong>Unidad 2 — Análisis de Probabilidad:</strong> Probabilidad clásica, reglas de suma y multiplicación, probabilidad condicional, Teorema de Bayes, permutaciones y combinaciones.</li>
                    <li><strong>Unidad 3 — Distribuciones y Muestreo:</strong> Variables discretas y continuas, distribuciones Binomial, Poisson, Normal Estándar, Ajuste de la Curva Normal y Tamaño de Muestra.</li>
                </ul>
            </div>

            <!-- TARJETA 3: Arquitectura Tecnológica -->
            <div class="card">
                <h3>Arquitectura Tecnológica</h3>
                <p>
                    El sistema opera mediante una arquitectura modular desacoplada que garantiza precisión matemática y rapidez visual:
                </p>
                <ul>
                    <li><strong>Interfaz Web (HTML5, CSS3, JavaScript):</strong> Navegación por pestañas (Zona Teórica / Zona Práctica) y renderizado asíncrono sin recargar la página.</li>
                    <li><strong>Controladores PHP:</strong> Validación de entradas y comunicación segura mediante carga útil JSON/Base64.</li>
                    <li><strong>Motores Matemáticos en Python:</strong> Procesamiento numérico exacto y generación automática de gráficos estadísticos con <em>Matplotlib</em>.</li>
                </ul>
            </div>

            <!-- TARJETA 4: Información del Desarrollador -->
            <div class="card">
                <h3>Desarrollador del Proyecto</h3>
                <p>
                    Este sistema fue diseñado, programado e integrado como proyecto académico para facilitar el aprendizaje práctico de la estadística aplicada y el análisis probabilístico.
                </p>
                <ul>
                    <li><strong>Autor:</strong> Fabián Alexis Aguilar Vasquez</li>
                    <li><strong>Carrera / Especialidad:</strong> Tecnico en Ingeneria de Desarrollo de Software</li>
                    <li><strong>Institución:</strong> ITCA Fepade Santa Ana</li>
                    <li><strong>Asignatura / Cátedra:</strong> Desarrollo del pensamiento estadístico y probabilístico aplicado al Software — [Año 2do/ Ciclo 2, 2026]</li>
                    <li><strong>Contacto / Repositorio:</strong> </li>
                </ul>
            </div>
        </div>
    </main>
</div>
</body>
</html>