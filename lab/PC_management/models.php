<?php
// ================================================================
// MODELS - All DB access using procedural mysqli + prepared stmts
// ================================================================

/* ------------------- Admin ------------------- */
function authAdmin($conn, $username, $password)
{
    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM admins WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return ($row && password_verify($password, $row['password'])) ? $row : false;
}

/* ----------------- Manager ----------------- */
function getmanagers($conn)
{
    $r = mysqli_query($conn, "SELECT id, name, contact, username FROM managers ORDER BY id DESC");
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

function getManager($conn, $id)
{
    $stmt = mysqli_prepare($conn, "SELECT id, name, contact, username FROM managers WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function addManager($conn, $name, $contact, $username, $password)
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO managers (name, contact, username, password) VALUES (?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $contact, $username, $hash);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateManager($conn, $id, $name, $contact, $username)
{
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE managers SET name = ?, contact = ?, username = ? WHERE id = ?"
    );
    mysqli_stmt_bind_param($stmt, 'sssi', $name, $contact, $username, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function deleteManager($conn, $id)
{
    $stmt = mysqli_prepare($conn, "DELETE FROM managers WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function searchmanagers($conn, $term)
{
    $like = '%' . $term . '%';
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, name, contact, username FROM managers
         WHERE name LIKE ? OR username LIKE ? OR contact LIKE ?
         ORDER BY id DESC"
    );
    mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}

function authManager($conn, $username, $password)
{
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, name, username, password FROM managers WHERE username = ?"
    );
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return ($row && password_verify($password, $row['password'])) ? $row : false;
}

function managerUsernameExists($conn, $username, $excludeId = null)
{
    if ($excludeId) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM managers WHERE username = ? AND id != ?");
        mysqli_stmt_bind_param($stmt, 'si', $username, $excludeId);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id FROM managers WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

/* ------------------- Component ------------------- */
function getcomponents($conn)
{
    $r = mysqli_query($conn, "SELECT id, title, brand, quantity, price FROM components ORDER BY id DESC");
    return mysqli_fetch_all($r, MYSQLI_ASSOC);
}

function getComponent($conn, $id)
{
    $stmt = mysqli_prepare($conn, "SELECT id, title, brand, quantity, price FROM components WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
    return $row;
}

function addComponent($conn, $title, $brand, $quantity, $price, $managerId)
{
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO components (title, brand, quantity, price, manager_id) VALUES (?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, 'ssidi', $title, $brand, $quantity, $price, $managerId);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateComponent($conn, $id, $title, $brand, $quantity, $price)
{
    $stmt = mysqli_prepare(
        $conn,
        "UPDATE components SET title = ?, brand = ?, quantity = ?, price = ? WHERE id = ?"
    );
    mysqli_stmt_bind_param($stmt, 'ssidi', $title, $brand, $quantity, $price, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function deleteComponent($conn, $id)
{
    $stmt = mysqli_prepare($conn, "DELETE FROM components WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function searchcomponents($conn, $term)
{
    $like = '%' . $term . '%';
    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, title, brand, quantity, price FROM components
         WHERE title LIKE ? OR brand LIKE ?
         ORDER BY id DESC"
    );
    mysqli_stmt_bind_param($stmt, 'ss', $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $rows;
}
