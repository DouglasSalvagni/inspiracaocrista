<?php

class Media_Helper
{
    /**
     * Get the URL of a media file from the assets folder in the theme root.
     *
     * @param string $filename The name of the media file.
     * @return string The URL of the media file.
     */
    public static function get_asset_url($filename)
    {
        // Get the theme root URI
        $theme_root_uri = get_template_directory_uri();

        // Build the full URL to the asset
        $asset_url = $theme_root_uri . '/assets/' . $filename;

        // Return the URL
        return esc_url($asset_url);
    }
}
