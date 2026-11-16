<?php
/**
 * Proyecto: Calculadora One Milion
 * Ubicación: View/Unidad_2/controlador_u2.php
 * Descripción: Recibe las peticiones AJAX de la Unidad 2, valida la acción,
 *              ejecuta scripts/procesador_u2.py y devuelve JSON uniforme.
 */

header('Content-Type: application/json; charset=utf-8');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método de acceso no permitido.']);
    exit;
}

$action = trim((string)($_POST['action'] ?? ''));
$script = realpath(__DIR__ . '/../scripts/procesador_u2.py');

if ($script === false || !is_file($script)) {
    echo json_encode([
        'ok' => false,
        'error' => 'No se encontró el motor scripts/procesador_u2.py.',
    ]);
    exit;
}

function campo(string $nombre, string $defecto = ''): string
{
    return trim((string)($_POST[$nombre] ?? $defecto));
}

$params = [];

switch ($action) {
    case 'u2_clasica':
        $params = [
            'evento' => campo('evento'),
            'favorables' => campo('favorables'),
            'posibles' => campo('posibles'),
        ];
        break;

        case 'u2_suma_multiplicacion':
        $params = [
            'modo' => campo('modo', 'multiplicacion'),
            'm' => campo('m'),
            'n' => campo('n'),
            'casilleros' => campo('casilleros'),
        ];
        break;

    case 'u2_bayes':
        $params = [
            'modo' => campo('modo', 'binario'),
            'p_a' => campo('p_a'),
            'p_b_dado_a' => campo('p_b_dado_a'),
            'p_b_dado_no_a' => campo('p_b_dado_no_a'),
            'nombre_a' => campo('nombre_a', 'A'),
            'nombre_no_a' => campo('nombre_no_a', 'Aᶜ'),
            'nombres' => campo('nombres'),
            'previas' => campo('previas'),
            'condicionales' => campo('condicionales'),
        ];
        break;

    case 'u2_variable_aleatoria':
        $params = [
            'valores' => campo('valores'),
            'probabilidades' => campo('probabilidades'),
            'x_consulta' => campo('x_consulta'),
        ];
        break;

    case 'u2_permutaciones':
        $params = [
            'variante' => campo('variante', 'sin_repeticion'),
            'n' => campo('n'),
            'r' => campo('r'),
            'grupos' => campo('grupos'),
        ];
        break;

    case 'u2_combinaciones':
        $params = [
            'variante' => campo('variante', 'sin_repeticion'),
            'n' => campo('n'),
            'r' => campo('r'),
        ];
        break;
    case 'u2_probabilidad_condicional':
     $params = [
         'modo' => campo('modo', 'tabla'),
         'direccion' => campo('direccion', 'b_dado_a'),
         'p_interseccion' => campo('p_interseccion'),
         'p_condicion' => campo('p_condicion'),
         'p_ab' => campo('p_ab'),
         'p_ab_comp' => campo('p_ab_comp'),
         'p_a_comp_b' => campo('p_a_comp_b'),
         'p_a_comp_b_comp' => campo('p_a_comp_b_comp'),
     ];
     break;

        

    default:
        echo json_encode([
            'ok' => false,
            'error' => "La acción '{$action}' no es reconocida por el controlador de la Unidad 2.",
        ]);
        exit;
}

$payload = json_encode(['action' => $action, 'params' => $params]);
if ($payload === false) {
    echo json_encode(['ok' => false, 'error' => 'No se pudo preparar la petición al motor Python.']);
    exit;
}

// Se codifica en base64 para evitar problemas de comillas y acentos en Windows.
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

// El JSON puede venir acompañado de advertencias de matplotlib en otras líneas.
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
