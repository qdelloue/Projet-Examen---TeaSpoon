<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tea Spoon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
    <!-- Loading screen -->
    <div class="loading-page">
        <svg id="svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
                d="M245.8 220.9c-14.5-17.6-21.8-39.2-21.8-60.8C224 80 320 0 416 0c53 0 96 43 96 96c0 96-80 192-160.2 192c-21.6 0-43.2-7.3-60.8-21.8L54.6 502.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L245.8 220.9z" />
        </svg>
        <div class="name-container">
            <div class="logo-name">Tea Spoon</div>
        </div>
    </div>

    <!-- Main content -->
    <div id="section">

        <!-- Header -->
        <?php
            require "template/header.php";
        ?>

        <!-- Welcome section -->
        <?php foreach ($welcomeSections as $welcome) : ?>
            <div class="<?= htmlspecialchars($welcome['section_class']) ?>-section">
                <div class="<?= htmlspecialchars($welcome['section_class']) ?>-container">
                    <h2><?= htmlspecialchars($welcome['nom']) ?></h2>
                    <p><?= htmlspecialchars($welcome['description']) ?></p>
                    <button><a href="recetteCategory.php?recetteCategory=<?= htmlspecialchars($welcome['id']) ?>">Découvrez les recettes</a></button>
                </div>
                <div class="<?= htmlspecialchars($welcome['section_class']) ?>-container-image">
                    <div class="image" style="background-image: url(assets/images/<?= htmlspecialchars($welcome['image']) ?>);"></div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Slider Section -->
        <div class="recipe-slider">
            <h2>Recettes</h2>
            <div class="swiper-container">
                <div class="swiper-wrapper" id="recipe-slider-wrapper">
                    <?php foreach ($recipes as $recipe) : ?>
                        <div class="swiper-slide">
                        <a href="recette.php?id=<?= htmlspecialchars($recipe['id']) ?>&recetteCategory=<?= htmlspecialchars($recipe['categorie_id']) ?>">
                                <div class="recipe">
                                    <div class="image" style="background-image: url('assets/images/<?= htmlspecialchars($recipe['image']) ?>');"></div>
                                    <p><strong><?= htmlspecialchars($recipe['titre']) ?></strong> - <?= htmlspecialchars($recipe['description']) ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <!-- Category section -->
        <?php foreach ($categorySections as $category) : ?>
            <div class="<?= htmlspecialchars($category['section_class']) ?>-section">
                <div class="<?= htmlspecialchars($category['section_class']) ?>-container">
                    <h2><?= htmlspecialchars($category['nom']) ?></h2>
                    <p><?= htmlspecialchars($category['description']) ?></p>
                    <button><a href="recetteCategory.php?recetteCategory=<?= htmlspecialchars($category['id']) ?>">Découvrez les recettes</a></button>
                </div>
                <div class="<?= htmlspecialchars($category['section_class']) ?>-container-image">
                    <div class="image" style="background-image: url(assets/images/<?= htmlspecialchars($category['image']) ?>);"></div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Footer -->
        <?php
            require "template/footer.php";
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"
        integrity="sha512-gmwBmiTVER57N3jYS3LinA9eb8aHrJua5iQD7yqYCKa5x6Jjc7VDVaEA0je0Lu0bP9j7tEjV3+1qUm6loO99Kw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/index.js"></script>

</body>
</html>
