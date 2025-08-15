<?php
/**
 * 建設会社用WordPressテーマの関数ファイル
 */

// テーマサポートの追加
function construction_theme_support() {
    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');
    
    // HTMLタイトルタグのサポート
    add_theme_support('title-tag');
    
    // カスタムロゴのサポート
    add_theme_support('custom-logo');
    
    // レスポンシブ埋め込みのサポート
    add_theme_support('responsive-embeds');
    
    // エディタースタイルのサポート
    add_theme_support('editor-styles');
    
    // ワイドアライメントのサポート
    add_theme_support('align-wide');
}
add_action('after_setup_theme', 'construction_theme_support');

// スタイルとスクリプトの読み込み
function construction_enqueue_scripts() {
    // メインスタイルシート
    wp_enqueue_style('construction-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap', array(), null);
    
    // メインJavaScript
    wp_enqueue_script('construction-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    
    // Ajax用の設定
    wp_localize_script('construction-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('construction_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'construction_enqueue_scripts');

// 施工実績カスタム投稿タイプの登録
function register_portfolio_post_type() {
    $labels = array(
        'name' => '施工実績',
        'singular_name' => '施工実績',
        'add_new' => '新規追加',
        'add_new_item' => '新しい施工実績を追加',
        'edit_item' => '施工実績を編集',
        'new_item' => '新しい施工実績',
        'view_item' => '施工実績を表示',
        'search_items' => '施工実績を検索',
        'not_found' => '施工実績が見つかりません',
        'not_found_in_trash' => 'ゴミ箱に施工実績はありません'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-hammer',
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'portfolio'),
        'show_in_rest' => true,
    );

    register_post_type('portfolio', $args);
}
add_action('init', 'register_portfolio_post_type');

// 施工実績カテゴリーのタクソノミー登録
function register_portfolio_taxonomy() {
    $labels = array(
        'name' => '施工カテゴリー',
        'singular_name' => '施工カテゴリー',
        'search_items' => 'カテゴリーを検索',
        'all_items' => 'すべてのカテゴリー',
        'parent_item' => '親カテゴリー',
        'parent_item_colon' => '親カテゴリー:',
        'edit_item' => 'カテゴリーを編集',
        'update_item' => 'カテゴリーを更新',
        'add_new_item' => '新しいカテゴリーを追加',
        'new_item_name' => '新しいカテゴリー名',
        'menu_name' => '施工カテゴリー',
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio-category'),
        'show_in_rest' => true,
    );

    register_taxonomy('portfolio_category', array('portfolio'), $args);
}
add_action('init', 'register_portfolio_taxonomy');

// カスタムフィールドの追加
function add_portfolio_meta_boxes() {
    add_meta_box(
        'portfolio_details',
        '施工詳細情報',
        'portfolio_details_callback',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_portfolio_meta_boxes');

function portfolio_details_callback($post) {
    wp_nonce_field('portfolio_details_nonce', 'portfolio_details_nonce');
    
    $client_name = get_post_meta($post->ID, '_client_name', true);
    $project_date = get_post_meta($post->ID, '_project_date', true);
    $project_location = get_post_meta($post->ID, '_project_location', true);
    $project_size = get_post_meta($post->ID, '_project_size', true);
    $project_budget = get_post_meta($post->ID, '_project_budget', true);
    $completion_period = get_post_meta($post->ID, '_completion_period', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="client_name">クライアント名</label></th>
            <td><input type="text" id="client_name" name="client_name" value="<?php echo esc_attr($client_name); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="project_date">施工日</label></th>
            <td><input type="date" id="project_date" name="project_date" value="<?php echo esc_attr($project_date); ?>" /></td>
        </tr>
        <tr>
            <th><label for="project_location">施工場所</label></th>
            <td><input type="text" id="project_location" name="project_location" value="<?php echo esc_attr($project_location); ?>" style="width: 100%;" /></td>
        </tr>
        <tr>
            <th><label for="project_size">施工規模</label></th>
            <td><input type="text" id="project_size" name="project_size" value="<?php echo esc_attr($project_size); ?>" style="width: 100%;" placeholder="例: 延床面積 120㎡" /></td>
        </tr>
        <tr>
            <th><label for="project_budget">予算</label></th>
            <td><input type="text" id="project_budget" name="project_budget" value="<?php echo esc_attr($project_budget); ?>" style="width: 100%;" placeholder="例: 3,000万円" /></td>
        </tr>
        <tr>
            <th><label for="completion_period">工期</label></th>
            <td><input type="text" id="completion_period" name="completion_period" value="<?php echo esc_attr($completion_period); ?>" style="width: 100%;" placeholder="例: 6ヶ月" /></td>
        </tr>
    </table>
    <?php
}

// カスタムフィールドの保存
function save_portfolio_details($post_id) {
    if (!isset($_POST['portfolio_details_nonce']) || !wp_verify_nonce($_POST['portfolio_details_nonce'], 'portfolio_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('client_name', 'project_date', 'project_location', 'project_size', 'project_budget', 'completion_period');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_portfolio_details');

// メニューの登録
function register_construction_menus() {
    register_nav_menus(array(
        'primary' => 'プライマリーメニュー',
        'footer' => 'フッターメニュー'
    ));
}
add_action('init', 'register_construction_menus');

// ウィジェットエリアの登録
function construction_widgets_init() {
    register_sidebar(array(
        'name' => 'サイドバー',
        'id' => 'sidebar-1',
        'description' => 'サイドバーウィジェットエリア',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => 'フッターウィジェット',
        'id' => 'footer-widgets',
        'description' => 'フッターウィジェットエリア',
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="footer-widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'construction_widgets_init');

// フロントエンド投稿機能は削除（管理者のみ投稿可能）

// 画像サイズの追加
function construction_image_sizes() {
    add_image_size('portfolio-thumbnail', 400, 300, true);
    add_image_size('portfolio-large', 800, 600, true);
}
add_action('after_setup_theme', 'construction_image_sizes');

// 検索結果から特定の投稿タイプを除外
function exclude_pages_from_search($query) {
    if ($query->is_search() && $query->is_main_query() && !is_admin()) {
        $query->set('post_type', array('post', 'portfolio'));
    }
}
add_action('pre_get_posts', 'exclude_pages_from_search');

// カスタマイザーの設定
function construction_customize_register($wp_customize) {
    // 会社情報セクション
    $wp_customize->add_section('company_info', array(
        'title' => '会社情報',
        'priority' => 30,
    ));
    
    // 会社名
    $wp_customize->add_setting('company_name', array(
        'default' => '株式会社〇〇建設',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('company_name', array(
        'label' => '会社名',
        'section' => 'company_info',
        'type' => 'text',
    ));
    
    // 代表者名
    $wp_customize->add_setting('president_name', array(
        'default' => '代表取締役 山田太郎',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('president_name', array(
        'label' => '代表者名',
        'section' => 'company_info',
        'type' => 'text',
    ));
    
    // 代表挨拶
    $wp_customize->add_setting('president_message', array(
        'default' => 'お客様の夢を形にする建設会社として、品質と信頼を第一に取り組んでおります。',
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('president_message', array(
        'label' => '代表挨拶',
        'section' => 'company_info',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'construction_customize_register');

// テーマ有効化時の初期設定
function construction_theme_activation() {
    // パーマリンクの更新
    flush_rewrite_rules();
    
    // デフォルトカテゴリーの作成
    if (!term_exists('住宅建築', 'portfolio_category')) {
        wp_insert_term('住宅建築', 'portfolio_category', array('description' => '一般住宅の建築プロジェクト'));
    }
    if (!term_exists('商業施設', 'portfolio_category')) {
        wp_insert_term('商業施設', 'portfolio_category', array('description' => '店舗・オフィスなどの商業建築'));
    }
    if (!term_exists('公共工事', 'portfolio_category')) {
        wp_insert_term('公共工事', 'portfolio_category', array('description' => '公共施設の建設・改修'));
    }
    if (!term_exists('リフォーム', 'portfolio_category')) {
        wp_insert_term('リフォーム', 'portfolio_category', array('description' => '既存建物の改装・改修'));
    }
}
add_action('after_switch_theme', 'construction_theme_activation');

// 投稿ページテンプレート機能は削除（管理者のみ投稿可能）

// カスタマイザーに代表者写真の追加
function construction_customize_register_additional($wp_customize) {
    // 代表者写真
    $wp_customize->add_setting('president_photo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'president_photo', array(
        'label' => '代表者写真',
        'section' => 'company_info',
        'settings' => 'president_photo',
    )));
}
add_action('customize_register', 'construction_customize_register_additional');

// 管理画面のダッシュボードウィジェット追加
function construction_dashboard_widget() {
    wp_add_dashboard_widget(
        'construction_overview',
        '建設会社テーマ - 概要',
        'construction_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'construction_dashboard_widget');

function construction_dashboard_widget_content() {
    $portfolio_count = wp_count_posts('portfolio');
    $published_count = $portfolio_count->publish;
    
    echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin: 1rem 0;">';
    
    echo '<div style="text-align: center; padding: 1rem; background: #f1f8e9; border-radius: 8px;">';
    echo '<h3 style="color: #2d5a27; margin: 0; font-size: 2rem;">' . $published_count . '</h3>';
    echo '<p style="margin: 0.5rem 0 0; color: #4a7c59;">公開済み実績</p>';
    echo '</div>';
    
    echo '<div style="text-align: center; padding: 1rem; background: #f1f8e9; border-radius: 8px;">';
    echo '<h3 style="color: #2d5a27; margin: 0; font-size: 2rem;">' . get_terms(array('taxonomy' => 'portfolio_category', 'hide_empty' => false, 'fields' => 'count')) . '</h3>';
    echo '<p style="margin: 0.5rem 0 0; color: #4a7c59;">カテゴリー数</p>';
    echo '</div>';
    
    echo '</div>';
    
    echo '<div style="margin-top: 1rem;">';
    echo '<h4 style="color: #2d5a27;">クイックリンク</h4>';
    echo '<p><a href="' . admin_url('post-new.php?post_type=portfolio') . '" class="button button-primary">新しい実績を追加</a></p>';
    echo '<p><a href="' . admin_url('edit-tags.php?taxonomy=portfolio_category&post_type=portfolio') . '" class="button">カテゴリー管理</a></p>';
    echo '<p><a href="' . admin_url('customize.php') . '" class="button">サイトをカスタマイズ</a></p>';
    echo '</div>';
    
    echo '<div style="margin-top: 1.5rem; padding: 1rem; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">';
    echo '<h4 style="margin-top: 0; color: #856404;">使用方法</h4>';
    echo '<ul style="margin-bottom: 0;">';
    echo '<li>施工実績は管理画面の「施工実績」メニューから投稿できます</li>';
    echo '<li>会社情報は「外観 > カスタマイズ」から設定してください</li>';
    echo '<li>メニューは「外観 > メニュー」から設定できます</li>';
    echo '</ul>';
    echo '</div>';
}

// 投稿リストにカスタムカラムを追加
function construction_portfolio_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['portfolio_image'] = 'メイン画像';
    $new_columns['client_name'] = 'クライアント';
    $new_columns['project_date'] = '施工日';
    $new_columns['project_location'] = '施工場所';
    $new_columns['taxonomy-portfolio_category'] = 'カテゴリー';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_portfolio_posts_columns', 'construction_portfolio_columns');

function construction_portfolio_column_content($column, $post_id) {
    switch ($column) {
        case 'portfolio_image':
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail($post_id, 'thumbnail', array('style' => 'width: 60px; height: 60px; object-fit: cover; border-radius: 4px;'));
            } else {
                echo '<div style="width: 60px; height: 60px; background: #f1f8e9; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #4a7c59; font-size: 10px;">画像なし</div>';
            }
            break;
        case 'client_name':
            echo esc_html(get_post_meta($post_id, '_client_name', true) ?: '-');
            break;
        case 'project_date':
            $date = get_post_meta($post_id, '_project_date', true);
            echo $date ? esc_html(date('Y/m/d', strtotime($date))) : '-';
            break;
        case 'project_location':
            echo esc_html(get_post_meta($post_id, '_project_location', true) ?: '-');
            break;
    }
}
add_action('manage_portfolio_posts_custom_column', 'construction_portfolio_column_content', 10, 2);
?>
