#!/usr/bin/php
<?php
# wget http://www.plurk.com/ckhung0.xml
# rss2html.php $(ls *.xml | sort -r)

require_once 'QueryPath/qp.php';

$V = array(
    '分享' => 'shares',
    '問' => 'asks',
    '喜歡' => 'likes',
    '好奇' => 'wonders',
    '已經' => 'has',
    '想要' => 'wants',
    '打算' => 'will',
    '期待' => 'wishes',
    '覺得' => 'feels',
    '說' => 'says',
    '需要' => 'needs',
    '討厭' => 'hates',
    '轉噗' => 'replurks',
    '转噗' => 'replurks',
    'replurks' => 'replurks',
);

$last_url = '/p/zzzzzz';
$last_month = '';
for ($i=1; $i<count($argv); ++$i) {
    $qp = qp($argv[$i]);
    foreach ($qp->find("entry") as $entry) {
	$url = $entry->find("link")->attr("href");
	if ($url < $last_url)
	    $last_url = $url;
	else
	    continue;
	$date = $entry->find("published")->text();
	preg_match('/(\d+)-(\d+)-(\d+).*(\d+)(:\d+)/', $date, $m);
	$date = sprintf("$m[1]-$m[2]-$m[3] %02d$m[5]", $m[4]);
	if ($m[2] != $last_month) {
	    print <<<EOF
</ul>

<h3 class='month'>$m[1]年$m[2]月</h3>

<ul class='plurk'>

EOF;
	    $last_month = $m[2];
	}
	$content = $entry->find("content")->text();
	preg_match('/^(\w+) (\S+) (.*)/', $content, $m);
	if (isset($V[$m[2]])) {
	    $verb = $V[$m[2]];
	    if ($m[2] == 'replurks') $m[2] = '轉噗';
	    $verb = "<span class='qualifier q_$verb'>$m[2]</span>\n";
	    $content = $m[3];
	} else {
	    if (strlen($m[2]) <= 9) {
		fwrite(STDERR, "error: '$m[2]' is an unknown verb\n");
	    } else {
		fwrite(STDERR, "warning: $url does not have a verb\n");
	    }
	    $verb = "";
	    $content = "$m[2] $m[3]";
	}
	echo "<li><a href='http://www.plurk.com$url'>$date</a>  $verb$content</li>\n\n";
    }
}

?>


