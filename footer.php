<footer class="site-footer">
    <div class="container">
        <div class="footer-content" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
            
            <!-- 会社情報 -->
            <div class="footer-section">
                <h4 style="margin-bottom: 1rem; color: var(--accent-green);"><?php echo get_theme_mod('company_name', get_bloginfo('name')); ?></h4>
                <p style="line-height: 1.6;">
                    信頼と品質をモットーに、<br>
                    お客様の夢を形にする<br>
                    建設会社です。
                </p>
            </div>
            
            <!-- 事業内容 -->
            <div class="footer-section">
                <h4 style="margin-bottom: 1rem; color: var(--accent-green);">事業内容</h4>
                <ul style="list-style: none; line-height: 1.8;">
                    <li>・住宅建築</li>
                    <li>・リフォーム・リノベーション</li>
                    <li>・公共工事</li>
                    <li>・設計・施工</li>
                </ul>
            </div>
            
            <!-- 連絡先 -->
            <div class="footer-section">
                <h4 style="margin-bottom: 1rem; color: var(--accent-green);">お問い合わせ</h4>
                <div style="line-height: 1.8;">
                    <p><strong>TEL:</strong> 03-1234-5678</p>
                    <p><strong>FAX:</strong> 03-1234-5679</p>
                    <p><strong>EMAIL:</strong> info@construction.co.jp</p>
                    <p><strong>営業時間:</strong> 平日 9:00-18:00</p>
                </div>
            </div>
            
            <!-- フッターメニュー -->
            <div class="footer-section">
                <h4 style="margin-bottom: 1rem; color: var(--accent-green);">サイトマップ</h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'footer-menu',
                    'container' => false,
                    'fallback_cb' => 'construction_footer_fallback_menu'
                ));
                ?>
            </div>
        </div>
        
        <div class="footer-bottom" style="border-top: 1px solid var(--secondary-green); padding-top: 1rem; text-align: center;">
            <p>&copy; <?php echo date('Y'); ?> <?php echo get_theme_mod('company_name', get_bloginfo('name')); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<!-- 構造化データ（JSON-LD） -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "<?php echo esc_js(get_theme_mod('company_name', get_bloginfo('name'))); ?>",
  "url": "<?php echo home_url('/'); ?>",
  "logo": "<?php echo get_template_directory_uri(); ?>/logo.png",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+81-3-1234-5678",
    "contactType": "customer service",
    "areaServed": "JP",
    "availableLanguage": "ja"
  },
  "address": {
    "@type": "PostalAddress",
    "addressCountry": "JP",
    "addressRegion": "東京都",
    "addressLocality": "渋谷区"
  },
  "sameAs": [
    "https://www.facebook.com/construction-company",
    "https://twitter.com/construction_co"
  ]
}
</script>

<script>
// スムーススクロール
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const headerHeight = document.querySelector('.site-header').offsetHeight;
                const targetPosition = targetElement.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});

// ヘッダーの背景変更（スクロール時）
window.addEventListener('scroll', function() {
    const header = document.querySelector('.site-header');
    if (window.scrollY > 50) {
        header.style.background = 'linear-gradient(135deg, rgba(27, 75, 44, 0.95), rgba(45, 90, 39, 0.95))';
        header.style.backdropFilter = 'blur(10px)';
    } else {
        header.style.background = 'linear-gradient(135deg, var(--primary-green), var(--secondary-green))';
        header.style.backdropFilter = 'none';
    }
});

// モバイルメニューの制御
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mainMenu = document.querySelector('.main-menu');
    
    if (mobileToggle && mainMenu) {
        mobileToggle.addEventListener('click', function() {
            const isVisible = mainMenu.style.display === 'block';
            mainMenu.style.display = isVisible ? 'none' : 'block';
            this.setAttribute('aria-expanded', !isVisible);
            this.innerHTML = isVisible ? '☰' : '✕';
        });
        
        // ウィンドウサイズ変更時の処理
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                mainMenu.style.display = '';
                mobileToggle.style.display = 'none';
                mobileToggle.innerHTML = '☰';
            } else {
                mobileToggle.style.display = 'block';
                if (mainMenu.style.display === 'block') {
                    mainMenu.style.display = 'none';
                }
            }
        });
        
        // 初期化
        if (window.innerWidth <= 768) {
            mobileToggle.style.display = 'block';
        }
    }
});

// スクロールアニメーション
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// アニメーション要素を観察
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.info-card, .portfolio-item, .president-message');
    animatedElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(el);
    });
});
</script>

</body>
</html>

<?php
// フッターのフォールバックメニュー関数
function construction_footer_fallback_menu() {
    echo '<ul class="footer-menu" style="list-style: none; line-height: 1.8;">';
    echo '<li><a href="' . home_url('/') . '" style="color: var(--white); text-decoration: none;">ホーム</a></li>';
    echo '<li><a href="' . home_url('/#company') . '" style="color: var(--white); text-decoration: none;">会社情報</a></li>';
    echo '<li><a href="' . home_url('/#president') . '" style="color: var(--white); text-decoration: none;">代表挨拶</a></li>';
    echo '<li><a href="' . get_post_type_archive_link('portfolio') . '" style="color: var(--white); text-decoration: none;">施工実績</a></li>';
    echo '</ul>';
}
?>
