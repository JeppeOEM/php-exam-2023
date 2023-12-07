<?php
require_once __DIR__ . '/../_.php';
try {

    $db = _db();
    $q = $db->prepare('SELECT * FROM users WHERE user_email = :user_email');
    $q = $db->prepare('CALL login(:user_email)');
    $q->bindValue(':user_email', $_POST['user_email']);
    $q->execute();
    $user = $q->fetch();
    var_dump($user);
    if (!$user) {
        throw new Exception('invalid credentials', 400);
    }

    echo json_encode(['user' => $user]);
} catch (Exception $e) {
    try {
        if (!$e->getCode() || !$e->getMessage()) {
            throw new Exception();
        }
        http_response_code($e->getCode());
        echo json_encode(['info' => $e->getMessage()]);
    } catch (Exception $ex) {
        http_response_code(500);
        echo json_encode($ex);
    }
}