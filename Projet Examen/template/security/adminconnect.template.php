<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - Connexion Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/connexion.css">
</head>
<body>
    <div id="section">
        <!-- Header -->
        <?php require "template/header.php"; ?>

        <!-- Form -->
        <div class="form-container">
            <form id="login" action="traitement_connexion.php" method="POST" style="display: flex;">
                <h2>Connexion Admin</h2>
                <input type="email" name="email" placeholder="Adresse e-mail" required>
                <?php
                if(isset($_SESSION['login_errors']['email'])) {
                    echo '<p class="error">' . htmlspecialchars($_SESSION['login_errors']['email']) . '</p>';
                }
                ?>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <?php
                if(isset($_SESSION['login_errors']['password'])) {
                    echo '<p class="error">' . htmlspecialchars($_SESSION['login_errors']['password']) . '</p>';
                }
                ?>
                <input type="hidden" name="action" value="login">
                <button type="submit">Se connecter</button>
            </form>
            <?php
            unset($_SESSION['login_errors']);
            ?>
        </div>

        <!-- Footer -->
        <?php require "template/footer.php"; ?>
    </div>

    <script src="assets/js/connexion.js"></script>
</body>
</html>
