<?php

// you need these if the other thing are at another file, they dont have to be
// require_once "./database-functions.php";
// require_once './input-cleaners.php';


// THESE CONTROLLERS ARE MADE USING THE SAME DATABASE AS IN "./database-funtions.php"

// i dont think this is needed but here anyway
// function to view the things from the database
function viewArticlesController(){
    $allnews = null;
    if (isset($_POST['section'])) {
        $section = cleanUpInput($_POST['section']);
        $allnews = getSectionArticles($section);
    }
    else {
        $allnews = getAllArticles();
    }
    require "views/articles.view.php";    
}

// function controller to the database adding to the database using a html form

// the form: 

    <form  action="/add_article" method="post">

        <label for="title">Otsikko:</label>
        <input id="title" type="text" name="newstitle" maxlength=30 value="">

        <label for="text">Uutinen:</label>
        <textarea id="text" name="newstext" rows="5" cols="30"></textarea>

        <label for="date">Valitse artikkelin päivämäärä</label>
        <input id="date" type="datetime-local"  name="newstime" value=""> 

        <label for="rdate">Poistopäivä:</label>
        <input id="rdate" type="date" name="removedate" value="">

        <label for="section">Uutisen aihe:</label>
        <select name="section" id="section">
            <option value="kotimaa">Kotimaa</option>
            <option value="mielipide">Mielipide</option>
            <option value="ulkomaa">Ulkomaa</option>
            <option value="urheilu">Urheilu</option>
            <option value="viihde">Viihde</option>
        </select>

        <input id="sendbutton" type="submit" value="Lähetä">
    </form>

function addArticleController(){
    if(isset($_POST['newstitle'], $_POST['newstext'], $_POST['newstime'], $_POST['removedate'], $_POST['section'])){
        $title = cleanUpInput($_POST['newstitle']);
        $text = cleanUpInput($_POST['newstext']);
        $time = cleanUpInput($_POST['newstime']);
        $section = cleanUpInput($_POST["section"]);
        $removetime = cleanUpInput($_POST['removedate']);   
        $userid = $_SESSION["userid"];
        addArticle($title, $text, $time, $removetime, $userid, $section); 
        header("Location: /");    
    } else {
        require "views/newArticle.view.php";
    }
}


// I'm not 100% sure what this for, but i think its for searching the database
function editArticleController(){
    try {
        if(isset($_GET["id"])){
            $id = cleanUpInput($_GET["id"]);
            $news = getArticleById($id);
        } else {
            echo "Virhe: id puuttuu ";    
        }
    } catch (PDOException $e){
        echo "Virhe uutista haettaessa: " . $e->getMessage();
    }
    
    if($news){
        $id = $news['articleid'];
        $title = $news['title'];
        $text = $news['text'];
        $dbtime = $news['created'];
        $time = implode("T", explode(" ",$dbtime));
        $removetime = $news['expirydate'];
        $id = $news['articleid'];
    
        require "views/updateArticle.view.php";
    } else {
        header("Location: /");
        exit;
    }
}


// fuction controller to edit the thing from the database using a html form

// the form:
    <form  action="/update_article" method="post" >
        <label for="title">Otsikko:</label>
        <input id="title" type="text" name="newstitle" maxlength=30 value="<?=$title?>">

        <label for="text">Uutinen:</label>
        <textarea id="text" name="newstext" rows="5" cols="30"><?=$text?></textarea>     

        <label for="date">Valitse artikkelin päivämäärä</label>
        <input id="date" type="datetime-local"  name="newstime" value=<?=$time?>>

        <label for="rdate">Poistopäivä:</label>
        <input id="rdate" type="date" name="removedate" value=<?=$removetime?>>

        <input type="hidden" id="articleid" name="id" value=<?=$id?>>

        <input id="sendbutton" type="submit" value="Lähetä">
    </form>

function updateArticleController(){
    if(isset($_POST['newstitle'], $_POST['newstext'], $_POST['newstime'], $_POST['removedate'], $_POST["id"])){
        $title = cleanUpInput($_POST['newstitle']);
        $text = cleanUpInput($_POST['newstext']);
        $time = cleanUpInput($_POST['newstime']);
        $removetime = cleanUpInput($_POST['removedate']);
        $id = cleanUpInput($_POST["id"]);

        try{
            updateArticle($title, $text, $time, $removetime, $id);
            header("Location: /");    
        } catch (PDOException $e){
                echo "Virhe uutista päivitettäessä: " . $e->getMessage();
        }
    } else {
        header("Location: /");
        exit;
    }
}

// function controller for deleting something from database

// button and things for the delete:
// they won't comment eather

    $id = $newsitem['articleid'];
    $newsid = 'deleteNews' . $id; ?>
    <a id=<?=$newsid ?> onClick='confirmDelete(<?=$id?>)' href='/delete_article?id=<?=$id?>'>Poista</a> | 

function deleteArticleController(){
    try {
        if(isset($_GET["id"])){
            $id = cleanUpInput($_GET["id"]);
            deleteArticle($id);
        } else {
            echo "Virhe: id puuttuu ";    
        }
    } catch (PDOException $e){
        echo "Virhe uutista poistettaessa: " . $e->getMessage();
    }

    $allnews = getAllArticles();

    header("Location: /");
    exit;
}