<?php
/**
 * Proyecto: Calculadora One Milion
 * Ubicación: Controllers/controlador_u3.php
 * Descripción: Controlador intermedio encargado de validar los POST de la Unidad 3,
 *              invocar de forma segura al script de Python y retornar las respuestas en JSON.
 */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método de acceso no permitido.']);
    exit;
}

$action = isset($_POST['action']) ? $_POST['action'] : '';
$python_script = __DIR__ . '/../scripts/procesador_u3.py';
$args = [];

switch ($action) {
    // 📊 Acción 1: Clasificación de Variables (VariablesDiscretasContinuas.php)
    case 'u3_variable_aleatoria':
        $payload = [
            'action' => 'u3_variable_aleatoria',
            'params' => [
                'datos'           => $_POST['datos'] ?? '',
                'nombre_variable' => $_POST['nombre_variable'] ?? '',
                'tiene_orden'     => $_POST['tiene_orden'] ?? 'auto',
            ],
        ];
        $b64 = base64_encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
        $args = [escapeshellarg($b64)];
        break;

    // 🎲 Acción 2: Distribución Binomial (DistribucionBinomial.php)
    case 'u3_binomial':
        $payload = [
            'action' => 'u3_binomial',
            'params' => [
                'n' => $_POST['n'] ?? '0',
                'p' => $_POST['p'] ?? '0',
                'x' => $_POST['x'] ?? '0',
            ],
        ];
        $b64 = base64_encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
        $args = [escapeshellarg($b64)];
        break;

    // ⏱️ Acción 3: Distribución de Poisson (DistribucionPoisson.php)
    case 'u3_poisson':
        $payload = [
            'action' => 'u3_poisson',
            'params' => [
                'modo_lambda'        => $_POST['modo_lambda'] ?? 'directo',
                'lam'                => $_POST['lam'] ?? '0',
                'eventos_base'       => $_POST['eventos_base'] ?? '0',
                'intervalo_base'     => $_POST['intervalo_base'] ?? '0',
                'intervalo_objetivo' => $_POST['intervalo_objetivo'] ?? '0',
                'n_binom'            => $_POST['n_binom'] ?? '0',
                'p_binom'            => $_POST['p_binom'] ?? '0',
                'x'                  => $_POST['x'] ?? '0',
            ],
        ];
        $b64 = base64_encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
        $args = [escapeshellarg($b64)];
        break;

    // 📈 Acción 4: Distribución Normal Estándar (DistribucionNormal.php)
    case 'u3_normal':
        $payload = [
            'action' => 'u3_normal',
            'params' => [
                'media'      => $_POST['media'] ?? '0',
                'desviacion' => $_POST['desviacion'] ?? '1',
                'valor_x'    => $_POST['valor_x'] ?? '0',
            ],
        ];
        $b64 = base64_encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
        $args = [escapeshellarg($b64)];
        break;

    // 🛠️ Acción 5: Ajuste de la Curva Normal y Áreas Z (AjusteCurvaNormal.php)
    case 'ajuste_normal':
        $payload = [
            'action' => 'u3_ajuste_normal',
            'params' => [
                'modo_curva'  => $_POST['modo_curva'] ?? 'ajuste',
                'intervalos'  => $_POST['intervalos'] ?? '',
                'frecuencias' => $_POST['frecuencias'] ?? '',
                'tipo_area'   => $_POST['tipo_area'] ?? 'entre',
                'media_curva' => $_POST['media_curva'] ?? '0',
                'desv_curva'  => $_POST['desv_curva'] ?? '1',
                'val_1'       => $_POST['val_1'] ?? '0',
                'val_2'       => $_POST['val_2'] ?? '0',
                'poblacion_n' => $_POST['poblacion_n'] ?? '',
            ],
        ];
        $b64 = base64_encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
        $args = [escapeshellarg($b64)];
        break;

    // 📏 Acción 6: Tamaño de la Muestra y Muestreo Estratificado (MuestreoYTamanoMuestra.php)
    case 'tamano_muestra':
        $payload = [
            'action' => 'u3_tamano_muestra',
            'params' => [
                'modo_muestreo'    => $_POST['modo_muestreo'] ?? 'proporcion',
                'tipo_poblacion'   => $_POST['tipo_poblacion'] ?? 'infinita',
                'poblacion_N'      => $_POST['poblacion_N'] ?? '0',
                'confianza'        => $_POST['confianza'] ?? '0.95',
                'error_m'          => $_POST['error_m'] ?? '0.05',
                'p'                => $_POST['p'] ?? '0.5',
                'q'                => $_POST['q'] ?? '0.5',
                'sigma_muestra'    => $_POST['sigma_muestra'] ?? '1',
                'estratos_nombres' => $_POST['estratos_nombres'] ?? '',
                'estratos_tamanos' => $_POST['estratos_tamanos'] ?? '',
                'muestra_total_n'  => $_POST['muestra_total_n'] ?? '0',
            ],
        ];
        $b64 = base64_encode(json_encode($payload, JSON_UNESCAPED_UNICODE));
        $args = [escapeshellarg($b64)];
        break;

    default:
        echo json_encode(['error' => "La acción estructural '{$action}' no es reconocida por el controlador de la Unidad 3."]);
        exit;
}

if (!file_exists($python_script)) {
    echo json_encode(['error' => 'El script de Python no fue localizado en la ruta esperada.']);
    exit;
}

$python = getenv('PYTHON_BIN');
if ($python === false || $python === '') {
    $python = DIRECTORY_SEPARATOR === '\\' ? 'python' : 'python3';
}
$command = escapeshellarg($python) . " " . escapeshellarg($python_script) . " " . implode(" ", $args);
$output = shell_exec($command);

if ($output === null) {
    echo json_encode([
        'error' => 'Error crítico del sistema: La consola del servidor no devolvió respuesta desde Python.'
    ]);
} else {
    echo $output;
}
