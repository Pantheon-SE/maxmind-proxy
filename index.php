<?php

define('DB_NAME', $_ENV['DB_NAME']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER',  $_ENV['DB_USER']);
define('DB_PORT', $_ENV['DB_PORT']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

$dbh = mysqli_init();
mysqli_real_connect($dbh, DB_HOST, DB_USER, DB_PASSWORD, null, DB_PORT);

if ($dbh->connect_errno ) {
    echo 'Failed to connect to MySQL: (' . $dbh->connect_errno . ') ' . $dbh->connect_error;
    exit;
}

$sql = 'SHOW TABLES FROM ' . DB_NAME;
$result = mysqli_query($dbh, $sql);
if (!$result) {
    echo 'DB Error, could not list tables\n';
    echo 'MySQL Error: ' . $dbh->errno;
    exit;
}

?>

<h1>Here are the database tables</h1>
<ul>

<?php

while ($row = mysqli_fetch_row($result)) {
    echo "<li>Table: {$row[0]}</li>\n";
}
mysqli_free_result($result);
mysqli_close($dbh);

?>

</ul>
