<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->getMeta(); ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Base styles -->
    <link href="/assets/styles/variables.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" rel="stylesheet">

    <!-- Component styles -->
    <link href="/assets/styles/components.css" rel="stylesheet">
    <link href="/assets/styles/components-additional.css" rel="stylesheet">

    <?php
    // Get current page and load corresponding styles
    $page = $this->getPage() ?: 'home';
    $pageStyle = "/assets/styles/pages/{$page}.css";
    if (file_exists(WWW . $pageStyle)): ?>
        <link href="<?= $pageStyle ?>" rel="stylesheet">
    <?php endif; ?>

    <!-- Custom styles -->
    <link href="/assets/styles/custom.css" rel="stylesheet">
</head>
<body data-page="<?= $page ?>">

<?php $this->loadComponent('header/header', compact('brands')); ?>

<main class="main">
    <?= $content ?>
</main>

<?php $this->loadComponent('footer/footer'); ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Base modules -->
<script src="/assets/js/modules/core/EventEmitter.js" type="module"></script>
<script src="/assets/js/modules/core/Api.js" type="module"></script>
<script src="/assets/js/modules/core/Store.js" type="module"></script>
<script src="/assets/js/modules/core/Notification.js" type="module"></script>

<!-- Feature modules -->
<script src="/assets/js/modules/features/Cart.js" type="module"></script>
<script src="/assets/js/modules/features/Catalog.js" type="module"></script>
<script src="/assets/js/modules/features/ProductGallery.js" type="module"></script>
<script src="/assets/js/modules/features/Forms.js" type="module"></script>

<!-- Main app -->
<script src="/assets/js/modules/index.js" type="module"></script>

<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
</body>
</html>
