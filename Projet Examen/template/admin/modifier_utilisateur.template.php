<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - Modifier un utilisateur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/crud_utilisateur.css">
</head>

<body>
    <div id="section">

        <!-- Header -->
        <?php require "template/header.php"; ?>

        <!-- Form -->
        <div class="form-container">
            <h2>Modifier le rôle de l'utilisateur</h2>

            <?php if (isset($user_success)): ?>
                <p class="success"><?php echo htmlspecialchars($user_success); ?></p>
            <?php endif; ?>

            <?php if (isset($user_errors) && !empty($user_errors)): ?>
                <div class="error-messages">
                    <?php foreach ($user_errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="modifier_utilisateur.php?id=<?php echo htmlspecialchars($userData['id']); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($userData['id']); ?>">
                <label for="role">Rôle:</label>
                <select name="role" required>
                    <option value="user" <?php echo ($userData['role'] == 'user') ? 'selected' : ''; ?>>Utilisateur</option>
                    <option value="admin" <?php echo ($userData['role'] == 'admin') ? 'selected' : ''; ?>>Administrateur</option>
                </select>

                <button type="submit" name="action" value="modifier">Modifier le rôle</button>
            </form>
        </div>

        <!-- Footer -->
        <?php require "template/footer.php"; ?>

    </div>

    <script src="assets/js/crud_utilisateur.js"></script>
</body>

</html>
