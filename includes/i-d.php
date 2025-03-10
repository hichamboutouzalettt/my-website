<?php
$query_dcs = $file_db->prepare("SELECT color_mode FROM design_colors LIMIT 1");
$query_dcs->execute();
$data_dcs = $query_dcs->fetch(PDO::FETCH_ASSOC);
$color_mode = htmlspecialchars($data_dcs['color_mode'] ?? '', ENT_QUOTES, 'UTF-8');

$query_hs = $file_db->prepare("SELECT header_logo_img_src, header_title, header_subtitle, header_particles FROM header_settings LIMIT 1");
$query_hs->execute();
$data_hs = $query_hs->fetch(PDO::FETCH_ASSOC);

$header_logo = htmlspecialchars($data_hs['header_logo_img_src'] ?? '', ENT_QUOTES, 'UTF-8');
$header_title = htmlspecialchars($data_hs['header_title'] ?? '', ENT_QUOTES, 'UTF-8');
$header_subtitle = htmlspecialchars($data_hs['header_subtitle'] ?? '', ENT_QUOTES, 'UTF-8');
$header_particles = (int)($data_hs['header_particles'] ?? 0);

$query_hps = $file_db->prepare("SELECT hp_string_featured_title, hp_string_all_title, hp_string_search FROM hps LIMIT 1");
$query_hps->execute();
$data_hps = $query_hps->fetch(PDO::FETCH_ASSOC);

$featured_title = htmlspecialchars($data_hps['hp_string_featured_title'] ?? '', ENT_QUOTES, 'UTF-8');
$all_title = htmlspecialchars($data_hps['hp_string_all_title'] ?? '', ENT_QUOTES, 'UTF-8');
$search_placeholder = htmlspecialchars($data_hps['hp_string_search'] ?? '', ENT_QUOTES, 'UTF-8');

