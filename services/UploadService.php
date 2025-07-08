<?php
class UploadService {
    public static function upload($file, $options = [], $name = 'image') {
        $allowedExts = ["gif", "jpeg", "jpg", "png"];
        $typeParts = explode("/", $file["type"]);
        $ext = strtolower(end($typeParts));

        if (!in_array($ext, $allowedExts) || $file["error"] !== UPLOAD_ERR_OK) return false;

        $folder = $options['folder'] ?? 'uploads';
        $datePath = date("Y/m/d");
        $uploadDir = RootURI . UploadREL . $folder . '/' . $datePath . '/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = str_replace("/", "-", $datePath) . '-' . time() . rand(1000, 9999) . '.' . $ext;
        $filepath = $uploadDir . $filename;

        move_uploaded_file($file["tmp_name"], $filepath);

        if (!($options['origin'] ?? false)) {
            $img = new SimpleImageComponent($filepath);
            if (isset($options['newSize']['height']) && !isset($options['newSize']['width'])) {
                $img->resizeToHeight($options['newSize']['height']);
            } else {
                $newW = $options['newSize']['width'] ?? DefaultImgW;
                $img->resizeToWidth($newW);
            }
            $img->saveResize($filepath);
        }

        return $folder . '/' . $datePath . '/' . $filename;
    }
}
