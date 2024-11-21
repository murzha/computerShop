<?php

/**
 * Debug function
 * @param mixed $data Data to debug
 */
function debug($data)
{
    echo '<pre>' . print_r($data, true) . '</pre>';
}

/**
 * Redirect function
 * @param string|bool $http Redirect URL
 */
function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
    }
    header("Location: $redirect");
    exit;
}

/**
 * Calculate discount percentage
 * @param float $oldPrice Original price
 * @param float $currentPrice Current price
 * @return string Formatted discount percentage
 */
function getDiscountPercent(float $oldPrice, float $currentPrice): string
{
    if ($oldPrice <= 0 || $oldPrice <= $currentPrice) {
        return '';
    }
    $discountPercent = round((($oldPrice - $currentPrice) * 100) / $oldPrice);
    return "-{$discountPercent}%";
}

/**
 * Crop text to specified length
 * @param string $text Input text
 * @param int $length Maximum length
 * @return string Cropped text
 */
function cropText(string $text, int $length): string
{
    $string = strip_tags($text);
    if (mb_strlen($string) <= $length) {
        return $string;
    }

    $string = mb_substr($string, 0, $length);
    $string = rtrim($string, "!,.-");
    $string = mb_substr($string, 0, mb_strrpos($string, ' '));
    return $string . "…";
}

/**
 * Escape HTML special chars
 * @param string $str Input string
 * @return string Escaped string
 */
function h(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * Format price
 * @param float $price Price to format
 * @return string Formatted price
 */
function formatPrice(float $price): string
{
    return number_format($price, 2, '.', ' ') . ' $';
}

/**
 * Get product image with fallback
 * @param string|null $image Image filename
 * @param string $type Type of image (product, gallery, etc.)
 * @return string Image path
 */
function getImage(?string $image, string $type = 'products'): string
{
    $noImage = '/assets/images/no_image.jpg';

    if (empty($image)) {
        return $noImage;
    }

    $imagePath = "/uploads/images/{$image}";
    $absolutePath = WWW . $imagePath;

    if (file_exists($absolutePath)) {
        return $imagePath;
    }
    return $noImage;
}
