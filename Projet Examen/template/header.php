<?php
if(!isset($categoriesHeader)){
    require "src/db.php";

    $query_categories = "SELECT id, nom FROM categories ORDER BY nom";
    $result_categories = $conn->query($query_categories);

    $categoriesHeader = [];
    while ($row = $result_categories->fetch(PDO::FETCH_ASSOC)) {
        $categoriesHeader[] = $row;
    }
}
?>

<header>
    <nav class="navbar">
        <div class="logo">
            <i class="fa-solid fa-bars bars"></i>
            <a href="index.php" class="name">Tea Spoon</a>
        </div>

        <?php
        $filtered_categories = array_filter($categoriesHeader, function($category) {
            return $category['id'] != 0;
        });
        ?>
        <ul class="nav-items">
            <?php foreach ($filtered_categories as $category): ?>
                <li><a href="recetteCategory.php?recetteCategory=<?php echo $category['id']; ?>"><?php echo $category['nom']; ?></a></li>
            <?php endforeach; ?>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <div class="buttons">
            <a href="favoris.php"><svg id="favorite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                </svg></a>
            <a href="<?php echo isset($_SESSION['user_id']) ? 'dashboard.php' : 'connexion.php'; ?>">
                <svg id="user" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                </svg>
            </a>
        </div>
    </nav>
</header>
