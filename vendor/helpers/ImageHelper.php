<?php 
class ImageHelper {
    protected static $allowedExts = ["gif", "jpeg", "jpg", "png"];
    public static function uploadMultipleSizesImg($files, $name = "image")
    {
        ini_set('log_errors', 1);
        ini_set('error_log', __DIR__ . '/php-error.log');

        if ($name == null && count($files) == 1) $name = array_keys($files)[0];
        
        if (!isset($files[$name])) {
            error_log("No file found with name key: $name");
            return false;
        }

        $arrt = explode("/", $files[$name]["type"]);
        $type = end($arrt);

        error_log("Uploading image type: $type");

        if (($files[$name]["size"] < 200000000) && in_array($type, self::$allowedExts)) {
            if ($files[$name]["error"] > 0) {
                error_log("Upload error code: " . $files[$name]["error"]);
                return false;
            }

            $newfn = str_replace('/', '-', date("Y/m/d")) . '-' . time() . rand(10000, 99999) . '.' . $type;

            $tmpDir = RootURI . UploadREL . 'posts/tmp/';
            if (!file_exists($tmpDir)) mkdir($tmpDir, 0777, true);

            $tmpPath = $tmpDir . $newfn;

            // Kiểm tra move_uploaded_file
            if (!move_uploaded_file($files[$name]['tmp_name'], $tmpPath)) {
                error_log("move_uploaded_file failed to: $tmpPath");
                return false;
            }

            if (!file_exists($tmpPath)) {
                error_log("File not found at: $tmpPath");
                return false;
            }

            error_log("File moved to tmp path: $tmpPath");

            try {
                $original = new SimpleImageComponent($tmpPath);
            } catch (Exception $e) {
                error_log("Failed to load image: " . $e->getMessage());
                return false;
            }

            $sizes = [
                'posts/thumbs'   => 143,
                'posts/cards'    => 354,
                'posts/featured' => 641,
            ];

            foreach ($sizes as $folder => $width) {
                $saveDir = RootURI . UploadREL . $folder . '/';
                if (!file_exists($saveDir)) mkdir($saveDir, 0777, true);

                $savePath = $saveDir . $newfn;

                $clone = clone $original;
                $clone->resizeToWidth($width);

                if (!$clone->saveResize($savePath)) {
                    error_log("Failed to save resized image to: $savePath");
                } else {
                    error_log("Saved resized image to: $savePath");
                }
            }

            return '/' . $newfn;
        }

        error_log("Invalid file type or size: $type, size=" . $files[$name]["size"]);
        return false;
    }
}