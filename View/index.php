<?php
$titulo_pagina = 'Inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Calculadora One Milion: Plataforma interactiva de estadística descriptiva, análisis de probabilidad y distribuciones.">
    <title>Inicio — Calculadora One Million</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <style>
        /* Estilos encapsulados exclusivos para el portal de inicio */
        .hero-carousel {
            position: relative;
            background: linear-gradient(135deg, #0f172a 0%, #162238 60%, #0d2b36 100%);
            border: 1px solid rgba(0, 217, 255, 0.25);
            border-radius: 16px;
            padding: 2.5rem 2.2rem;
            margin-bottom: 2rem;
            overflow: hidden;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
        }

        .carousel-slides {
            position: relative;
            min-height: 210px;
        }

        .carousel-slide {
            display: none;
            animation: fadeSlide 0.45s ease;
        }

        .carousel-slide.active {
            display: block;
        }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .slide-badge {
            display: inline-block;
            background: rgba(0, 255, 170, 0.12);
            color: #00ffaa;
            border: 1px solid rgba(0, 255, 170, 0.35);
            padding: 0.3rem 0.85rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.4px;
            margin-bottom: 0.9rem;
        }

        .carousel-slide h2 {
            font-size: 1.85rem;
            color: #f8fafc;
            margin: 0 0 0.75rem 0;
            line-height: 1.25;
        }

        .carousel-slide p {
            color: #cbd5e1;
            font-size: 1.02rem;
            max-width: 720px;
            line-height: 1.6;
            margin: 0 0 1.4rem 0;
        }

        .slide-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.85rem;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #00ffaa, #00d9ff);
            color: #090d16;
            font-weight: 700;
            padding: 0.72rem 1.4rem;
            border-radius: 10px;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 255, 170, 0.3);
        }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(15, 23, 42, 0.75);
            color: #e2e8f0;
            border: 1px solid rgba(148, 163, 184, 0.35);
            font-weight: 600;
            padding: 0.72rem 1.3rem;
            border-radius: 10px;
            text-decoration: none;
            transition: border-color 0.2s ease, background 0.2s ease;
        }

        .btn-hero-secondary:hover {
            border-color: #00d9ff;
            background: rgba(0, 217, 255, 0.1);
        }

        .carousel-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(148, 163, 184, 0.15);
        }

        .carousel-dots {
            display: flex;
            gap: 0.55rem;
        }

        .carousel-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            border: none;
            background: rgba(148, 163, 184, 0.35);
            cursor: pointer;
            padding: 0;
            transition: all 0.25s ease;
        }

        .carousel-dot.active {
            width: 28px;
            border-radius: 999px;
            background: #00ffaa;
        }

        .carousel-arrows {
            display: flex;
            gap: 0.5rem;
        }

        .carousel-arrow {
            background: rgba(15, 23, 42, 0.8);
            color: #f1f5f9;
            border: 1px solid rgba(148, 163, 184, 0.3);
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.2s ease, color 0.2s ease;
        }

        .carousel-arrow:hover {
            border-color: #00d9ff;
            color: #00d9ff;
        }

        /* Franja de métricas destacadas del sistema */
        .stats-banner {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-pill {
            background: #0f172a;
            border: 1px solid rgba(51, 65, 85, 0.8);
            border-radius: 12px;
            padding: 1.1rem 1.25rem;
            text-align: center;
        }

        .stat-pill strong {
            display: block;
            font-size: 1.65rem;
            color: #00d9ff;
            margin-bottom: 0.2rem;
        }

        .stat-pill span {
            color: #94a3b8;
            font-size: 0.88rem;
        }

        /* Tarjetas de unidades con enlace directo */
        .unit-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.22s ease, border-color 0.22s ease;
        }

        .unit-card:hover {
            transform: translateY(-4px);
            border-color: rgba(0, 217, 255, 0.45);
        }

        .unit-tag {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #00ffaa;
            margin-bottom: 0.4rem;
            display: block;
        }

        .unit-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 1.1rem;
            color: #00d9ff;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.94rem;
        }

        .unit-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .hero-carousel { padding: 1.6rem 1.3rem; }
            .carousel-slide h2 { font-size: 1.4rem; }
        }
    </style>
