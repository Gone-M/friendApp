# friendApp

It connects to a MySQL database running on localhost using PDO (PHP Data Objects), a PHP extension for database connections. The connection details like server name, port, username, password, and database name are specified at the beginning of the script. After establishing the database connection, it attempts to fetch user data from the database based on the user's session ID ($_SESSION['user_id']). It retrieves information such as username and location from the "users" table.
