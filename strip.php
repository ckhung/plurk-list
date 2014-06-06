#!/usr/bin/php
<?php
require_once 'QueryPath/QueryPath.php';

foreach (array_slice($argv,1) as $entry) {
    $qp = htmlqp($entry);
    preg_match("#(\w+)\.html#", $entry, $url);
    $url = "http://www.plurk.com/p/" . $url[1];
    $qp->find(".bigplurk");
    if ($qp->is("div.user")) {
	// data is from rss
	$qp->find("div.content");
	$qp->remove("div.avatar");
	$verb = $qp->remove("span.qualifier");
	$date = $qp->remove("time")->attr("datetime");
	$qp->remove("div.user");
	$t = " " . $verb->html() . "\n" . $qp->find("span.plurk_content")->innerHTML();
    } else {
	// data is from official plurk backup
	$qp->remove("a:first");
	$date = $qp->remove("div.meta")->text();
	if (preg_match('/private/', $date)) continue;
	$t = rtrim($qp->innerHTML());
    }
    $date = preg_replace(
	"/(\d{4})-(\d\d)-(\d\d).*?(\d\d):(\d\d):\d\d.*/",
	"$1-$2-$3 $4:$5", $date
    );
    echo "<li><a href='$url'>$date</a> $t</li>\n\n";
}
?>
