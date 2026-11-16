<?php
/**
 * Menú lateral compartido.
 * Calcula la URL pública de la carpeta View para funcionar tanto si el proyecto
 * se sirve desde la raíz del servidor como desde una subcarpeta (por ejemplo,
 * htdocs/Calculadora One Milion).
 */
if (!isset($view_url)) {
    $view_url = '/View';
    $doc_root = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
    $view_fs = realpath(__DIR__);

    if ($doc_root !== false && $view_fs !== false) {
        $doc_root_normal = str_replace('\\', '/', $doc_root);
        $view_fs_normal = str_replace('\\', '/', $view_fs);

        if (strncasecmp($view_fs_normal, $doc_root_normal, strlen($doc_root_normal)) === 0) {
            $view_url = substr($view_fs_normal, strlen($doc_root_normal));
        }
    }

    $view_url = rtrim(str_replace('\\', '/', $view_url), '/');
}

$menu_url = static function (string $ruta) use ($view_url): string {
    $url = ($view_url === '' ? '' : $view_url) . '/' . ltrim($ruta, '/');
    return htmlspecialchars(str_replace(' ', '%20', $url), ENT_QUOTES, 'UTF-8');
};
?>
<link rel="stylesheet" href="<?php echo $menu_url('menu.css'); ?>">

<nav class="sidebar-menu">
    <div class="menu-section">
        <h3>📊 Calculadora One Milion</h3>
        <ul>
            <li><a href="<?php echo $menu_url('index.php'); ?>" class="menu-link">🏠 Inicio</a></li>
            <li><a href="<?php echo $menu_url('configuracion.php'); ?>" class="menu-link">⚙️ Configuración</a></li>
            <li><a href="<?php echo $menu_url('ayuda.php'); ?>" class="menu-link">❓ Ayuda</a></li>
            <li><a href="<?php echo $menu_url('acerda.php'); ?>" class="menu-link">ℹ️ Acerca de nosotros</a></li>
        </ul>
    </div>



    <!-- UNIDAD 1 -->
    <div class="menu-section">
        <h4 class="unidad-title">📂 Unidad 1: Estadística Descriptiva</h4>
        <ul>
            <li>
                <a href="<?php echo $menu_url('Unidad_1/TablaFrecuencia.php'); ?>" class="menu-link">
                    ⏱️ Tablas de Frecuencia
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_1/Graficos.php'); ?>" class="menu-link">
                    📊 Gráficos
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_1/TendenciaCentral.php'); ?>" class="menu-link">
                    📈 Tendencia Central
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_1/MedidasPosicion.php'); ?>" class="menu-link">
                    🎯 Medidas de Posición
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_1/MedidasDispersion.php'); ?>" class="menu-link">
                    📉 Medidas de Dispersión
                </a>
            </li>
        </ul>
    </div>

    <!-- UNIDAD 2 -->
    <div class="menu-section">
        <h4 class="unidad-title">📂 Unidad 2: Análisis de Probabilidad</h4>
        <ul>
            <li>
                <a href="<?php echo $menu_url('Unidad_2/SumaMultiplicacion.php'); ?>" class="menu-link">
                    🔀 Suma y Multiplicación
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_2/Permutaciones.php'); ?>" class="menu-link">
                    🔢 Permutaciones
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_2/Combinaciones.php'); ?>" class="menu-link">
                    🎯 Combinaciones
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_2/ProbabilidadClasica.php'); ?>" class="menu-link">
                    🎯 Probabilidad Clásica
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_2/TeoremaBayes.php'); ?>" class="menu-link">
                    🧠 Teorema de Bayes
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_2/ProbabilidadCondicional.php'); ?>" class="menu-link">
                    🎯 Probabilidad Condicional
                </a>
            </li>
        </ul>
    </div>

    <!-- UNIDAD 3 -->
    <div class="menu-section">
        <h4 class="unidad-title">📂 Unidad 3: Distribuciones de Probabilidad</h4>
        <ul>
            <li>
                <a href="<?php echo $menu_url('Unidad_3/VariablesDiscretasContinuas.php'); ?>" class="menu-link">
                    ⏱️ Variables Aleatorias discretas y continuas
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_3/DistribucionBinomial.php'); ?>" class="menu-link">
                    📈 Distribución Binomial
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_3/DistribucionPoisson.php'); ?>" class="menu-link">
                    🎯 Distribución Poisson
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_3/DistribucionNormal.php'); ?>" class="menu-link">
                    📉 Distribución Normal Estándar
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_3/AjusteCurvaNormal.php'); ?>" class="menu-link">
                    📉 La Curva Normal
                </a>
            </li>
            <li>
                <a href="<?php echo $menu_url('Unidad_3/MuestreoYTamanoMuestra.php'); ?>" class="menu-link">
                    📉 Muestreo y Tamaño de Muestra
                </a>
            </li>
        </ul>
    </div>
</nav>
<script>
    (function () {
        var tema = localStorage.getItem('om_tema') || 'oscuro';
        if (tema !== 'oscuro') {
            document.documentElement.setAttribute('data-tema', tema);
        }
    })();
</script>

