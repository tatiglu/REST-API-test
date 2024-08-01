# User Management API

## Описание

Этот проект представляет собой простой REST API для управления пользователями. Он позволяет выполнять операции создания, авторизации, чтения, обновления и удаления пользователей в базе данных.

## API Методы

#### GET /api.php?id={id}

Получить информацию о пользователе по ID.

Параметры:

- id (обязательный): ID пользователя

Пример запроса:

```curl -X GET "/api.php?id=1"```


#### POST /api.php

Создать нового пользователя или войти в систему.

Параметры для регистрации:

- method=reg (обязательный)
- email (обязательный)
- password (обязательный)

Пример запроса для регистрации:

```curl -X POST -d "method=reg&email=test@example.com&password=123456" "/api.php"```

Параметры для входа:

- method=login (обязательный)
- email (обязательный)
- password (обязательный)

Пример запроса для входа:

```curl -X POST -d "method=login&email=test@example.com&password=123456" "/api.php"```


#### PUT /api.php

Обновить email или пароль пользователя.

Параметры для обновления email:

- oldEmail (обязательный)
- newEmail (обязательный)

Пример запроса для обновления email:

```curl -X PUT -d "oldEmail=old@example.com&newEmail=new@example.com" "/api.php"```

Параметры для обновления пароля:

- id (обязательный)
- oldPass (обязательный)
- newPass (обязательный)

Пример запроса для обновления пароля:

```curl -X PUT -d "id=1&oldPass=oldpassword&newPass=newpassword" "/api.php"```

#### DELETE /api.php

Удалить пользователя по ID.

Параметры:

- id (обязательный)

Пример запроса:

```curl -X DELETE -d "id=1" "/api.php"```

## База данных

Создайте таблицу users в базе данных:

CREATE TABLE `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
