<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - Dashboard</title>
    <meta charset="UTF-8"> <!-- ENCODAGE UTF-8 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>

<body>
<div id="section">

    <!-- Header -->
    <?php require "template/header.php"; ?>

    <!-- Main content -->
    <div class="dashboard-container">
        <!-- Left Menu -->
        <div class="dashboard-menu">
            <ul>
                <li class="<?php echo ($action == 'account') ? 'active' : ''; ?>">
                    <a href="dashboard.php?action=account"><i class="fas fa-user"></i> Mon compte</a>
                </li>
                <li class="<?php echo ($action == 'edit') ? 'active' : ''; ?>">
                    <a href="dashboard.php?action=edit"><i class="fas fa-edit"></i> Modifier le profil</a>
                </li>
                <li>
                    <a href="dashboard.php?action=delete"><i class="fas fa-trash-alt"></i> Supprimer le compte</a>
                </li>
                <li>
                    <a href="dashboard.php?logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </li>
            </ul>
        </div>

        <!-- Main content -->
        <div class="dashboard-content">
            <?php
            if (isset($_SESSION['error_message'])) {
                echo '<p class="error">' . htmlspecialchars($_SESSION['error_message']) . '</p>';
                unset($_SESSION['error_message']);
            }
            if (isset($_SESSION['success_message'])) {
                echo '<p class="success">' . htmlspecialchars($_SESSION['success_message']) . '</p>';
                unset($_SESSION['success_message']);
            }
            ?>

            <?php if ($action == 'account'): ?>
                <!-- My account -->
                <h2>Mon Compte</h2>
                <p><strong>Nom d'utilisateur:</strong> <?php echo htmlspecialchars($user->getNomUtilisateur()); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user->getEmail()); ?></p>
                <p><strong>Mot de passe:</strong> <?php echo htmlspecialchars($password_stars); ?></p>
            <?php elseif ($action == 'edit'): ?>
                <!-- Update account -->
                <h2>Modifier le Profil</h2>
                <form method="post" action="dashboard.php">
                    <label for="username">Nom d'utilisateur:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user->getNomUtilisateur()); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required>

                    <label for="new_password">Nouveau mot de passe (laisser vide pour conserver l'actuel):</label>
                    <input type="password" id="new_password" name="new_password">

                    <button type="submit" name="update">Mettre à jour</button>
                </form>
            <?php elseif ($action == 'delete'): ?>
                <!-- Delete account -->
                <h2>Supprimer le Compte</h2>
                <p>Attention : cette action est irréversible.</p>
                <form method="post" action="dashboard.php">
                    <button type="submit" name="delete">Supprimer le compte</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php require "template/footer.php"; ?>

</div>

<script src="assets/js/dashboard.js"></script>
</body>
</html>
