<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error Details</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error-container { max-width: 1200px; margin: 0 auto; }
        .error-section { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; }
        .error-section h2 { margin-top: 0; color: #d9534f; }
        .error-details { background: #f8f9fa; padding: 10px; }
        .stack-trace { font-family: monospace; white-space: pre-wrap; }
    </style>
</head>
<body>
<div class="error-container">
    <div class="error-section">
        <h2>Error Details</h2>
        <div class="error-details">
            <p><strong>Type:</strong> <?= $error['type'] ?></p>
            <p><strong>Code:</strong> <?= $error['code'] ?></p>
            <p><strong>Message:</strong> <?= $error['message'] ?></p>
            <p><strong>File:</strong> <?= $error['file'] ?></p>
            <p><strong>Line:</strong> <?= $error['line'] ?></p>
        </div>
    </div>

    <div class="error-section">
        <h2>Request Information</h2>
        <div class="error-details">
            <p><strong>URL:</strong> <?= $error['server']['REQUEST_URI'] ?? 'N/A' ?></p>
            <p><strong>Method:</strong> <?= $error['server']['REQUEST_METHOD'] ?? 'N/A' ?></p>
            <p><strong>IP:</strong> <?= $error['server']['REMOTE_ADDR'] ?? 'N/A' ?></p>
            <p><strong>Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
        </div>
    </div>

    <?php if (!empty($error['request'])): ?>
        <div class="error-section">
            <h2>Request Data</h2>
            <div class="error-details">
                <pre><?= print_r($error['request'], true) ?></pre>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($error['session'])): ?>
        <div class="error-section">
            <h2>Session Data</h2>
            <div class="error-details">
                <pre><?= print_r($error['session'], true) ?></pre>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
