<?php
session_start();
require_once 'classes/Comment.php';
include 'db.php';
if(isset($_SESSION['id'])) {
    if((!empty($_POST['userComment']) or !empty($_POST['userImg'])) and !empty($_GET['id'])) {
        $id = $_SESSION['id'];
        $topicId = $_GET['id'];
        $comment = new Comment($_POST['userComment'], $_POST['userImg'], date('Y-m-d'));
        $query = "INSERT INTO comments SET comment='$comment->text', userImg='$comment->img', user_id='$id', date='$comment->date', topic_id='$topicId'";
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
