<?php
function resizeImage($imagePath, $newWidth, $newHeight, $folderName)
{
    // Kiểm tra định dạng hình ảnh
    $imageType = exif_imagetype($imagePath);
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($imagePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($imagePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($imagePath);
            break;
        default:
            return false;
    }

    // Lấy thông tin về kích thước ban đầu của hình ảnh
    $originalWidth = imagesx($sourceImage);
    $originalHeight = imagesy($sourceImage);

    // Tính toán tỷ lệ mới cho hình ảnh
    $aspectRatio = $originalWidth / $originalHeight;

    $newImageWidth = $newWidth;
    $newImageHeight = $newHeight;

    if ($aspectRatio < 1) {
        $newImageHeight = $newWidth / $aspectRatio;
    } else {
        $newImageWidth = $newHeight * $aspectRatio;
    }

    // Tạo hình ảnh mới với kích thước đã chỉ định
    $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $originalWidth, $originalHeight);

    // Tạo đường dẫn và tên mới cho hình ảnh đã thay đổi kích thước
    $newImagePath = "public/images/{$folderName}/resized_" . pathinfo($imagePath, PATHINFO_FILENAME);

    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $newImagePath .= '.jpg';
            imagejpeg($newImage, $newImagePath);
            break;
        case IMAGETYPE_PNG:
            $newImagePath .= '.png';
            imagepng($newImage, $newImagePath);
            break;
        case IMAGETYPE_GIF:
            $newImagePath .= '.gif';
            imagegif($newImage, $newImagePath);
            break;
    }

    // Giải phóng bộ nhớ
    imagedestroy($newImage);
    imagedestroy($sourceImage);

    // Trả về đường dẫn mới của hình ảnh
    return $newImagePath;
}
