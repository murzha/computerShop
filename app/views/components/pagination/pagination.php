<?php if ($pagination->countPages > 1): ?>
<div class="pagination-wrapper">
    <ul class="pagination">
        <?php if ($pagination->currentPage > 1): ?>
            <li class="pagination__item">
                <a href="<?= $pagination->getUrl($pagination->currentPage - 1) ?>" class="pagination__link">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $pagination->countPages; $i++): ?>
            <?php if ($i == $pagination->currentPage): ?>
                <li class="pagination__item pagination__item--active">
                    <span class="pagination__link"><?= $i ?></span>
                </li>
            <?php else: ?>
                <li class="pagination__item">
                    <a href="<?= $pagination->getUrl($i) ?>" class="pagination__link"><?= $i ?></a>
                </li>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($pagination->currentPage < $pagination->countPages): ?>
            <li class="pagination__item">
                <a href="<?= $pagination->getUrl($pagination->currentPage + 1) ?>" class="pagination__link">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?>
