<?php get_header(); ?>

<main class="main-content">
    <!-- ページヘッダー -->
    <section class="page-header" style="background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); color: var(--white); padding: 100px 0 60px; text-align: center;">
        <div class="container">
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">施工実績一覧</h1>
            <p style="font-size: 1.1rem;">これまでに手がけた建設プロジェクトをご紹介いたします</p>
        </div>
    </section>

    <!-- フィルター機能 -->
    <section class="portfolio-filters" style="background: var(--white); padding: 2rem 0; border-bottom: 1px solid var(--light-gray);">
        <div class="container">
            <div class="filter-controls" style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <button class="filter-btn active" data-filter="*" style="background: var(--secondary-green); color: var(--white); border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: all 0.3s ease;">すべて</button>
                
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'portfolio_category',
                    'hide_empty' => true,
                ));
                
                if (!empty($categories) && !is_wp_error($categories)) :
                    foreach ($categories as $category) :
                ?>
                    <button class="filter-btn" data-filter=".category-<?php echo esc_attr($category->slug); ?>" style="background: var(--light-gray); color: var(--dark-gray); border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: all 0.3s ease;">
                        <?php echo esc_html($category->name); ?>
                    </button>
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
        </div>
    </section>

    <!-- 施工実績一覧 -->
    <section class="portfolio-archive" style="padding: 60px 0; background: var(--light-gray);">
        <div class="container">
            <?php if (have_posts()) : ?>
                <div class="portfolio-grid">
                    <?php while (have_posts()) : the_post(); 
                        $client_name = get_post_meta(get_the_ID(), '_client_name', true);
                        $project_date = get_post_meta(get_the_ID(), '_project_date', true);
                        $project_location = get_post_meta(get_the_ID(), '_project_location', true);
                        $project_size = get_post_meta(get_the_ID(), '_project_size', true);
                        $project_budget = get_post_meta(get_the_ID(), '_project_budget', true);
                        
                        // カテゴリークラスを取得
                        $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                        $category_classes = '';
                        if ($categories && !is_wp_error($categories)) {
                            foreach ($categories as $category) {
                                $category_classes .= ' category-' . $category->slug;
                            }
                        }
                    ?>
                    <div class="portfolio-item<?php echo $category_classes; ?>" style="background: var(--white); border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'portfolio-thumbnail'); ?>" alt="<?php the_title(); ?>" class="portfolio-image" style="width: 100%; height: 250px; object-fit: cover;">
                        <?php else : ?>
                            <div class="portfolio-placeholder" style="width: 100%; height: 250px; background: var(--background-green); display: flex; align-items: center; justify-content: center; color: var(--dark-gray);">
                                <span>画像準備中</span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="portfolio-content" style="padding: 1.5rem;">
                            <h3 class="portfolio-title" style="color: var(--primary-green); font-size: 1.3rem; margin-bottom: 0.5rem;">
                                <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            
                            <div class="portfolio-meta" style="color: var(--dark-gray); font-size: 0.9rem; margin-bottom: 1rem;">
                                <?php if ($project_date) : ?>
                                    <span>📅 施工日: <?php echo esc_html(date('Y年m月', strtotime($project_date))); ?></span><br>
                                <?php endif; ?>
                                <?php if ($project_location) : ?>
                                    <span>📍 場所: <?php echo esc_html($project_location); ?></span><br>
                                <?php endif; ?>
                                <?php if ($project_size) : ?>
                                    <span>📏 規模: <?php echo esc_html($project_size); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="portfolio-description" style="margin-bottom: 1rem; line-height: 1.6;">
                                <?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
                            </div>
                            
                            <!-- カテゴリー表示 -->
                            <?php if ($categories && !is_wp_error($categories)) : ?>
                                <div class="portfolio-categories" style="margin-bottom: 1rem;">
                                    <?php foreach ($categories as $category) : ?>
                                        <span style="background: var(--accent-green); color: var(--white); padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <a href="<?php the_permalink(); ?>" class="portfolio-link" style="color: var(--secondary-green); text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 0.5rem;">
                                詳細を見る →
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- ページネーション -->
                <div class="pagination-container" style="text-align: center; margin-top: 3rem;">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '← 前のページ',
                        'next_text' => '次のページ →',
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                <div class="no-portfolio" style="text-align: center; padding: 3rem;">
                    <h3 style="color: var(--primary-green); margin-bottom: 1rem;">施工実績を準備中です</h3>
                    <p style="margin-bottom: 2rem;">もうしばらくお待ちください。</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<style>
.filter-btn:hover,
.filter-btn.active {
    background: var(--secondary-green) !important;
    color: var(--white) !important;
}

.portfolio-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.pagination .page-numbers {
    display: inline-block;
    padding: 10px 15px;
    margin: 0 5px;
    background: var(--white);
    color: var(--primary-green);
    text-decoration: none;
    border-radius: 5px;
    border: 2px solid var(--accent-green);
    transition: all 0.3s ease;
}

.pagination .page-numbers:hover,
.pagination .page-numbers.current {
    background: var(--secondary-green);
    color: var(--white);
    border-color: var(--secondary-green);
}
</style>

<script>
// フィルター機能
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // アクティブボタンの切り替え
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            portfolioItems.forEach(item => {
                if (filterValue === '*' || item.classList.contains(filterValue.substring(1))) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>
