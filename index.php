<?php get_header(); ?>

<main class="main-content">
    <!-- ヒーローセクション -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1><?php echo get_theme_mod('company_name', '信頼と品質の建設会社'); ?></h1>
                <p>お客様の夢を形にする、プロフェッショナルな建設サービスをご提供いたします</p>
                <a href="#portfolio" class="cta-button">施工実績を見る</a>
            </div>
        </div>
    </section>

    <!-- 会社情報セクション -->
    <section class="section company-info" id="company">
        <div class="container">
            <h2 class="section-title">会社情報</h2>
            <div class="info-grid">
                <div class="info-card">
                    <h3>創業年</h3>
                    <p>1985年より地域に根ざした建設業を営んでおります</p>
                </div>
                <div class="info-card">
                    <h3>事業内容</h3>
                    <p>住宅建築・リフォーム・公共工事・設計施工</p>
                </div>
                <div class="info-card">
                    <h3>施工実績</h3>
                    <p>累計1,000件以上の豊富な経験と実績</p>
                </div>
                <div class="info-card">
                    <h3>対応エリア</h3>
                    <p>関東圏を中心に全国対応可能</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 代表挨拶セクション -->
    <section class="section president-message" id="president">
        <div class="container">
            <h2 class="section-title">代表挨拶</h2>
            <div class="message-content">
                <div class="president-image">
                    <?php if (get_theme_mod('president_photo')) : ?>
                        <img src="<?php echo esc_url(get_theme_mod('president_photo')); ?>" alt="代表者写真" class="president-photo">
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/president-placeholder.svg" alt="代表者写真" class="president-photo">
                    <?php endif; ?>
                </div>
                <div class="message-text-container">
                    <div class="message-text">
                        <?php echo wp_kses_post(get_theme_mod('president_message', 'お客様の夢を形にする建設会社として、品質と信頼を第一に取り組んでおります。創業以来、地域の皆様に支えられながら、数多くの建設プロジェクトを手がけてまいりました。これからも、お客様一人ひとりのご要望にお応えし、満足いただける建物をお届けできるよう、スタッフ一同努力してまいります。')); ?>
                    </div>
                    <div class="president-name">
                        <?php echo esc_html(get_theme_mod('president_name', '代表取締役 山田太郎')); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 施工実績セクション -->
    <section class="section portfolio-section" id="portfolio">
        <div class="container">
            <h2 class="section-title">施工実績</h2>
            <div class="portfolio-grid">
                <?php
                $portfolio_query = new WP_Query(array(
                    'post_type' => 'portfolio',
                    'posts_per_page' => 6,
                    'post_status' => 'publish'
                ));

                if ($portfolio_query->have_posts()) :
                    while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                        $client_name = get_post_meta(get_the_ID(), '_client_name', true);
                        $project_date = get_post_meta(get_the_ID(), '_project_date', true);
                        $project_location = get_post_meta(get_the_ID(), '_project_location', true);
                ?>
                    <div class="portfolio-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'portfolio-thumbnail'); ?>" alt="<?php the_title(); ?>" class="portfolio-image">
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/portfolio-placeholder.svg" alt="<?php the_title(); ?>" class="portfolio-image">
                        <?php endif; ?>
                        
                        <div class="portfolio-content">
                            <h3 class="portfolio-title"><?php the_title(); ?></h3>
                            <div class="portfolio-meta">
                                <?php if ($project_date) : ?>
                                    <span>施工日: <?php echo esc_html($project_date); ?></span>
                                <?php endif; ?>
                                <?php if ($project_location) : ?>
                                    <span> | 場所: <?php echo esc_html($project_location); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="portfolio-description">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="portfolio-link">
                                詳細を見る →
                            </a>
                        </div>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="no-portfolio">
                        <p>施工実績を準備中です。もうしばらくお待ちください。</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($portfolio_query->found_posts > 6) : ?>
                <div style="text-align: center; margin-top: 3rem;">
                    <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" class="cta-button">すべての施工実績を見る</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- お問い合わせセクション -->
    <section class="section contact-section" style="background: var(--background-green);">
        <div class="container">
            <h2 class="section-title">お問い合わせ</h2>
            <div style="text-align: center;">
                <p style="font-size: 1.2rem; margin-bottom: 2rem;">お気軽にご相談ください</p>
                <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                    <div style="background: var(--white); padding: 1.5rem; border-radius: 10px; min-width: 250px;">
                        <h4 style="color: var(--primary-green); margin-bottom: 1rem;">電話でのお問い合わせ</h4>
                        <p style="font-size: 1.1rem; font-weight: bold;">03-1234-5678</p>
                        <p style="font-size: 0.9rem; color: var(--dark-gray);">平日 9:00-18:00</p>
                    </div>
                    <div style="background: var(--white); padding: 1.5rem; border-radius: 10px; min-width: 250px;">
                        <h4 style="color: var(--primary-green); margin-bottom: 1rem;">メールでのお問い合わせ</h4>
                        <p style="font-size: 1.1rem; font-weight: bold;">info@construction.co.jp</p>
                        <p style="font-size: 0.9rem; color: var(--dark-gray);">24時間受付</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