</head>
<body>
<div class="layout-container">
    <?php include_once __DIR__ . '/menu.php'; ?>

    <main class="main-content">
        <!-- CARRUSEL PRINCIPAL DE BIENVENIDA -->
        <section class="hero-carousel" aria-label="Presentación de Calculadora One Milion">
            <div class="carousel-slides">
                <!-- Slide 1 -->
                <article class="carousel-slide active">
                    <span class="slide-badge">🚀 Plataforma Estadística Interactiva</span>
                    <h2>Bienvenido a Calculadora One Million</h2>
                    <p>
                        Domina la Estadística Descriptiva, el Análisis de Probabilidad y las Distribuciones de Probabilidad en un solo lugar. Cada módulo combina teoría clara de clase con cálculos paso a paso y gráficas generadas al instante.
                    </p>
                    <div class="slide-actions">
                        <a href="Unidad_1/TablaFrecuencia.php" class="btn-hero-primary">📊 Empezar a explorar</a>
                        <a href="ayuda.php" class="btn-hero-secondary">❓ Cómo funciona</a>
                    </div>
                </article>

                <!-- Slide 2 -->
                <article class="carousel-slide">
                    <span class="slide-badge">📈 Motor Matemático con Python</span>
                    <h2>Procedimientos detallados y gráficas automáticas</h2>
                    <p>
                        No te quedes solo con el resultado final. Visualiza fórmulas sustituidas, tablas de distribución, métricas clave, interpretaciones automáticas y gráficos listos para analizar tus ejercicios.
                    </p>
                    <div class="slide-actions">
                        <a href="Unidad_3/DistribucionBinomial.php" class="btn-hero-primary">🎲 Probar Distribuciones</a>
                        <a href="Unidad_2/TeoremaBayes.php" class="btn-hero-secondary">🧠 Ver Probabilidad</a>
                    </div>
                </article>

                <!-- Slide 3 -->
                <article class="carousel-slide">
                    <span class="slide-badge">⚡ Ejemplos Precargados de Clase</span>
                    <h2>Aprende practicando con un solo clic</h2>
                    <p>
                        ¿No sabes qué formato usar? Cada calculadora incluye ejemplos reales listos para cargar, validar tus apuntes de cuaderno y experimentar con diferentes escenarios estadísticos.
                    </p>
                    <div class="slide-actions">
                        <a href="Unidad_3/AjusteCurvaNormal.php" class="btn-hero-primary">📉 Explorar Curva Normal</a>
                        <a href="acerca.php" class="btn-hero-secondary">ℹ️ Acerca del sistema</a>
                    </div>
                </article>
            </div>

            <div class="carousel-controls">
                <div class="carousel-dots" role="tablist" aria-label="Seleccionar diapositiva">
                    <button type="button" class="carousel-dot active" data-slide="0" aria-label="Diapositiva 1"></button>
                    <button type="button" class="carousel-dot" data-slide="1" aria-label="Diapositiva 2"></button>
                    <button type="button" class="carousel-dot" data-slide="2" aria-label="Diapositiva 3"></button>
                </div>
                <div class="carousel-arrows">
                    <button type="button" class="carousel-arrow" id="prev-slide" aria-label="Anterior">&#10094;</button>
                    <button type="button" class="carousel-arrow" id="next-slide" aria-label="Siguiente">&#10095;</button>
                </div>
            </div>
        </section>

        <section class="stats-banner" aria-label="Resumen del sistema">
            <div class="stat-pill">
                <strong>3 Unidades</strong>
                <span>Programa académico completo</span>
            </div>
            <div class="stat-pill">
                <strong>17 Módulos</strong>
                <span>Calculadoras especializadas</span>
            </div>
            <div class="stat-pill">
                <strong>Paso a Paso</strong>
                <span>Fórmulas e interpretación</span>
            </div>
            <div class="stat-pill">
                <strong>Gráficos HD</strong>
                <span>Generados con Matplotlib</span>
            </div>
        </section>

        <h2>Explora por Unidad Temática</h2>
        <p class="section-description">
            Selecciona cualquiera de las tres unidades para revisar su fundamento teórico y resolver ejercicios prácticos.
        </p>

        <div class="theory-grid">
            <div class="card unit-card">
                <div>
                    <span class="unit-tag">Unidad 1</span>
                    <h3>Estadística Descriptiva</h3>
                    <p>
                        Organiza y resume conjuntos de datos mediante tablas de frecuencias agrupadas, medidas de tendencia central, posición, dispersión y gráficos estadísticos.
                    </p>
                </div>
                <a href="Unidad_1/TablaFrecuencia.php" class="unit-link">Ir a Tablas de Frecuencia &rarr;</a>
            </div>

            <div class="card unit-card">
                <div>
                    <span class="unit-tag">Unidad 2</span>
                    <h3>Análisis de Probabilidad</h3>
                    <p>
                        Calcula probabilidades clásicas, reglas de suma y multiplicación, probabilidad condicional, Teorema de Bayes y técnicas de conteo (permutaciones y combinaciones).
                    </p>
                </div>
                <a href="Unidad_2/ProbabilidadClasica.php" class="unit-link">Ir a Probabilidad Clásica &rarr;</a>
            </div>

            <div class="card unit-card">
                <div>
                    <span class="unit-tag">Unidad 3</span>
                    <h3>Distribuciones y Muestreo</h3>
                    <p>
                        Clasifica variables aleatorias, modela distribuciones Binomial, Poisson y Normal Estándar, ajusta curvas normales y calcula tamaños de muestra.
                    </p>
                </div>
                <a href="Unidad_3/VariablesDiscretasContinuas.php" class="unit-link">Ir a Variables Aleatorias &rarr;</a>
            </div>
        </div>

        <h2 style="margin-top: 2rem;">¿Por qué usar Calculadora One Milion?</h2>
        <div class="theory-grid">
            <div class="card">
                <h3>📚 Teoría y Práctica Integradas</h3>
                <p>
                    Cada pantalla divide el aprendizaje en una <strong>Zona Teórica</strong> con definiciones y fórmulas claras, y una <strong>Zona Práctica</strong> interactiva sin recargas de página.
                </p>
            </div>
            <div class="card">
                <h3>🔍 Transparencia en cada Cálculo</h3>
                <p>
                    Observa el desglose completo de variables intermedias, tablas de frecuencias esperadas y reglas aplicadas para verificar tus procedimientos manualmente.
                </p>
            </div>
            <div class="card">
                <h3>💡 Listo para Experimentar</h3>
                <p>
                    Utiliza el botón <strong>Cargar ejemplo</strong> en cualquier módulo para probar casos reales de clase al instante o limpia los campos para ingresar tus propios datos.
                </p>
            </div>
        </div>



</main>
</div>

<script>
    (function () {
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');
        const btnPrev = document.getElementById('prev-slide');
        const btnNext = document.getElementById('next-slide');
        let current = 0;
        let timer = null;

        function showSlide(index) {
            current = (index + slides.length) % slides.length;
            slides.forEach((s, i) => s.classList.toggle('active', i === current));
            dots.forEach((d, i) => d.classList.toggle('active', i === current));
        }

        function resetTimer() {
            clearInterval(timer);
            timer = setInterval(() => showSlide(current + 1), 6000);
        }

        btnPrev.addEventListener('click', () => { showSlide(current - 1); resetTimer(); });
        btnNext.addEventListener('click', () => { showSlide(current + 1); resetTimer(); });
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                showSlide(parseInt(dot.getAttribute('data-slide'), 10));
                resetTimer();
            });
        });

        resetTimer();
    })();
</script>
</body>
</html>