<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - <?php echo htmlspecialchars($recette['titre']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/recette.css">
</head>

<body>
    <div id="section">

        <!-- Header -->
        <?php
            require "template/header.php";
        ?>

        <!-- Main Section -->
        <div class="recipe-container">
            <div class="recipe-header">
                <h2><?php echo htmlspecialchars($recette['titre']); ?></h2>
                <p><?php echo htmlspecialchars($recette['description']); ?></p>
            </div>
            <div class="recipe-image">
                <img src="assets/images/<?php echo htmlspecialchars($recette['image']); ?>" alt="<?php echo htmlspecialchars($recette['titre']); ?>">
            </div>
            <div class="recipe-details">
                <h3>Ingrédients</h3>
                <div class="ingredients">
                    <?php echo nl2br(htmlspecialchars($recette['ingredients'])); ?>
                </div>
                <h3>Instructions</h3>
                <div class="instructions">
                    <?php echo nl2br(htmlspecialchars($recette['instructions'])); ?>
                </div>
                <?php if ($user_id): ?>
                    <form action="traitement_favoris.php" method="post">
                        <input type="hidden" name="recette_id" value="<?php echo htmlspecialchars($recette['id']); ?>">
                        <button type="submit" class="favorite-btn <?php echo $is_favorite ? 'active' : ''; ?>">
                            <?php echo $is_favorite ? 'Retirer des favoris' : 'Ajouter aux favoris'; ?>
                        </button>
                    </form>
                <?php endif; ?>
                <button><a href="recetteCategory.php?recetteCategory=<?php echo htmlspecialchars($category_id); ?>">Retour aux recettes</a>
                </button>
            </div>
        </div>

        <!-- Footer -->
        <?php
            require "template/footer.php";
        ?>

    </div>

    <script src="assets/js/recette.js"></script>
</body>

</html>
