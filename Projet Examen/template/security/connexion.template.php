<?php
session_start();
$form_to_show = $_SESSION['form_to_show'] ?? 'default';
unset($_SESSION['form_to_show']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - Connexion</title>
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
            <div id="connexion" style="display: <?php echo $form_to_show === 'default' ? 'block' : 'none'; ?>">
                <h2>S'inscrire / Se connecter</h2>
                <div id="button-container">
                    <button id="signin-button">S'inscrire</button>
                    <button id="login-button">Se connecter</button>
                </div>
            </div>

            <form id="signin" action="traitement_connexion.php" method="POST" style="display: <?php echo $form_to_show === 'register' ? 'flex' : 'none'; ?>">
                <h2>S'inscrire</h2>
                <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                <?php
                if(isset($_SESSION['register_errors']['username'])) {
                    echo '<p class="error">' . htmlspecialchars($_SESSION['register_errors']['username']) . '</p>';
                }
                ?>
                <input type="email" name="email" placeholder="Adresse e-mail" required>
                <?php
                if(isset($_SESSION['register_errors']['email'])) {
                    echo '<p class="error">' . htmlspecialchars($_SESSION['register_errors']['email']) . '</p>';
                }
                ?>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <?php
                if(isset($_SESSION['register_errors']['password'])) {
                    echo '<p class="error">' . htmlspecialchars($_SESSION['register_errors']['password']) . '</p>';
                }
                ?>
                <button type="submit" name="action" value="register">S'inscrire</button>
                <p>Vous possédez déjà un compte ? <a href="#">Se connecter</a></p>
            </form>
            <?php
            if(isset($_SESSION['register_errors']['general'])) {
                echo '<p class="error">' . htmlspecialchars($_SESSION['register_errors']['general']) . '</p>';
            }
            if(isset($_SESSION['register_success'])) {
                echo '<p class="success">' . htmlspecialchars($_SESSION['register_success']) . '</p>';
                unset($_SESSION['register_success']);
            }
            unset($_SESSION['register_errors']);
            ?>

            <form id="login" action="traitement_connexion.php" method="POST" style="display: <?php echo $form_to_show === 'login' ? 'flex' : 'none'; ?>">
                <h2>Se connecter</h2>
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
                <button type="submit" name="action" value="login">Se connecter</button>
                <p>Vous êtes nouveau ? <a href="#">S'inscrire</a></p>
            </form>
            <?php
            unset($_SESSION['login_errors']);
            ?>
        </div>

        <!-- Footer -->
        <?php require "template/footer.php"; ?>
    </div>

    <script>
    const formToShow = '<?php echo $form_to_show; ?>';
    </script>
    <script src="assets/js/connexion.js"></script>
</body>
</html>
