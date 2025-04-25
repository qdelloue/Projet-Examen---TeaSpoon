<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon - Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">
</head>

<body>
    <div id="section">

        <!-- Header -->
        <?php require "template/header.php"; ?>

        <!-- Form -->
        <div class="form-container">
            <h2>Nous contacter</h2>

            <?php if ($formSubmitted) : ?>
                <?php if (isset($success)) : ?>
                    <p class='success'><?php echo $success; ?></p>
                <?php elseif (isset($errors['db'])) : ?>
                    <p class='error'><?php echo $errors['db']; ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="nom" placeholder="Nom" value="<?php echo htmlspecialchars($nom ?? ''); ?>">
                <?php if ($formSubmitted && isset($errors['nom'])) echo "<p class='error'>{$errors['nom']}</p>"; ?>

                <input type="text" name="prenom" placeholder="Prénom" value="<?php echo htmlspecialchars($prenom ?? ''); ?>">
                <?php if ($formSubmitted && isset($errors['prenom'])) echo "<p class='error'>{$errors['prenom']}</p>"; ?>

                <input type="email" name="email" placeholder="Adresse e-mail" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                <?php if ($formSubmitted && isset($errors['email'])) echo "<p class='error'>{$errors['email']}</p>"; ?>

                <input type="text" name="objet" placeholder="Objet" value="<?php echo htmlspecialchars($objet ?? ''); ?>">
                <?php if ($formSubmitted && isset($errors['objet'])) echo "<p class='error'>{$errors['objet']}</p>"; ?>

                <div id="form-message">
                    <label>Message</label>
                    <textarea name="message"><?php echo htmlspecialchars($message ?? ''); ?></textarea>
                    <?php if ($formSubmitted && isset($errors['message'])) echo "<p class='error'>{$errors['message']}</p>"; ?>
                </div>

                <button type="submit">Envoyer votre message</button>
            </form>
        </div>

        <!-- Footer -->
        <?php require "template/footer.php"; ?>

    </div>
    <script src="assets/js/contact.js"></script>
</body>
</html>
