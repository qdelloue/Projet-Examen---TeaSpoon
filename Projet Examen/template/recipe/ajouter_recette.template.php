<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - Ajouter une recette</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/crud_recette.css">
</head>

<body>
    <div id="section">

        <!-- Header -->
        <?php require "template/header.php"; ?>

        <!-- Form -->
        <div class="form-container">
            <h2>Ajouter une recette</h2>
            <?php if (isset($recipe_errors) && !empty($recipe_errors)): ?>
                <div>
                    <?php foreach ($recipe_errors as $error): ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($recipe_success)): ?>
                    <p class="success"><?php echo htmlspecialchars($recipe_success); ?></p>
            <?php endif; ?>
            <form action="ajouter_recette.php" method="POST" enctype="multipart/form-data">
                <label for="titre">Titre:</label>
                <input type="text" name="titre" required>

                <label for="categorie_id">Catégorie:</label>
                <select name="categorie_id" required>
                    <?php
                    foreach ($categories as $category):
                        ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['nom']); ?>
                        </option>
                    <?php endforeach;
                    ?>
                </select>

                <label for="description">Description:</label>
                <textarea name="description" required></textarea>

                <label for="ingredients">Ingrédients:</label>
                <textarea name="ingredients" required></textarea>

                <label for="instructions">Instructions:</label>
                <textarea name="instructions" required></textarea>

                <label for="image">Image:</label>
                <input type="file" name="image" accept="image/*" required>

                <button type="submit">Ajouter la recette</button>
                <input type="hidden" name="action" value="ajouter">
            </form>
        </div>

        <!-- Footer -->
        <?php require "template/footer.php"; ?>

    </div>

    <script src="assets/js/crud_recette.js"></script>
</body>

</html>
