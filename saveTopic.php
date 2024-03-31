<?php
session_start();
include 'db.php';
require_once 'classes/Topic.php';

if(!empty(trim($_POST['titleTopic'])) and !empty(trim($_POST['textTopic']))) {
    $id = $_SESSION['id'];
    $topic = new Topic($_POST['titleTopic'], $_POST['textTopic'], date('Y-m-d'));
        
    $query = "INSERT INTO forum_topics SET title='$topic->title', text='$topic->text', user_id='$id', date='$topic->date'";
    $res = mysqli_query($link, $query);
    if(!$res and MODE === 'dev') {
        die(mysqli_error($link));
    }
    $_SESSION['flash'] = null;
    $topicId = mysqli_insert_id($link);
    header("Location: contentTopic.php?id=$topicId");
    } else {
        header ('Location: addTopic.php');
        $_SESSION['flash'] = 'Для створення теми заповніть поля вище.';
    }
    echo '<link href="styles.css" rel="stylesheet" type="text/css">';

?>