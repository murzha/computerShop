<div class="notification notification--<?= $type ?>" role="alert">
    <div class="notification__content">
        <?php if ($type === 'success'): ?>
            <i class="bi bi-check-circle notification__icon"></i>
        <?php elseif ($type === 'error'): ?>
            <i class="bi bi-x-circle notification__icon"></i>
        <?php elseif ($type === 'info'): ?>
            <i class="bi bi-info-circle notification__icon"></i>
        <?php endif; ?>
        
        <div class="notification__message">
            <?= $message ?>
        </div>
    </div>
    
    <button type="button" class="notification__close" onclick="this.parentElement.remove();">
        <i class="bi bi-x"></i>
    </button>
</div>
