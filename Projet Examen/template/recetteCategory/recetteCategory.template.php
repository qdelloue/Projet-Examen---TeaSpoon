<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - <?php echo htmlspecialchars($category_name); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/recetteCategory.css">
</head>

<body>
    <div id="section">

        <!-- Header -->
        <?php
            require "template/header.php";
        ?>

        <!-- Main Section -->
        <div class="recipe-container">
            <div class="recipes-header">
                <h2><?php echo htmlspecialchars($category_name); ?></h2>
                <p><?php 
                    if ($category_id === 0) {
                        echo "Explorez toutes nos recettes, réunies en un seul endroit.";
                    } else {
                        echo "Découvrez nos délicieuses recettes de " . htmlspecialchars($category_name) . " !";
                    }
                ?></p>
            </div>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe): ?>
                    <div class="recipe-card">
                        <a href="recette.php?id=<?php echo htmlspecialchars($recipe['id']); ?>&recetteCategory=<?php echo htmlspecialchars($category_id); ?>">
                            <div class="image" style="background-image: url('assets/images/<?php echo htmlspecialchars($recipe['image']); ?>');"></div>
                            <p><?php echo htmlspecialchars($recipe['titre']); ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="ajouter_recette.php">
                        <div class="recipe-card add-recipe-card">
                            <div class="image">
                                <i class="fas fa-plus fa-3x"></i>
                            </div>
                            <p>Ajouter une recette</p>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <?php
            require "template/footer.php";
        ?>

    </div>

    <script src="assets/js/recetteCategory.js"></script>
</body>

</html>
