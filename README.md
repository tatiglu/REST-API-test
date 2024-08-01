Таблица users:
- ID (int)
- email (string)
- password (string)
- date (datetime)

Password надо кодировать

createUser($email, $password) – создание пользователя
updateUserEmail($oldEmail, $newEmail, $id) – обновить почту
updateUserPass($id, $oldPassword, $newPassword) - обновить пароль
deleteUser($id) - удалить пользователя
loginUser($email, $password) - авторизация пользователя
getUserInfo($id) - получить информацию о пользователе, email и дату регистрации (пароль не выводим).


Чтобы нам залогиниться, нам нужно отправить POST-запрос с параметрами email, содержащий ... пользователя,  и password -__- на адрес api.php?method=login 
Чтобы зарегистрироваться, метод регистер и так далее.



