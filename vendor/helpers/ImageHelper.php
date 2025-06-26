<?php 
class ImageHelper {
    protected static $allowedExts = ["gif", "jpeg", "jpg", "png"];
    public static function uploadMultipleSizesImg($files, $name = "image")
    {
        if ($name == null && count($files) == 1) $name = array_keys($files)[0];
        $arrt = explode("/", $files[$name]["type"]);
        $type = end($arrt);
        if (($files[$name]["size"] < 200000000) && in_array($type, self::$allowedExts)) {
            if ($files[$name]["error"] > 0) {
                return false;
            }

            $newfn = str_replace('/', '-', date("Y/m/d")) . '-' . time() . rand(10000, 99999) . '.' . $type;

            $tmpDir = RootURI . UploadREL . 'posts/tmp/';
            if (!file_exists($tmpDir)) mkdir($tmpDir, 0777, true);
            $tmpPath = $tmpDir . $newfn;
            move_uploaded_file($files[$name]['tmp_name'], $tmpPath);

            $sizes = [
                'posts/thumbs'   => 143,
                'posts/cards'    => 354,
                'posts/featured' => 641,
            ];
            $original = new SimpleImageComponent($tmpPath);
            foreach ($sizes as $folder => $width) {
                $saveDir = RootURI . UploadREL . $folder . '/';
                if (!file_exists($saveDir)) mkdir($saveDir, 0777, true);

                $savePath = $saveDir . $newfn;
                $clone = clone $original;
                $clone->resizeToWidth($width);
                $clone->saveResize($savePath);
            }

            // @unlink($tmpPath);

            return '/' . $newfn;
        }

        return false;
    }
}