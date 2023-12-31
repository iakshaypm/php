<?php

require "classes/Database.php";
require "classes/Article.php";

$db = new Database();
$conn = $db -> getConn();

//! $_GET[] is used to get the url strings
//! after the ? as a key value pair in the form 
//! of a array

//! to avoid some what of sql injection
//! not completely
//! isset is used to check if the value is set or not
if ( isset($_GET['id']) ) {
    // $sql = "SELECT * 
    //         FROM articles 
    //         WHERE id = " . $_GET['id'];
    
    // $results = mysqli_query($conn, $sql);
    
    
    // //! === is used to compare the false if we use == it
    // //! will return false for empty values of string and integer
    // //! as they represent 0
    // if ($results === false) {
    //     echo mysqli_error($conn);
    // } else {
    //     //! fetch_all() to fetch all rows at once
    //     //! fetch_assoc() to fetch a single row
    //     //! returns null if no row found
    //     $article = mysqli_fetch_assoc($results); 
    // }

    $article = Article::getByID($conn, $_GET['id']);

} else {
    $article = null;
}


?>

<?php require 'includes/header.php' ?>

<?php if ($article): ?>
    <article>
        <h2><?= htmlspecialchars($article->title); ?></h2>
        <p> <?= htmlspecialchars($article->content); ?></p>
    </article>

    <a href="edit-article.php?id=<?= $article->id; ?>">Edit</a>
    <a href="edit-article.php?id=<?= $article->id; ?>">Delete</a>
<?php else: ?>
    <p>No articles found.</p>
<?php endif; ?>

<?php require 'includes/footer.php' ?>