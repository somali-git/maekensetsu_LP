<?php get_header(); ?>

<main class="main-content">
    <?php while (have_posts()) : the_post(); 
        $client_name = get_post_meta(get_the_ID(), '_client_name', true);
        $project_date = get_post_meta(get_the_ID(), '_project_date', true);
        $project_location = get_post_meta(get_the_ID(), '_project_location', true);
        $project_size = get_post_meta(get_the_ID(), '_project_size', true);
        $project_budget = get_post_meta(get_the_ID(), '_project_budget', true);
        $completion_period = get_post_meta(get_the_ID(), '_completion_period', true);
    ?>
    
    <!-- ページヘッダー -->
    <section class="portfolio-header" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); color: var(--white); padding: 100px 0 40px;">
        <div class="container">
            <div class="breadcrumb" style="margin-bottom: 1rem; font-size: 0.9rem; opacity: 0.8;">
                <a href="<?php echo home_url('/'); ?>" style="color: var(--white); text-decoration: none;">ホーム</a> &gt; 
                <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" style="color: var(--white); text-decoration: none;">施工実績</a> &gt; 
                <span><?php the_title(); ?></span>
            </div>
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;"><?php the_title(); ?></h1>
            <?php if ($project_location) : ?>
                <p style="font-size: 1.1rem; opacity: 0.9;">📍 <?php echo esc_html($project_location); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <!-- メイン画像 -->
    <?php if (has_post_thumbnail()) : ?>
    <section class="portfolio-featured-image" style="background: var(--white);">
        <div class="container" style="padding: 0;">
            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        </div>
    </section>
    <?php endif; ?>

    <!-- プロジェクト詳細 -->
    <section class="portfolio-details" style="padding: 60px 0; background: var(--white);">
        <div class="container">
            <div class="details-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; align-items: start;">
                
                <!-- メインコンテンツ -->
                <div class="main-content-area">
                    <h2 style="color: var(--primary-green); font-size: 2rem; margin-bottom: 1.5rem;">プロジェクト概要</h2>
                    <div class="project-description" style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem;">
                        <?php the_content(); ?>
                    </div>
                    
                    <!-- カテゴリー -->
                    <?php 
                    $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                    if ($categories && !is_wp_error($categories)) : 
                    ?>
                    <div class="project-categories" style="margin-bottom: 2rem;">
                        <h3 style="color: var(--primary-green); margin-bottom: 1rem;">カテゴリー</h3>
                        <div class="category-tags">
                            <?php foreach ($categories as $category) : ?>
                                <span style="background: var(--accent-green); color: var(--white); padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; margin-right: 0.5rem; display: inline-block; margin-bottom: 0.5rem;">
                                    <?php echo esc_html($category->name); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- サイドバー（プロジェクト情報） -->
                <div class="project-sidebar">
                    <div class="project-info-card" style="background: var(--background-green); padding: 2rem; border-radius: 10px; position: sticky; top: 100px;">
                        <h3 style="color: var(--primary-green); margin-bottom: 1.5rem; text-align: center;">プロジェクト詳細</h3>
                        
                        <?php if ($client_name) : ?>
                        <div class="info-item" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--accent-green);">
                            <strong style="color: var(--primary-green); display: block; margin-bottom: 0.5rem;">クライアント</strong>
                            <span><?php echo esc_html($client_name); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($project_date) : ?>
                        <div class="info-item" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--accent-green);">
                            <strong style="color: var(--primary-green); display: block; margin-bottom: 0.5rem;">施工日</strong>
                            <span><?php echo esc_html(date('Y年m月d日', strtotime($project_date))); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($project_location) : ?>
                        <div class="info-item" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--accent-green);">
                            <strong style="color: var(--primary-green); display: block; margin-bottom: 0.5rem;">施工場所</strong>
                            <span><?php echo esc_html($project_location); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($project_size) : ?>
                        <div class="info-item" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--accent-green);">
                            <strong style="color: var(--primary-green); display: block; margin-bottom: 0.5rem;">施工規模</strong>
                            <span><?php echo esc_html($project_size); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($project_budget) : ?>
                        <div class="info-item" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--accent-green);">
                            <strong style="color: var(--primary-green); display: block; margin-bottom: 0.5rem;">予算</strong>
                            <span><?php echo esc_html($project_budget); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($completion_period) : ?>
                        <div class="info-item" style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--accent-green);">
                            <strong style="color: var(--primary-green); display: block; margin-bottom: 0.5rem;">工期</strong>
                            <span><?php echo esc_html($completion_period); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="contact-cta" style="text-align: center; margin-top: 2rem;">
                            <p style="font-size: 0.9rem; margin-bottom: 1rem; color: var(--dark-gray);">
                                類似プロジェクトの<br>ご相談はお気軽に
                            </p>
                            <a href="<?php echo home_url('/#contact'); ?>" class="cta-button" style="display: inline-block; background: var(--secondary-green); color: var(--white); padding: 12px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; transition: all 0.3s ease;">
                                お問い合わせ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 関連施工実績 -->
    <section class="related-portfolio" style="padding: 60px 0; background: var(--light-gray);">
        <div class="container">
            <h2 class="section-title" style="text-align: center; font-size: 2rem; color: var(--primary-green); margin-bottom: 3rem;">関連する施工実績</h2>
            
            <?php
            $related_query = new WP_Query(array(
                'post_type' => 'portfolio',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand'
            ));

            if ($related_query->have_posts()) :
            ?>
            <div class="portfolio-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                <div class="portfolio-item" style="background: var(--white); border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'portfolio-thumbnail'); ?>" alt="<?php the_title(); ?>" style="width: 100%; height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    
                    <div style="padding: 1.5rem;">
                        <h3 style="color: var(--primary-green); font-size: 1.2rem; margin-bottom: 0.5rem;">
                            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p style="color: var(--dark-gray); font-size: 0.9rem; line-height: 1.6; margin-bottom: 1rem;">
                            <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                        </p>
                        <a href="<?php the_permalink(); ?>" style="color: var(--secondary-green); text-decoration: none; font-weight: bold;">
                            詳細を見る →
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php 
            wp_reset_postdata();
            endif; 
            ?>
        </div>
    </section>

    <!-- ナビゲーション -->
    <section class="portfolio-navigation" style="padding: 40px 0; background: var(--white); border-top: 1px solid var(--light-gray);">
        <div class="container">
            <div class="nav-links" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="nav-previous">
                    <?php 
                    $prev_post = get_previous_post(false, '', 'portfolio_category');
                    if ($prev_post) : 
                    ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" style="color: var(--secondary-green); text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                        ← <?php echo esc_html($prev_post->post_title); ?>
                    </a>
                    <?php endif; ?>
                </div>
                
                <div class="nav-archive">
                    <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" style="background: var(--accent-green); color: var(--white); padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                        一覧に戻る
                    </a>
                </div>
                
                <div class="nav-next">
                    <?php 
                    $next_post = get_next_post(false, '', 'portfolio_category');
                    if ($next_post) : 
                    ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>" style="color: var(--secondary-green); text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                        <?php echo esc_html($next_post->post_title); ?> →
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php endwhile; ?>
</main>

<style>
@media (max-width: 768px) {
    .details-grid {
        grid-template-columns: 1fr !important;
    }
    
    .project-info-card {
        position: static !important;
    }
    
    .nav-links {
        flex-direction: column !important;
        gap: 1rem;
    }
    
    .nav-previous,
    .nav-next {
        text-align: center;
    }
}

.portfolio-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.cta-button:hover {
    background: var(--primary-green) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}
</style>

<?php get_footer(); ?>
