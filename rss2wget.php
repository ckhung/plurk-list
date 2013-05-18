<?php
# wget http://www.plurk.com/ckhung0.xml

require_once 'QueryPath/QueryPath.php';

$qp = htmlqp($argv[1]);
foreach ($qp->find("entry link") as $entry) {
    $path = $entry->attr("href");
    preg_match("#/(\w+)$#", $path, $matches);
    echo "sleep 5; wget http://www.plurk.com$path -O $matches[1].html\n";
}
?>
