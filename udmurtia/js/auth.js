const buttonEnter = document.querySelector('#buttonEnter');
buttonEnter.addEventListener('click', sendAuth);

function sendAuth() {
    const adminKey = ''; 
    const login = document.querySelector('#login').value;
    const password = document.querySelector('#password').value;

    if (!adminKey || !login || !password) {
        alert('Заполните все поля');
        return;
    }

    const data = {
        adminKey: adminKey,
        email: login,
        password: password
    };

    const jsonBody = JSON.stringify(data);

    fetch(`${domain}/api/users/auth.php`, {
        method: 'POST',
        body: jsonBody,
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Произошла ошибка при запросе. Статус: ${response.status}, Подробности: ${response.statusText}`);
        }
        return response.json();
    })
    .then(json => {
        if (json.hasOwnProperty('success')) {
            if (json.success) {
                window.location.reload();
            } else {
                alert(json.message);
            }
        } else {
            alert('Неверный логин или пароль!');
        }
    })
    .catch(error => {
        if (error.name === 'AbortError') {
            alert('Сервер временно не доступен! Подробнее: info@example.ru');
        } else {
            alert(error.message);
        }
    });
}

