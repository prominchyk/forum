<?php
session_start();
include 'db.php';
if(isset($_SESSION['id'])) {
    if(!empty($_POST['userComment']) and !empty($_GET['id'])) {
        $userComment = $_POST['userComment'];
        $id = $_SESSION['id'];
        $date = date('Y-m-d');
        $topicId = $_GET['id'];
        $query = "INSERT INTO comments SET comment='$userComment', user_id='$id', date='$date', topic_id='$topicId'";
        $res = mysqli_query($link, $query);
        if(!$res and MODE === 'dev') {
            die(mysqli_error($link));
        }
        header("Location: contentTopic.php?id=$topicId");
    } else {
        header("Location: content.php");
    }
} else {
    header("Location: index.php");
}
?>