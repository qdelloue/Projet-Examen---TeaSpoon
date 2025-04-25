<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - Mes Favoris</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/favoris.css">
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
                <h2>Mes Recettes Favorites</h2>
                <p>Retrouvez ici toutes vos recettes préférées !</p>
            </div>
            <div class="recipe-grid">
                <?php foreach ($recipes as $recipe): ?>
                    <a href="recette.php?id=<?php echo htmlspecialchars($recipe['id']); ?>">
                        <div class="recipe-card">
                            <div class="image" style="background-image: url('assets/images/<?php echo htmlspecialchars($recipe['image']); ?>');"></div>
                            <p><?php echo htmlspecialchars($recipe['titre']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Footer -->
        <?php 
            require "template/footer.php"; 
        ?>
    </div>

    <script src="assets/js/favoris.js"></script>
</body>
</html>
