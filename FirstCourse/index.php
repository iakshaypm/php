<?php

require "classes/Database.php";
require "classes/Article.php";
require "includes/auth.php";

session_start();

$db = new Database();
$conn = $db -> getConn();

$articles = Article::getAll($conn);


// //! === is used to compare the false if we use == it
// //! will return false for empty values of string and integer
// //! as they represent 0
// if ($results === false) {
//     var_dump($conn -> errorInfo());
// } else {
//     //! fetch_all() to fetch all rows at once
//     //! fetch_row() to fetch a single row
// }

?>

<?php require 'includes/header.php' ?>

<?php if (isLoggedIn()): ?>
    <p>You are logged in. <a href="logout.php">Log out</a></p>
    <p><a href="new-article.php">New article</a></p>
<?php else: ?>
    <p>You are not logged in. <a href="login.php">Log in</a></p>
<?php endif; ?>


<?php if (empty($articles)): ?>
    <p>No articles found.</p>
<?php else: ?>
    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <article>
                    <h2><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h2>
                    <p> <?= htmlspecialchars($article['content']); ?></p>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require 'includes/footer.php' ?>