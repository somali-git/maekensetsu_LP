<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo get_bloginfo('description') ? get_bloginfo('description') : '信頼と品質をモットーとした建設会社。住宅建築からリフォーム、公共工事まで豊富な実績でお客様の夢を形にします。'; ?>">
    <meta name="keywords" content="建設会社, 住宅建築, リフォーム, 施工実績, 建築設計, 工事">
    <meta name="author" content="<?php echo get_theme_mod('company_name', get_bloginfo('name')); ?>">
    
    <!-- Open Graph tags -->
    <meta property="og:title" content="<?php wp_title('|', true, 'right'); echo get_bloginfo('name'); ?>">
    <meta property="og:description" content="<?php echo get_bloginfo('description') ? get_bloginfo('description') : '信頼と品質をモットーとした建設会社'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo home_url('/'); ?>">
    <meta property="og:site_name" content="<?php echo get_theme_mod('company_name', get_bloginfo('name')); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <div class="header-container">
        <a href="<?php echo home_url('/'); ?>" class="site-title">
            <?php 
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo get_theme_mod('company_name', get_bloginfo('name'));
            }
            ?>
        </a>
        
        <nav class="main-nav">
            <button class="mobile-menu-toggle" style="display: none; background: none; border: none; color: var(--white); font-size: 1.5rem; cursor: pointer;" aria-label="メニューを開く">
                ☰
            </button>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'main-menu',
                'container' => false,
                'fallback_cb' => 'construction_fallback_menu'
            ));
            ?>
        </nav>
    </div>
</header>

<?php
// フォールバックメニュー関数
function construction_fallback_menu() {
    echo '<ul class="main-menu">';
    echo '<li><a href="' . home_url('/') . '">ホーム</a></li>';
    echo '<li><a href="' . home_url('/#company') . '">会社情報</a></li>';
    echo '<li><a href="' . home_url('/#president') . '">代表挨拶</a></li>';
    echo '<li><a href="' . get_post_type_archive_link('portfolio') . '">施工実績</a></li>';
    echo '</ul>';
}
?>
