<?php
// ================================================================
// FRONT CONTROLLER (router)
// Handles routing, AJAX search endpoint, logout, role checks.
// ================================================================
session_start();

require 'config.php';
require 'models.php';
require 'controllers.php';

$page = $_GET['page'] ?? 'login';

/* ------------- Logout ------------- */
if ($page === 'logout') {
    $_SESSION = [];
    session_destroy();
    setcookie('remember_user', '', time() - 3600, '/');
    header('Location: index.php?page=login');
    exit;
}

/* ------------- AJAX search endpoint -------------
   Called by inline JS in dashboards.
   ?page=ajax&type=manager&q=...   (admin only)
   ?page=ajax&type=book&q=...        (manager only)
*/
if ($page === 'ajax') {
    header('Content-Type: application/json');
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    $type = $_GET['type'] ?? '';
    $q    = trim($_GET['q'] ?? '');

    if ($type === 'manager' && $_SESSION['user']['role'] === 'admin') {
        echo json_encode($q === '' ? getmanagers($conn) : searchmanagers($conn, $q));
    } elseif ($type === 'component' && $_SESSION['user']['role'] === 'manager') {
        echo json_encode($q === '' ? getComponents($conn) : searchComponents($conn, $q));
    } else {
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden']);
    }
    exit;
}

/* ------------- Auth gates ------------- */
$publicPages = ['login', 'register', 'ajax']; // Add ajax here to prevent redirect loops on api calls

// 1. If user is logged in and tries to access login/register, send them to their dashboard
if (in_array($page, $publicPages) && isset($_SESSION['user']) && $page !== 'ajax') {
    header('Location: index.php?page=' . $_SESSION['user']['role']);
    exit;
}

// 2. If user is NOT logged in and tries to access a protected page
if (!in_array($page, $publicPages) && !isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// 3. Role Protection: Ensure admins stay in admin and managers stay in manager
if (isset($_SESSION['user'])) {
    if ($page === 'admin' && $_SESSION['user']['role'] !== 'admin') {
        header('Location: index.php?page=manager');
        exit;
    }
    if ($page === 'manager' && $_SESSION['user']['role'] !== 'manager') {
        header('Location: index.php?page=admin');
        exit;
    }
}

/* ------------- Dispatch ------------- */
switch ($page) {
    case 'login':
        loginCtrl($conn);
        break;
    case 'register':
        registerCtrl($conn);
        break;
    case 'admin':
        adminCtrl($conn);
        break;
    case 'manager':
        managerCtrl($conn);
        break;
    default:
        header('Location: index.php?page=login');
        exit;
}

mysqli_close($conn);
