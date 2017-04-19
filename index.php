<?php
$db_name = $_ENV["DB_NAME"];
$db_host = $_ENV["DB_HOST"];
$db_user = $_ENV["DB_USER"];
$db_port = $_ENV["DB_PORT"];
$db_password = $_ENV["DB_PASSWORD"];

if (!mysql_connect($db_host . ":" . $db_port, $db_user, $db_password)) {
    echo 'Could not connect to mysql';
    exit;
}

$sql = "SHOW TABLES FROM $db_name";
$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not list tables\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}
?>
<h1>Here are the database tables</h1>
<ul>
<?php
while ($row = mysql_fetch_row($result)) {
    echo "<li>Table: {$row[0]}</li>\n";
}

mysql_free_result($result);
?>
</ul>
