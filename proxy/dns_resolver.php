<?php
if (isset($_GET['url'])) {
    $url = urldecode($_GET['url']);
    $host = parse_url($url, PHP_URL_HOST);

    if ($host) {
        $ip = gethostbyname($host);
        echo $ip;
    } else {
        echo "";
    }
} else {
    echo "";
}
?>
