<?php

// you need this if the database connecting is in a diffirent file
// require_once "./database-connection.php";

// database name:

// articles

// database columns:

// articleid	
// title	
// text	
// expirydate	
// created	
// userid	
// section


// function to get everything from the database
function getAllArticles(){
    $pdo =connectDB();
    $sql = "SELECT * FROM articles";
    $stm = $pdo->query($sql);
    $all = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $all;
}

// function to add something to the database
function addArticle($title, $text, $time, $removetime, $userid, $section){
    $pdo =connectDB();
    $data = [$title, $text, $time, $removetime, $userid, $section];
    $sql = "INSERT INTO articles (title, text, created, expirydate, userid, section) VALUES(?,?,?,?,?,?)"; //  <= THESE HAVE TO IN THE SAME ORDER AS IN THE DATABASE AND SAME NAME
    $stm=$pdo->prepare($sql);
    return $stm->execute($data);
}

// function to get single thing from database with special id
function getArticleById($id){
    $pdo = connectDB();
    $sql = "SELECT * FROM articles WHERE articleid=?";
    $stm= $pdo->prepare($sql);
    $stm->execute([$id]);
    $all = $stm->fetch(PDO::FETCH_ASSOC);
    return $all;
}

// function to delete something from the database with the id
function deleteArticle($id){
    $pdo = connectDB();
    $sql = "DELETE FROM articles WHERE articleid=?";
    $stm=$pdo->prepare($sql);
    return $stm->execute([$id]);
}

// function to update single thing from the data using the id
function updateArticle($title, $text, $time, $removetime, $articleid){
    $pdo = connectDB();
    $data = [$title, $text, $time, $removetime, $articleid];
    $sql = "UPDATE articles SET title = ?, text = ?, created = ?, expirydate = ? WHERE articleid = ?";
    $stm = $pdo->prepare($sql);
    return $stm->execute($data);
}

// function to sort something from the database using a single column
function getSectionArticles($section){
    $pdo =connectDB();
    $sql = "SELECT * FROM articles WHERE section = ?";
    $stm=$pdo->prepare($sql);
    $stm->execute(array($section));
    $all = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $all;
}    

// function to get single column from the database using the id
function getSomethingcount($id) {
    $pdo = connectDB();
    $sql = "SELECT column FROM 'table' WHERE id=?";
    $stm= $pdo->prepare($sql);
    $stm->execute([$id]);
    $all = $stm->fetch(PDO::FETCH_ASSOC);
    return $all;
}