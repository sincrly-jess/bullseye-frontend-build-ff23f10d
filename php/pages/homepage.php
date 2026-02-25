<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bullseye</title>
    <?php
    $assets_dir = __DIR__ . '/../dist/assets/';
    foreach (glob($assets_dir . '*.css') as $css) {
        echo '<link rel="stylesheet" href="dist/assets/' . basename($css) . '">';
    }
    ?>
</head>
<body>
    <div id="root"></div>
    <?php
    foreach (glob($assets_dir . '*.js') as $js) {
        echo '<script type="module" src="dist/assets/' . basename($js) . '"></script>';
    }
    ?>
</body>
</html>
