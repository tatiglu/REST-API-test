
<?php

require 'db.php';
require 'function.php';

header('Content-Type: application/json');

$request_method = $_SERVER['REQUEST_METHOD'];

$response = [];

switch ($request_method) {
    case 'GET':
        $response['status'] = 'ok';
        $response['response'] = getUserInfo($_GET['id']);
        break;

    case 'POST':
        if ($_REQUEST['method'] == 'reg') {
            $response['status'] = 'ok';
            $response['response'] = createUser($_POST['email'], $_POST['password']);
        } elseif ($_REQUEST['method'] == 'login') {
            $response['status'] = 'ok';
            $response['response'] = loginUser($_POST['email'], $_POST['password']);
        } else {
            $response['status'] = 'error';
            $response['response'] = 'Method not found';
        }
        break;


    case 'PUT':
        if ($_REQUEST['oldEmail'] && $_REQUEST['newEmail']) {
            $response['status'] = 'ok';
            $response['response'] = updateUserEmail($_REQUEST['oldEmail'], $_REQUEST['newEmail']);
        } elseif ($_REQUEST['id'] && $_REQUEST['oldPass'] && $_REQUEST['newPass']) {
            $response['status'] = 'ok';
            $response['response'] = updateUserPass($_REQUEST['id'], $_REQUEST['oldPass'], $_REQUEST['newPass']);
        } else {
            $response['status'] = 'error';
            $response['response'] = 'Параметры для обновления не подходят';
        }
        break;

    case 'DELETE':
        if ($_REQUEST['id']) {
            $response['status'] = 'ok';
            $response['response'] = (deleteUser($_REQUEST['id']));
        } else {
            $response['status'] = 'error';
            $response['response'] = 'ID не выбран';
        }
        break;

    default:
        $response['status'] = 'error';
        $response['response'] = 'Неподдерживаемый метод запроса';
        break;
}
echo json_encode($response);

