<?php
/**
 * Created by PhpStorm.
 * User: linlongxin
 * Date: 2016/6/3
 * Time: 13:00
 */

include '../config/connect_pdo.php';
include '../config/check.php';
include '../config/statusCode.php';

$page = $_REQUEST['page'];

check_empty($page);

$start = ($page - 1) * 20;
$end = $page * 20;

$query_sql = "SELECT * FROM picture LIMIT $start,$end";
$query_result = $pdo_connect->query($query_sql);

if ($query_result->rowCount()) {
    $result_rows = $query_result->fetchAll();

    $index = 0;
    foreach ($result_rows as $row) {

        $temp['id'] = $row['id'];
        $temp['name'] = $row['name'];
        $temp['intro'] = $row['intro'];
        $temp['width'] = $row['width'];
        $temp['height'] = $row['height'];
        $temp['src'] = $row['src'];
        $temp['author_id'] = $row['author_id'];
        $temp['tag'] = $row['tag'];
        $temp['score'] = $row['score'];
        $temp['watch_count'] = $row['watch_count'];
        $temp['collection_count'] = $row['collection_count'];
        $temp['album_id'] = $row['album_id'];
        $temp['create_time'] = strtotime($row['create_time']);

        $result[$index] = $temp;
        $index++;
    }
} else {
    serverError();
}

echo json_encode($result);