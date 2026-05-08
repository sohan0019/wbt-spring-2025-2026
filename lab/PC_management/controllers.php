<?php
// ================================================================
// CONTROLLERS - request handling + role-based logic
// ================================================================

/* ============== Login ============== */
function loginCtrl($conn)
{
    $error = '';
    $prefill = $_COOKIE['remember_user'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        if ($u === '' || $p === '') {
            $error = 'Please fill in both fields.';
        } else {
            // Try admin first
            $admin = authAdmin($conn, $u, $p);
            if ($admin) {
                $_SESSION['user'] = [
                    'id' => $admin['id'],
                    'username' => $admin['username'],
                    'name' => 'Administrator',
                    'role' => 'admin'
                ];
                if ($remember) setcookie('remember_user', $u, time() + 86400 * 30, '/');
                else setcookie('remember_user', '', time() - 3600, '/');
                header('Location: index.php?page=admin');
                exit;
            }
            // Then manager
            $lib = authManager($conn, $u, $p);
            if ($lib) {
                $_SESSION['user'] = [
                    'id' => $lib['id'],
                    'username' => $lib['username'],
                    'name' => $lib['name'],
                    'role' => 'manager'
                ];
                if ($remember) setcookie('remember_user', $u, time() + 86400 * 30, '/');
                else setcookie('remember_user', '', time() - 3600, '/');
                header('Location: index.php?page=manager');
                exit;
            }
            $error = 'Invalid username or password.';
        }
    }

    require 'views/login.php';
}

/* ============== Register (manager self-registration) ============== */
function registerCtrl($conn)
{
    $error = $success = '';
    $old = ['name' => '', 'contact' => '', 'username' => ''];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';
        $old = compact('name', 'contact', 'username');

        if ($name === '' || $contact === '' || $username === '' || $password === '') {
            $error = 'All fields are required.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif ($password !== $confirm) {
            $error = 'Passwords do not match.';
        } elseif (managerUsernameExists($conn, $username)) {
            $error = 'Username is already taken.';
        } else {
            if (addManager($conn, $name, $contact, $username, $password)) {
                $success = 'Account created! You can now log in.';
                $old = ['name' => '', 'contact' => '', 'username' => ''];
            } else {
                $error = 'Registration failed. Try again.';
            }
        }
    }

    require 'views/register.php';
}

/* ============== Admin Dashboard (manages managers) ============== */
function adminCtrl($conn)
{
    $action = $_GET['action'] ?? 'list';
    $error = '';
    $editing = null;  // when set, view shows Edit form instead of Add form

    /* --- Add (POST) --- */
    if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '' || $contact === '' || $username === '' || $password === '') {
            $error = 'All fields are required.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } elseif (managerUsernameExists($conn, $username)) {
            $error = 'Username is already taken.';
        } else {
            if (addManager($conn, $name, $contact, $username, $password)) {
                header('Location: index.php?page=admin&msg=added');
                exit;
            }
            $error = 'Failed to add manager.';
        }
    }

    /* --- Update (POST) --- */
    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id       = intval($_GET['id'] ?? 0);
        $name     = trim($_POST['name'] ?? '');
        $contact  = trim($_POST['contact'] ?? '');
        $username = trim($_POST['username'] ?? '');

        // ===== NULL VALIDATION on UPDATE =====
        if ($name === '' || $contact === '' || $username === '') {
            $error = 'No field can be empty (NULL). All fields are required.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        } elseif (managerUsernameExists($conn, $username, $id)) {
            $error = 'That username is used by another manager.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        } else {
            if (updateManager($conn, $id, $name, $contact, $username)) {
                header('Location: index.php?page=admin&msg=updated');
                exit;
            }
            $error = 'Update failed.';
            $editing = ['id' => $id, 'name' => $name, 'contact' => $contact, 'username' => $username];
        }
    }

    /* --- Show edit form (GET) --- */
    if ($action === 'edit' && !$editing) {
        $id = intval($_GET['id'] ?? 0);
        $editing = getManager($conn, $id);
    }

    /* --- Delete (GET) --- */
    if ($action === 'delete') {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) deleteManager($conn, $id);
        header('Location: index.php?page=admin&msg=deleted');
        exit;
    }

    $managers = getmanagers($conn);
    require 'views/admin.php';
}

/* ============== manager Dashboard (manages components) ============== */
function managerCtrl($conn)
{
    $action = $_GET['action'] ?? 'list';
    $error = '';
    $editing = null;

    /* --- Add (POST) --- */
    if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $title    = trim($_POST['title'] ?? '');
        $brand   = trim($_POST['brand'] ?? '');
        $quantity = trim($_POST['quantity'] ?? '');
        $price    = trim($_POST['price'] ?? '');

        if ($title === '' || $brand === '' || $quantity === '' || $price === '') {
            $error = 'All fields are required.';
        } elseif (!ctype_digit($quantity) || intval($quantity) < 0) {
            $error = 'Quantity must be a non-negative whole number.';
        } elseif (!is_numeric($price) || floatval($price) < 0) {
            $error = 'Price must be a non-negative number.';
        } else {
            $libId = $_SESSION['user']['id'];
            if (addComponent($conn, $title, $brand, intval($quantity), floatval($price), $libId)) {
                header('Location: index.php?page=manager&msg=added');
                exit;
            }
            $error = 'Failed to add book.';
        }
    }

    /* --- Update (POST) --- */
    if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id       = intval($_GET['id'] ?? 0);
        $title    = trim($_POST['title'] ?? '');
        $brand   = trim($_POST['brand'] ?? '');
        $quantity = trim($_POST['quantity'] ?? '');
        $price    = trim($_POST['price'] ?? '');

        // ===== NULL VALIDATION on UPDATE =====
        if ($title === '' || $brand === '' || $quantity === '' || $price === '') {
            $error = 'No field can be empty (NULL). All fields are required.';
            $editing = [
                'id' => $id,
                'title' => $title,
                'brand' => $brand,
                'quantity' => $quantity,
                'price' => $price
            ];
        } elseif (!ctype_digit($quantity) || intval($quantity) < 0) {
            $error = 'Quantity must be a non-negative whole number.';
            $editing = [
                'id' => $id,
                'title' => $title,
                'brand' => $brand,
                'quantity' => $quantity,
                'price' => $price
            ];
        } elseif (!is_numeric($price) || floatval($price) < 0) {
            $error = 'Price must be a non-negative number.';
            $editing = [
                'id' => $id,
                'title' => $title,
                'brand' => $brand,
                'quantity' => $quantity,
                'price' => $price
            ];
        } else {
            if (updateComponent($conn, $id, $title, $brand, intval($quantity), floatval($price))) {
                header('Location: index.php?page=manager&msg=updated');
                exit;
            }
            $error = 'Update failed.';
            $editing = [
                'id' => $id,
                'title' => $title,
                'brand' => $brand,
                'quantity' => $quantity,
                'price' => $price
            ];
        }
    }

    /* --- Show edit form --- */
    if ($action === 'edit' && !$editing) {
        $id = intval($_GET['id'] ?? 0);
        $editing = getComponent($conn, $id);
    }

    /* --- Delete --- */
    if ($action === 'delete') {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) deleteComponent($conn, $id);
        header('Location: index.php?page=manager&msg=deleted');
        exit;
    }

    $components = getComponents($conn);
    require 'views/manager.php';
}
