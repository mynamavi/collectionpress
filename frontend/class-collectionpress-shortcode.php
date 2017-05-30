<?php
if (!defined('WPINC')) {
    die;
}

/**
 * Provides a short code renderer.
 */
class CollectionPress_ShortCode
{
    public function render($atts)
    {
        if (isset($atts["author"])) {
            if (isset($atts["list"]) && $atts["list"] == "recent") {
                $this->list_recent($atts["author"]);
            }
        }
    }

    public function list_recent($author)
    {
        $response = wp_remote_get($this->get_url('discover.json?q=author:"'.$author.'"'));

        $response = json_decode(wp_remote_retrieve_body($response));

        echo "<ul>";

        foreach ($response->response->docs as $doc) {
            echo "<li>".array_shift($doc->title)."</li>";
        }

        echo "</ul>";
    }

    public function get_url($endpoint)
    {
        $options = collectionpress_settings();

        $url = $options['rest_url'];

        return $url."/".$endpoint;
    }
}
