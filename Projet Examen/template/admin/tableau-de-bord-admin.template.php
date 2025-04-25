<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/tableau-de-bord-admin.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div id="section">
        <!-- Header -->
        <?php require "template/header.php"; ?>

        <div class="dashboard-container">
            <!-- Left Menu -->
            <div class="dashboard-menu">
                <ul>
                    <li class="<?php echo ($action == 'recipes') ? 'active' : ''; ?>">
                        <a href="?action=recipes"><i class="fas fa-utensils"></i> Gestion des recettes</a>
                    </li>
                    <li class="<?php echo ($action == 'users') ? 'active' : ''; ?>">
                        <a href="?action=users"><i class="fas fa-users"></i> Gestion des utilisateurs</a>
                    </li>
                    <li class="<?php echo ($action == 'messages') ? 'active' : ''; ?>">
                        <a href="?action=messages"><i class="fas fa-envelope"></i> Messages de contact</a>
                    </li>
                </ul>
            </div>

            <!-- Main content -->
            <div class="dashboard-content">
                <h2>Tableau de bord Admin</h2>

                <?php
                $action = $_GET['action'] ?? 'recipes';

                switch($action) {
                    case 'recipes':
                        $recettes = $adminController->getAllRecipes();
                        ?>
                        <div class="table-responsive table-recipes">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nom de la recette</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recettes as $recette): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($recette['titre']); ?></td>
                                            <td>
                                                <button id="update-button"><a href="modifier_recette.php?id=<?php echo $recette['id']; ?>">Modifier</a></button>
                                                <button id="delete-button"><a href="supprimer_recette.php?id=<?php echo $recette['id']; ?>">Supprimer</a></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        break;
                    case 'users':
                        $users = $adminController->getAllUsers();
                        ?>
                        <div class="table-responsive table-users">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nom d'utilisateur</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['nom_utilisateur']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td>
                                                <button id="update-button"><a href="modifier_utilisateur.php?id=<?php echo $user['id']; ?>">Modifier</a></button>
                                                <button id="delete-button"><a href="supprimer_utilisateur.php?id=<?php echo $user['id']; ?>">Supprimer</a></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        break;
                    case 'messages':
                        $messages = $adminController->getAllMessages();
                        ?>
                        <div class="table-responsive table-messages">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Objet</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($messages as $message): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($message['nom']); ?></td>
                                            <td><?php echo htmlspecialchars($message['email']); ?></td>
                                            <td><?php echo htmlspecialchars($message['objet']); ?></td>
                                            <td><?php echo htmlspecialchars($message['message']); ?></td>
                                            <td>
                                                <button id="delete-button"><a href="supprimer_message.php?id=<?php echo $message['id']; ?>">Supprimer</a></button>                                           
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        break;
                }
                ?>
            </div>
        </div>

        <!-- Footer -->
        <?php require "template/footer.php"; ?>
    </div>
    <script src="assets/js/tableau-de-bord-admin.js"></script>
</body>
</html>
