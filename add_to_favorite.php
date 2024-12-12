<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    
    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }

    if (!in_array($product_id, $_SESSION['favorites'])) {
        $_SESSION['favorites'][] = $product_id;
    }

    echo json_encode(['status' => 'success', 'favorites' => $_SESSION['favorites']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
