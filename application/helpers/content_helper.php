<?php
if (!function_exists('extract_first_image')) {
    function extract_first_image($content) {
        $doc = new DOMDocument();
        @$doc->loadHTML($content);
        $images = $doc->getElementsByTagName('img');
        if ($images->length > 0) {
            $src = $images->item(0)->getAttribute('src');
            if (strpos($src, 'http') !== 0) {
                $src = base_url($src);
            }
            return $src;
        }
        return null;
    }
}
?>