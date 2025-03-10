<?php
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
require_once(realpath(dirname(__FILE__) . '/includes/sqldb.inc.php'));
require_once(realpath(dirname(__FILE__) . '/includes/Mobile_Detect.php'));
$detect = new Mobile_Detect;
$query_gs = $file_db->prepare("SELECT page_title, page_meta_description FROM general_settings LIMIT 1");
$query_gs->execute();
$data_gs = $query_gs->fetch(PDO::FETCH_ASSOC);
$page_title = htmlspecialchars($data_gs['page_title'] ?? '', ENT_QUOTES, 'UTF-8');
$page_meta_description = htmlspecialchars($data_gs['page_meta_description'] ?? '', ENT_QUOTES, 'UTF-8');
$site_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$site_url = htmlspecialchars($site_url, ENT_QUOTES, 'UTF-8');
$query_dcs = $file_db->prepare("SELECT color_mode FROM design_colors LIMIT 1");
$query_dcs->execute();
$data_dcs = $query_dcs->fetch(PDO::FETCH_ASSOC);
$color_mode = htmlspecialchars($data_dcs['color_mode'] ?? '', ENT_QUOTES, 'UTF-8');
$query_sacc = $file_db->prepare("SELECT accent_color FROM accent_color LIMIT 1");
$query_sacc->execute();
$data_sacc = $query_sacc->fetch(PDO::FETCH_ASSOC);
$accent_color = htmlspecialchars($data_sacc['accent_color'] ?? '', ENT_QUOTES, 'UTF-8');
$query_ga = $file_db->prepare("SELECT ga_id FROM ga_id LIMIT 1");
$query_ga->execute();
$data_ga = $query_ga->fetch(PDO::FETCH_ASSOC);
$ga_id = htmlspecialchars($data_ga['ga_id'] ?? '', ENT_QUOTES, 'UTF-8');
$query_daccs = $file_db->prepare("SELECT d_acc FROM d_acc LIMIT 1");
$query_daccs->execute();
$data_daccs = $query_daccs->fetch(PDO::FETCH_ASSOC);
$device_access = htmlspecialchars($data_daccs['d_acc'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title><?= $page_title ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="description" content="<?= $page_meta_description ?>" />    
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="icon" type="image/ico" href="assets/img/favicon.ico" />
		<!-- Open Graph Meta Tags-->
		<meta property="og:title" content="<?= $page_title ?>" />
		<meta property="og:description" content="<?= $page_meta_description ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?= $site_url ?>" />
		<!-- Twitter Meta -->
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?= $page_title ?>" />
		<meta name="twitter:description" content="<?= $page_meta_description ?>" />
		<meta name="twitter:image" content="http://www.mywebsiteurl.com/twitter-share-image.jpg" />
		<!-- Icons -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Two+Tone|" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
		<!-- CSS -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet" />  
		<link href="assets/css/animate.css" rel="stylesheet" />
		<link href="assets/css/magnific-popup.css" rel="stylesheet" />
		<link href="assets/css/slick.css" rel="stylesheet" />
		<link href="assets/css/style.css" rel="stylesheet" />
		<?php if ($color_mode === 'light') : ?>
			<link href="assets/css/lm.css" rel="stylesheet" />
		<?php elseif ($color_mode === 'dark') : ?>
			<link href="assets/css/dm.css" rel="stylesheet" />
		<?php endif; ?>
		<link href="assets/css/<?= $accent_color ?>.css" rel="stylesheet" />
		
		<?php if ($ga_id !== '') : ?>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $ga_id ?>"></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());			  	
			  gtag('config', '<?= $ga_id ?>');
			</script>
		<?php endif; ?>
	</head>
	<?php
	if ($device_access === 'desktop') {
		require 'includes/i-d.php';
	} elseif ($device_access === 'mobile') {
		if ($detect->isMobile()) {
			require 'includes/i-d.php';
		} else {
			require 'includes/i-nd.php';
		}
	}	
	?>
	<!-- JS -->	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>	
	<script type="text/javascript" src="assets/js/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="assets/js/slick.min.js"></script>
	<script type="text/javascript" src="assets/js/particles.min.js"></script>
	<script type="text/javascript" src="assets/js/main.js"></script>
</html>