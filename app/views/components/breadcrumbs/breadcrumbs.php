<div class="breadcrumbs">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Home</a>
                </li>
                <?php foreach ($items as $item): ?>
                    <?php if ($item === end($items)): ?>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $item['title'] ?>
                        </li>
                    <?php else: ?>
                        <li class="breadcrumb-item">
                            <a href="<?= $item['url'] ?>"><?= $item['title'] ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </nav>
    </div>
</div>
