<?php

require "classes/Database.php";
require "classes/Books.php";
require "classes/Pagenator.php";

$db = new Database();
$book = new Books();

$conn = $db -> getConn();

$table_heading = array();

if(isset($_POST['default'])) {

    if(!isset($_POST['table_attr'])) {
        
        $total_records = $book -> getTotalRecords($conn);
        $pagenator = new Pagenator($_POST['page'] ?? 1, 10, $total_records);
        $result = $book -> getPages($conn, $pagenator -> limit, $pagenator -> offset, $_GET['order'] ?? "not", $_GET['type'] ?? "not");
    } else {
        
        $res = $book->search($conn, $_POST['table_attr'], $_POST['search_term']);
        $total_records = count($res[1]);
        $pagenator = new Pagenator($_POST['page'] ?? 1, 10, $total_records);
        $result = $book -> search($conn, $_POST['table_attr'], $_POST['search_term'], $pagenator -> limit, $pagenator -> offset);
        foreach ($result[0] as $keys => $values) {
            array_push($table_heading, $values);
        }
    }
}
?>

<?php isset($_POST['pagenation']) ? require "includes/paginator.php" : require "includes/table_body.php" ?>