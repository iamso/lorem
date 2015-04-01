<?
$types = array(
	'lorem',
	//'gibberish',
	'nonsense'
);
$formats = array(
	'plain',
	'p',
	'ul',
	'ol',
	'h1',
	'h2',
	'h3',
	'h4',
	'h5',
	'h6',
	//'article'
);
$count = 1;
$error = false;
$output = '';
$type = $format = 'unknown';
$words = array('unknown');
$content_type = 'text/html';

$data = isset($_REQUEST['data']) ? rtrim(ltrim($_REQUEST['data'],'/'),'/') : false;

if ($data) {
	if (strpos($data, '/') !== false) {
		$params = explode('/',$data);
		if (sizeof($params) >= 3) {
			$type = $params[0];
			strpos($params[1], '-') !== false ? list($format,$count) = explode('-', $params[1]) : $format = $params[1];
			$words = explode('-', $params[2]);
			if (in_array($type, $types)) {
				if (in_array($format, $formats)) {
					foreach($words as $value) {
						if (!is_numeric($value)) {
							$error = true;
							$output = 'length error';
							$words = array('unknown');
						}
					}
					
					if (!$error) {
						$count = $count && is_numeric($count) ? $count : 1;
												
						switch($format) {
							case 'plain':
								$content_type = 'text/plain';
								for ($i = 1; $i <= $count; $i++) {
									$output .= getWords($type,$words,true,($i == 1 ? true : false));
									if ($i != $count) $output .= "\n\n";
								}
								break;
							case 'p':
								for ($i = 1; $i <= $count; $i++) {
									$output .= '<p>'.getWords($type,$words,true,($i == 1 ? true : false)).'</p>';
								}								
								break;
							case 'ul':
							case 'ol':
								$output .= '<'.$format.'>';
								for ($i = 1; $i <= $count; $i++) {
									$output .= '<li>'.getWords($type,$words,true,($i == 1 ? true : false)).'</li>';
								}
								$output .= '</'.$format.'>';
								break;
							case 'h1':
							case 'h2':
							case 'h3':
							case 'h4':
							case 'h5':
							case 'h6':
								$count = 1;
								$output .= '<'.$format.'>'.getWords($type,$words,false).'</'.$format.'>';
								break;
							case 'article':
								break;
						}						
					}
					
				}
				else {
					$error = true;
					$output = 'format unknown';
					$format = 'unknown';
				}
			}
			else {
				$error = true;
				$output = 'type unknown';
				$type = 'unknown';
			}
		}
		else {
			$error = true;
			$output = 'not enough params';
		}
	}
	else {
		$error = true;
		$output = 'data not ok';
	}
}
else {
	$error = true;
	$output = 'no data';
}
if (!ini_get('zlib.output_compression')) {
	ob_start("ob_gzhandler");
}
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, client-security-token");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	header('Content-type: '.$content_type);
	echo $output;
}

else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	header('Content-type: application/json');
	echo json_encode(array('status' => $error ? 'error' : 'ok', 'type' => $type, 'format' => $format, 'count' => $count, 'words' => $words[0].(array_key_exists(1, $words) ? '-'.$words[1] : ''), 'time' => time(), 'output' => $output));
}

function getWordCount($words) {
	return rand($words[0], array_key_exists(1, $words) ? $words[1] : $words[0]);
}
function getWords($type,$words,$punctuation = true,$lorem = false) {
	switch($type) {
		case 'lorem':
			require_once('libs/LoremIpsum.class.php');
			$generator = new LoremIpsumGenerator;
			//$output = $generator->getContent(getWordCount($words), 'plain', false);
			$output = rtrim(str_replace('.', ',', $generator->getContent(getWordCount($words), 'plain', $lorem)), ', ').'.';
			break;
		
		case 'gibberish':
			//break;
		case 'nonsense':
			require_once('libs/nonsense.php');
			$nonsense = new Nonsense();
			$output = $nonsense->word(getWordCount($words)).'.';
			break;
	}
	if (!$punctuation) {
		$output = str_replace('.', '', $output);
	}
	return firstLetterUp($output);
}
function firstLetterUp($input) {
	return preg_replace_callback('/([.!?])\s*(\w)/', function ($matches) {
	    return strtoupper($matches[1] . ' ' . $matches[2]);
	}, ucfirst(strtolower($input)));
}
?>