<?php
/**
 * Proyecto: Calculadora One Milion
 * Ubicación: Controllers/controlador_u1.php
 * Descripción: Recibe las peticiones AJAX de la Unidad 1, valida la acción,
 *              ejecuta scripts/procesador_u1.py y devuelve JSON uniforme.
 */

header('Content-Type: application/json; charset=utf-8');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método de acceso no permitido.']);
    exit;
}

$action = trim((string)($_POST['action'] ?? ''));
$script = realpath(__DIR__ . '/../scripts/procesador_u1.py');

if ($script === false || !is_file($script)) {
    echo json_encode([
        'ok' => false,
        'error' => 'No se encontró el motor scripts/procesador_u1.py.',
    ]);
    exit;
}

function campo(string $nombre, string $defecto = ''): string
{
    return trim((string)($_POST[$nombre] ?? $defecto));
}

$params = [];

switch ($action) {
    case 'u1_tabla_frecuencia':
        $params = [
            'datos' => campo('datos'),
            'clases' => campo('clases'),
            'modo' => campo('modo', 'auto'),
        ];
        break;

    case 'u1_tendencia_central':
        $params = [
            'tipo_datos'  => campo('tipo_datos', 'no_agrupados'),
            'datos'       => campo('datos'),
            'intervalos'  => campo('intervalos'),
            'frecuencias' => campo('frecuencias'),
        ];
        break;


    case 'u1_dispersion':
        $params = [
            'tipo_datos'  => campo('tipo_datos', 'no_agrupados'),
            'datos'       => campo('datos'),
            'intervalos'  => campo('intervalos'),
            'frecuencias' => campo('frecuencias'),
        ];
        break;


    case 'u1_posicion':
        $params = [
            'tipo_datos'  => campo('tipo_datos', 'no_agrupados'),
            'medida'      => campo('medida', 'Q'),
            'k'           => campo('k', '1'),
            'datos'       => campo('datos'),
            'intervalos'  => campo('intervalos'),
            'frecuencias' => campo('frecuencias'),
        ];
        break;


        case 'u1_graficos':
        $params = [
            'tipo_grafico' => campo('tipo_grafico', 'histograma'),
            'titulo_graf'  => campo('titulo_graf'),
            'etiquetas'    => campo('etiquetas'),
            'frecuencias'  => campo('frecuencias'),
            'limites'      => campo('limites'),
        ];
        break;


    default:
        echo json_encode([
            'ok' => false,
            'error' => "La acción '{$action}' no es reconocida por el controlador de la Unidad 1.",
        ]);
        exit;
}

$payload = json_encode(['action' => $action, 'params' => $params]);
if ($payload === false) {
    echo json_encode(['ok' => false, 'error' => 'No se pudo preparar la petición al motor Python.']);
    exit;
}

$payload_b64 = base64_encode($payload);

$python = getenv('PYTHON_BIN');
if ($python === false || $python === '') {
    $python = DIRECTORY_SEPARATOR === '\\' ? 'python' : 'python3';
}

$command = escapeshellarg($python)
    . ' ' . escapeshellarg($script)
    . ' ' . escapeshellarg($payload_b64)
    . ' 2>&1';

$output = shell_exec($command);

if ($output === null) {
    echo json_encode([
        'ok' => false,
        'error' => 'La función shell_exec() no está disponible o el motor Python no respondió.',
    ]);
    exit;
}

$output = trim($output);
if ($output === '') {
    echo json_encode([
        'ok' => false,
        'error' => 'El motor Python no devolvió ninguna respuesta. Verifica que Python y sus dependencias estén instalados.',
    ]);
    exit;
}

$lineas = preg_split('/\r\n|\r|\n/', $output);
$data = null;
foreach (array_reverse($lineas) as $linea) {
    $linea = trim($linea);
    if ($linea !== '' && $linea[0] === '{') {
        $decodificado = json_decode($linea, true);
        if (is_array($decodificado)) {
            $data = $decodificado;
            break;
        }
    }
}

if ($data === null) {
    $detalle = substr($output, 0, 600);
    echo json_encode([
        'ok' => false,
        'error' => 'El motor Python devolvió una respuesta inválida: ' . $detalle,
    ]);
    exit;
}

echo json_encode($data);
