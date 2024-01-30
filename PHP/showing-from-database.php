<?php

//THERE IS MANY WAYS TO SHOW STUFF FROM DATABASE


//STYLE 1

include './database-functions.php';
// its really getAllArticles

$companies = getAllCompanies();

echo "<table border='3'>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>email</th>
        <th>phone</th>
        <th>vat</th>
        <th>added</th>
    </tr>";

    foreach ($companies as $companyinfo) {
        echo "<tr>";
        echo "<td>" . $companyinfo['companyID'] . "</td>";
        echo "<td>" . $companyinfo['name'] . "</td>";
        echo "<td>" . $companyinfo['contactEmail'] . "</td>";
        echo "<td>" . $companyinfo['contactTel'] . "</td>";
        echo "<td>" . $companyinfo['vat_number'] . "</td>";
        echo "<td>" . $companyinfo['added'] . "</td>";
        echo "</tr>";
    }
echo "</table>"; 


//STYLE 2 

// this one is little longer, but it has some middleware also

$allnews = is the function to get from database

foreach($allnews as $newsitem): 
    $id = $newsitem["userid"];
    $info = getUserInfo($id);
    ?>
    <div class='newsitem'>
    <h2><?=$newsitem["name"] ?></h2>
    <h4><?=$newsitem["info"]?></h4>
    <p>type: <?=$newsitem["type"]?></p>
    <p>address: <?=$newsitem["address"]?></p>
    <p>postalcode: <?=$newsitem["postalcode"]?></p>
    <p>city: <?=$newsitem["city"]?></p>
    <p>event date: <?=$newsitem["date"]?></p>
    <h3>Contact person</h3>
    <p>Name: <?=$info["firstname"]?></p>
    <p>Company: <?=$info["company"]?></p>
    <p>Email: <?=$info["email"]?></p>
    
    <?php
    // So this check if user is logged in and if the "newsitem" is owned by same person as logged in
    if(isLoggedIn() && ($newsitem["userid"] == $_SESSION["userid"])):
        $id = $newsitem['eventid'];
        $eventid = 'deleteNews' . $id; ?>
        <a class="navbutton2" id=<?=$eventid ?> onClick='confirmDelete(<?=$id?>)' href='/delete_event?id=<?=$id?>'>Delete</a> 
        <a class="navbutton2" href='/update_event?id=<?=$id?>'>Update</a>
    <?php endif; ?>
        <a class="navbutton2" href="/register_event?id=<?=$id?>">Register</a>
    </div>
    <br> 
<?php endforeach ?>