<?php
// rutas de conexion a la BD y autenticacion JWT
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../helpers/jwtHandler.php";
require_once __DIR__ . "/../middlewares/jwtMiddleware.php";

// rutas de los Controlladores
require_once __DIR__ . "/../controllers/AuthController.php";
require_once __DIR__ . "/../controllers/ProveedorController.php";
require_once __DIR__ . "/../controllers/ProductoController.php";
require_once __DIR__ . "/../controllers/RecepcionController.php";

$database = new Database();
$db = $database->getConnection();

// Simple router using 'action' query parameter
$action = $_GET['action'] ?? '';
// Allow OPTIONS for CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

switch($action) {
    //case de peticiones para autenticacion
    case 'login':
        (new AuthController($db))->login();
        break;
    case 'registrar_user':
        (new AuthController($db))->registrar_user();
        break;

    //case de peticiones para proveedores
    case 'listar_proveedores':
        verificarToken($db);
        (new ProveedorController($db))->listar();
        break;
    case 'registrar_proveedor':
        verificarToken($db);
        (new ProveedorController($db))->registrar();
        break;
    case 'actualizar_proveedor':
        verificarToken($db);
        (new ProveedorController($db))->actualizar();
        break;
    case 'eliminar_proveedor':
        verificarToken($db);
        (new ProveedorController($db))->eliminar();
        break;

    //case de peticiones para productos
    case 'listar_productos':
        verificarToken($db); 
        (new ProductoController($db))->listar();
        break;
    case 'registrar_producto':
        verificarToken($db);
        (new ProductoController($db))->registrar();
        break;
    case 'actualizar_producto':
        verificarToken($db);
        (new ProductoController($db))->actualizar();
        break;
    case 'eliminar_producto':
        verificarToken($db);
        (new ProductoController($db))->eliminar();
        break;

    //case de peticiones para recepciones
    case 'listar_recepciones':
        verificarToken($db);
        (new RecepcionController($db))->listar();
        break;
    case 'registrar_recepcion':
        verificarToken($db);
        (new RecepcionController($db))->registrar();
        break;
        case 'actualizar_recepcion':
        verificarToken($db);
        (new RecepcionController($db))->actualizar();
        break;
    case 'eliminar_recepcion':
        verificarToken($db);
        (new RecepcionController($db))->eliminar();
        break;

    //default case 
    default:
        echo json_encode(['message' => 'Acción inválida']);
        break;
}
