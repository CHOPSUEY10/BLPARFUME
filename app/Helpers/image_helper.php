<?php

if (!function_exists('product_image_url')) {
    /**
     * Get product image URL with fallback
     */
    function product_image_url($imageName = null, $fallback = 'parfume-1.jpg')
    {
        if (empty($imageName)) {
            return base_url('assets/images/' . $fallback);
        }
        
        $imagePath = ROOTPATH . 'public/uploads/products/' . $imageName;
        
        if (file_exists($imagePath)) {
            return base_url('uploads/products/' . $imageName);
        }
        
        return base_url('assets/images/' . $fallback);
    }
}

if (!function_exists('format_rupiah')) {
    /**
     * Format number to Rupiah currency
     */
    function format_rupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Truncate text with ellipsis
     */
    function truncate_text($text, $length = 50)
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . '...';
    }
}

if (!function_exists('resize_image')) {
    /**
     * Resize image to specified dimensions
     */
    function resize_image($sourcePath, $targetPath, $maxWidth = 800, $maxHeight = 600, $quality = 85)
    {
        if (!file_exists($sourcePath)) {
            return false;
        }
        
        // Get image info
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return false;
        }
        
        $sourceWidth = $imageInfo[0];
        $sourceHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Calculate new dimensions
        $ratio = min($maxWidth / $sourceWidth, $maxHeight / $sourceHeight);
        
        // If image is already smaller, don't resize
        if ($ratio >= 1) {
            return copy($sourcePath, $targetPath);
        }
        
        $newWidth = round($sourceWidth * $ratio);
        $newHeight = round($sourceHeight * $ratio);
        
        // Create source image
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            default:
                return false;
        }
        
        if (!$sourceImage) {
            return false;
        }
        
        // Create target image
        $targetImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG and GIF
        if ($mimeType == 'image/png' || $mimeType == 'image/gif') {
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
            $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
            imagefilledrectangle($targetImage, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        // Resize image
        imagecopyresampled($targetImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);
        
        // Save image
        $result = false;
        switch ($mimeType) {
            case 'image/jpeg':
                $result = imagejpeg($targetImage, $targetPath, $quality);
                break;
            case 'image/png':
                $result = imagepng($targetImage, $targetPath, round(9 * (100 - $quality) / 100));
                break;
            case 'image/gif':
                $result = imagegif($targetImage, $targetPath);
                break;
        }
        
        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($targetImage);
        
        return $result;
    }
}

if (!function_exists('validate_image_file')) {
    /**
     * Validate uploaded image file
     */
    function validate_image_file($file, $maxSize = 2048000) // 2MB default
    {
        $errors = [];
        
        if (!$file || !$file->isValid()) {
            $errors[] = 'File tidak valid';
            return $errors;
        }
        
        // Check file size
        if ($file->getSize() > $maxSize) {
            $errors[] = 'Ukuran file terlalu besar (maksimal ' . ($maxSize / 1024 / 1024) . 'MB)';
        }
        
        // Check file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            $errors[] = 'Format file tidak didukung (hanya JPG, PNG, GIF)';
        }
        
        // Check file extension
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower($file->getClientExtension());
        if (!in_array($extension, $allowedExtensions)) {
            $errors[] = 'Ekstensi file tidak valid';
        }
        
        return $errors;
    }
}