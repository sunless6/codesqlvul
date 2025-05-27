<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "mydb";


$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die("Ошибка подключения: " . mysql_error());
}
mysql_select_db($dbname, $conn);


$user_id = $_GET['id'];


$sql = "SELECT * FROM users WHERE id = " . $user_id; 

//3десь переменная $user_id (полученная напрямую из HTTP GET-параметра без какой-либо очистки или 
//проверки) конкатенируется непосредственно в SQL-запрос.
//Так как условие 1=1 всегда истинно, этот запрос вернет все строки из таблицы users, а не только ту, которая соответствует id = 1. Злоумышленник получает доступ ко всем данным пользователей.
$result = mysql_query($sql);

if (!$result) {
    die("Ошибка выполнения запроса: " . mysql_error());
}

if (mysql_num_rows($result) > 0) {
    while($row = mysql_fetch_assoc($result)) {
        echo "ID: " . $row["id"]. " - Имя: " . $row["name"]. " - Email: " . $row["email"]. "<br>";
    }
} else {
    echo "Пользователь не найден.";
}

mysql_close($conn);
?>