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

$query_daccc = $file_db->prepare("SELECT d_acc_title, d_acc_content FROM d_acc LIMIT 1");
$query_daccc->execute();
$data_daccc = $query_daccc->fetch(PDO::FETCH_ASSOC);

$d_acc_title = htmlspecialchars($data_daccc['d_acc_title'] ?? '', ENT_QUOTES, 'UTF-8');
$d_acc_content = htmlspecialchars($data_daccc['d_acc_content'] ?? '', ENT_QUOTES, 'UTF-8');

$query_fs = $file_db->prepare("SELECT footer_content FROM footer_settings LIMIT 1");
$query_fs->execute();
$data_fs = $query_fs->fetch(PDO::FETCH_ASSOC);
$footer_content = htmlspecialchars($data_fs['footer_content'] ?? '', ENT_QUOTES, 'UTF-8');
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
                    <img src="<?= htmlspecialchars_decode($header_logo, ENT_QUOTES) ?>" class="img-fluid header-logo-img" alt="Logo" />
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
    <section class="d-b-section">
        <div class="container">    
            <div class="d-b-notice-wrapper">    
                <span class="material-icons-two-tone">screen_lock_portrait</span>
                <h2><?= htmlspecialchars_decode($d_acc_title, ENT_QUOTES) ?></h2>
                <p><?= htmlspecialchars_decode($d_acc_content, ENT_QUOTES) ?></p>
            </div>
        </div>
    </section>
    <?php if ($footer_content !== '') : ?>
    <footer>
        <div class="container">
            <div class="footer-content">
                <p><?= htmlspecialchars_decode($footer_content, ENT_QUOTES) ?></p>
            </div>
        </div>
    </footer>
    <?php endif; ?>
</body>