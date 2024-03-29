<?php
//error_reporting(E_ALL ^ E_WARNING);
//ini_set('display_errors', 1); 

require_once 'WebUtil.php';
use DomUtil\WebUtil as WebUtil;

// -------------------------------
// Parse Options from Command Line
// -------------------------------

    $opts = array(
        'fetchUpdate' => true,
        'profileName' => 'Dom',
        'profileURL' => 'http://github.com/dgendill'
    );

    $shortcmo = "un::l::";
    $longcmo = array("update","name::","url::");
    $cmo = getopt($shortcmo, $longcmo);

    //var_dump($cmo);

    if (isset($cmo['u']) || isset($cmo['update'])) {
        $opts['fetchUpdate'] = true;
    }

    if (isset($cmo['n']) || isset($cmo['name'])) {
        $opts['profileName'] = $cmo['name'];
    }

    if (isset($cmo['u']) || isset($cmo['url'])) {
        $opts['profileURL'] = $cmo['url'];
    }

// --------------------------------
// Fetch and Parse HTML from GitHub
// --------------------------------

    $profileName = $opts['profileName'];
    $file = dirname(__FILE__) . "/" . $profileName . ".html";
    $repoFile = dirname(__FILE__) . "/" . $opts['profileName'] . "RepoList.txt";
    $profileURL = $opts['profileURL'];
    $fetchUpdate = $opts['fetchUpdate'];
    $web = new WebUtil();

    if (file_exists($file) && ($fetchUpdate === false)) {
        print "Fetching repositories from cache...\n";
        $html = file_get_contents($file);
    } else {
        print "Fetching repositories from github...";
        $html = $web->getResource($profileURL);

        if ($html['content'] !== FALSE) {
            print "Writing content to $file...\n";
            file_put_contents($file, $html['content']);
        }
        $html = $html['content'];
    }

    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    $head = $xpath->query('//*[@id="site-container"]/div/div/div[2]/div[2]/div/ul/li');
    $length = $head->length;
    $projects = [];

    print "Parsing HTML...\n";

    for($i = 0; $i < $length; $i++) {
        $context = $head->item($i);
        
        $nameNode = $xpath->query('h3/a', $context);
        $urlNode = $xpath->query('h3/a/@href', $context);
        
        $name = $nameNode->item(0)->nodeValue;
        $url = "https://github.com" . $urlNode->item(0)->nodeValue . ".git";

        array_push($projects, $name . "||||" . $url);
    }

    file_put_contents($repoFile, implode($projects, "\n"));
    print "Done. $repoFile has been written.\n"





?>