?>
<body class="page-body <?= $color_mode === 'light' ? 'cm-l' : 'cm-d' ?>">	
	<div id="preloader" class="preloader-wrapper">
		<div class="preloader-inner-wrapper">
			<div class="ball-scale-multiple"><div></div><div></div><div></div></div>
		</div>
	</div>
	<header class="page-header">
		<div class="container">
			<div class="logo-wrapper">
				<?php if ($header_logo !== '') : ?>
					<img src="<?= $header_logo ?>" class="img-fluid header-logo-img" alt="Logo" />
				<?php endif; ?>
			</div>
			<div class="header-content-wrapper">
				<h1 class="header-title"><?= htmlspecialchars_decode($header_title, ENT_QUOTES) ?></h1>
				<p class="header-subtitle"><?= htmlspecialchars_decode($header_subtitle, ENT_QUOTES) ?></p>
			</div>
		</div>
		<?php if ($header_particles === 1) : ?>
			<div id="header-particles"></div>
		<?php endif; ?>			
	</header>
	<section class="featured-section">
		<div class="container">
			<div class="section-title-wrapper">
				<h3><?= htmlspecialchars_decode($featured_title, ENT_QUOTES) ?></h3>
			</div>
			<div class="featured-apps-content">
				<div class="featured-apps-slider">
					<?php
					$query_featured_apps = $file_db->prepare("SELECT app_locker_url, app_img_src, app_name, app_rating, app_author, app_os, app_description, app_downloads, app_short_name FROM apps WHERE app_featured = 1");
					$query_featured_apps->execute();
					while ($data_featured_apps = $query_featured_apps->fetch(PDO::FETCH_ASSOC)) :
						$app_locker_url = htmlspecialchars($data_featured_apps['app_locker_url'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_img_src = htmlspecialchars($data_featured_apps['app_img_src'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_name = htmlspecialchars_decode($data_featured_apps['app_name'] ?? '', ENT_QUOTES);
						$app_rating = htmlspecialchars($data_featured_apps['app_rating'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_author = htmlspecialchars_decode($data_featured_apps['app_author'] ?? '', ENT_QUOTES);
						$app_os = htmlspecialchars($data_featured_apps['app_os'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_description = htmlspecialchars_decode($data_featured_apps['app_description'] ?? '', ENT_QUOTES);
						$app_downloads = htmlspecialchars($data_featured_apps['app_downloads'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_short_name = htmlspecialchars($data_featured_apps['app_short_name'] ?? '', ENT_QUOTES, 'UTF-8');
					?>
					<div class="featured-app-slider-item lit lit-t" data-lrurl="<?= $app_locker_url ?>">
						<img src="<?= $app_img_src ?>" class="featured-app-slider-item-img liti img-fluid" alt="<?= $app_name ?> Logo"/>
						<div class="featured-app-slider-item-name litn"><?= $app_name ?></div>
						<?php if ($app_rating !== '') : ?>
							<div class="listing-item-rating">
								<span class="listing-item-rating-separator"></span>
								<span class="material-icons-two-tone">star</span>
								<span class="listing-item-rating-val"><?= $app_rating ?></span>
							</div>
						<?php endif; ?>
						<div class="featued-app-slider-item-hidden-meta">
							<?php if ($app_author !== '') : ?>
								<div class="listing-item-by">Author: <span class="listing-item-by-val"><?= $app_author ?></span></div>
							<?php endif; ?>
							<div class="listing-item-os">
								<?php if ($app_os === 'androidios') : ?>
									<i class="fab fa-android imr"></i><i class="fab fa-apple"></i>
								<?php elseif ($app_os === 'android') : ?>
									<i class="fab fa-android"></i>
								<?php elseif ($app_os === 'ios') : ?>
									<i class="fab fa-apple"></i>
								<?php endif; ?>
							</div>
							<div class="listing-item-about"><?= $app_description ?></div>
							<?php if ($app_downloads !== '') : ?>
								<div class="listing-item-downloads-val"><?= $app_downloads ?></div>
							<?php endif; ?>
							<?php if ($app_short_name !== '') : ?>
								<div class="listing-item-short-name litsn"><?= $app_short_name ?></div>
							<?php endif; ?>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</section>
	<section class="listing-section">
		<div class="container">				
			<div class="section-title-wrapper">
				<h3><?= htmlspecialchars_decode($all_title, ENT_QUOTES) ?></h3>
				<div class="search-form-wrapper">
					<div id="search-form">
						<div class="search-input-wrapper">
							<span class="material-icons-two-tone">search</span>
							<input type="text" class="search-input" id="search-input" placeholder="<?= htmlspecialchars_decode($search_placeholder, ENT_QUOTES) ?>"/>
						</div>
					</div>
				</div>
			</div>
			<div class="listing-content">
				<div class="row">
					<?php
					$query_apps = $file_db->prepare("SELECT app_locker_url, app_img_src, app_name, app_author, app_os, app_rating, app_description, app_downloads, app_short_name FROM apps ORDER BY app_display_order ASC");
					$query_apps->execute();
					while ($data_apps = $query_apps->fetch(PDO::FETCH_ASSOC)) :
						$app_locker_url = htmlspecialchars($data_apps['app_locker_url'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_img_src = htmlspecialchars($data_apps['app_img_src'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_name = htmlspecialchars_decode($data_apps['app_name'] ?? '', ENT_QUOTES);
						$app_author = htmlspecialchars_decode($data_apps['app_author'] ?? '', ENT_QUOTES);
						$app_os = htmlspecialchars($data_apps['app_os'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_rating = htmlspecialchars($data_apps['app_rating'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_description = htmlspecialchars_decode($data_apps['app_description'] ?? '', ENT_QUOTES);
						$app_downloads = htmlspecialchars($data_apps['app_downloads'] ?? '', ENT_QUOTES, 'UTF-8');
						$app_short_name = htmlspecialchars($data_apps['app_short_name'] ?? '', ENT_QUOTES, 'UTF-8');
					?>
					<div class="listing-item-wrapper col-md-6">
						<div class="listing-item lit lit-t" data-lrurl="<?= $app_locker_url ?>">
							<div class="listing-item-left">
								<img src="<?= $app_img_src ?>" class="img-fluid listing-item-img liti" alt="<?= $app_name ?> Logo"/>
							</div>
							<div class="listing-item-right">
								<div class="listing-item-auos">
									<?php if ($app_author !== '') : ?>
										<div class="listing-item-by">Author: <span class="listing-item-by-val"><?= $app_author ?></span></div>
									<?php endif; ?>
									<div class="listing-item-os">
										<?php if ($app_os === 'androidios') : ?>
											<i class="fab fa-android imr"></i><i class="fab fa-apple"></i>
										<?php elseif ($app_os === 'android') : ?>
											<i class="fab fa-android"></i>
										<?php elseif ($app_os === 'ios') : ?>
											<i class="fab fa-apple"></i>
										<?php endif; ?>
									</div>
								</div>
								<div class="listing-item-name-rating-wrapper">
									<div class="listing-item-name litn"><?= $app_name ?></div>
									<?php if ($app_rating !== '') : ?>
										<div class="listing-item-rating">
											<span class="listing-item-rating-separator"></span>
											<span class="material-icons-two-tone">star</span>
											<span class="listing-item-rating-val"><?= $app_rating ?></span>
										</div>
									<?php endif; ?>
								</div>
								<div class="listing-item-about"><?= $app_description ?></div>
								<div class="listing-item-hidden-d">
									<?php if ($app_downloads !== '') : ?>
										<div class="listing-item-downloads-val"><?= $app_downloads ?></div>
									<?php endif; ?>
									<?php if ($app_short_name !== '') : ?>
										<div class="listing-item-short-name litsn"><?= $app_short_name ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
	$query_fs = $file_db->prepare("SELECT footer_content FROM footer_settings LIMIT 1");
	$query_fs->execute();
	$data_fs = $query_fs->fetch(PDO::FETCH_ASSOC);
	$footer_content = htmlspecialchars($data_fs['footer_content'] ?? '', ENT_QUOTES, 'UTF-8');
	if ($footer_content !== '') :
	?>
	<footer>
		<div class="container">
			<div class="footer-content">
				<p><?= htmlspecialchars_decode($footer_content, ENT_QUOTES) ?></p>
			</div>
		</div>
	</footer>
	<?php endif; ?>
</body>