<?php
require_once __DIR__ . '/../routes/routes.php';


if(isset($_GET['page']) && in_array($_GET['page'], array_keys($routes), true)){
    $controller = $routes($_GET['page']);
} else {
    $controller = $_GET['home'];
}
?>