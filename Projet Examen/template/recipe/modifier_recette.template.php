<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - Modifier une recette</title>
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
            <h2>Modifier une recette</h2>
            
            <?php if (isset($recipe_success)): ?>
                <p class="success"><?php echo htmlspecialchars($recipe_success); ?></p>
            <?php endif; ?>
            
            <?php if (isset($recipe_errors) && !empty($recipe_errors)): ?>
                <div class="error-messages">
                    <?php foreach ($recipe_errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form action="modifier_recette.php?id=<?php echo htmlspecialchars($recette['id']); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($recette['id']); ?>">

                <label for="titre">Titre:</label>
                <input type="text" name="titre" value="<?php echo htmlspecialchars($recette['titre']); ?>" required>

                <label for="categorie_id">Catégorie:</label>
                <select name="categorie_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo ($category['id'] == $recette['categorie_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['nom']); ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="description">Description:</label>
                <textarea name="description" required><?php echo htmlspecialchars($recette['description']); ?></textarea>

                <label for="ingredients">Ingrédients:</label>
                <textarea name="ingredients" required><?php echo htmlspecialchars($recette['ingredients']); ?></textarea>

                <label for="instructions">Instructions:</label>
                <textarea name="instructions" required><?php echo htmlspecialchars($recette['instructions']); ?></textarea>

                <label for="image">Image:</label>
                <input type="file" name="image" accept="image/*">

                <button type="submit" name="action" value="modifier">Modifier la recette</button>
            </form>
        </div>

        <!-- Footer -->
        <?php require "template/footer.php"; ?>

    </div>

    <script src="assets/js/crud_recette.js"></script>
</body>

</html>
