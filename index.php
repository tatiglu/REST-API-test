<?php
include 'db.php';

function getUserInfo($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT email, created_at FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return null;
    }

    return $user;
}

function createUser($email, $password) {
    global $pdo;

    if (empty($email) || empty($password)) {
        return "Email и пароль не могут быть пустыми.";
    }

    // Проверка, существует ли уже пользователь с таким email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        return "Такой пользователь уже зарегистрирован.";
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Вставка нового пользователя в базу данных
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        return "Пользователь успешно зарегистрирован.";
    } else {
        return "Ошибка при регистрации пользователя.";
    }
}

function loginUser($email, $password) {
    global $pdo;

    // существует ли пользователь с таким email
    $stmt = $pdo->prepare("SELECT password FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return "Введите правильный email.";
    }

    if (!password_verify($password, $user['password'])) {
        return "Введите правильный пароль.";
    }

    return "Вы успешно залогинились.";
}

/**
 * @param $oldEmail
 * @param $newEmail
 * @return string
 */
function updateUserEmail($oldEmail, $newEmail) {
    global $pdo;

    // Проверка, существует ли пользователь с таким oldEmail
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :oldEmail");
    $stmt->bindParam(':oldEmail', $oldEmail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return "Пользователь с таким старым email не найден.";
    }

    // Проверка, совпадает ли newEmail с oldEmail
    if ($newEmail === $oldEmail) {
        return "Такой email уже используется.";
    }

    // Проверка, существует ли уже пользователь с таким newEmail
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :newEmail");
    $stmt->bindParam(':newEmail', $newEmail);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        return "Новый email уже используется другим пользователем.";
    }

    // Обновление email в базе данных
    $stmt = $pdo->prepare("UPDATE users SET email = :newEmail WHERE email = :oldEmail");
    $stmt->bindParam(':newEmail', $newEmail);
    $stmt->bindParam(':oldEmail', $oldEmail);

    if ($stmt->execute()) {
        return "Email успешно изменен.";
    } else {
        return "Ошибка при изменении email.";
    }
}

/**
 * Функция смены пароля
 * @param $id
 * @param $oldPass
 * @param $newPass
 * @return string
 */
function updateUserPass($id, $oldPass, $newPass) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return "Пользователь не найден.";
    }

    if (!password_verify($oldPass, $user['password'])) {
        return "Введенный пароль не совпадает с текущим.";
    }

    if ($oldPass === $newPass) {
        return "Новый пароль совпадает с текущим.";
    }

    $hashedNewPassword = password_hash($newPass, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE users SET password = :newPassword WHERE id = :id");
    $stmt->bindParam(':newPassword', $hashedNewPassword);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        return "Пароль успешно изменен.";
    } else {
        return "Ошибка при изменении пароля.";
    }
}

function deleteUser($id) {
    global $pdo;

    // Проверка, существует ли пользователь с таким ID
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        return "Пользователь не найден.";
    }

    // Удаление пользователя из базы данных
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        return "Пользователь успешно удален.";
    } else {
        return "Ошибка при удалении пользователя.";
    }
}

//$email = "example1@example.com";
//$password = "password123";

//тестируем создание пользователя
//$result = createUser($_POST['email'], $_POST['password']);

//тестируем удаление пользователя
//$result = deleteUser($_POST['id']);

//тестируем проверку информации о пользователе
//$userInfo = getUserInfo($_POST['id']);
//print_r($userInfo);

//тестируем смену email
//$oldEmail = "a1@h.ru";
//$newEmail = "new@example.com";
//$result = updateUserEmail($oldEmail, $newEmail);


//тестируем смену пароля
//$oldPass = "newpassword456";
//$newPass = "asd123";
//$result = updateUserPass($id, $oldPass, $newPass);


// Пример вызова функции loginUser
//$result = loginUser($email, $password);

//echo $result;