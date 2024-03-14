<?php
session_start();
include 'db.php';
if(isset($_SESSION['id'])) {
    if((!empty($_POST['userComment']) or !empty($_POST['userImg'])) and !empty($_GET['id'])) {
        $userComment = $_POST['userComment'];
        $userImg = $_POST['userImg'];
        $id = $_SESSION['id'];
        $date = date('Y-m-d');
        $topicId = $_GET['id'];
        $userCommentChecked = preg_replace('#\'#', '’', $userComment);
        $query = "INSERT INTO comments SET comment='$userCommentChecked', userImg='$userImg', user_id='$id', date='$date', topic_id='$topicId'";
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
