/**
 * 建設会社WordPressテーマ - メインJavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ===== スムーススクロール =====
    initSmoothScroll();
    
    // ===== レスポンシブナビゲーション =====
    initMobileNavigation();
    
    // ===== スクロール時のヘッダー効果 =====
    initHeaderScrollEffect();
    
    // ===== フォーム強化 =====
    initFormEnhancements();
    
    // ===== アニメーション =====
    initScrollAnimations();
    
    // ===== 施工実績フィルター =====
    initPortfolioFilter();
});

// スムーススクロール機能
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const headerHeight = document.querySelector('.site-header').offsetHeight;
                const targetPosition = targetElement.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// モバイルナビゲーション
function initMobileNavigation() {
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mainMenu = document.querySelector('.main-menu');
    
    if (mobileToggle && mainMenu) {
        mobileToggle.addEventListener('click', function() {
            const isVisible = mainMenu.classList.contains('mobile-open');
            
            if (isVisible) {
                mainMenu.classList.remove('mobile-open');
                this.innerHTML = '☰';
                this.setAttribute('aria-expanded', 'false');
            } else {
                mainMenu.classList.add('mobile-open');
                this.innerHTML = '✕';
                this.setAttribute('aria-expanded', 'true');
            }
        });
        
        // メニューリンククリック時に閉じる
        const menuLinks = mainMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    mainMenu.classList.remove('mobile-open');
                    mobileToggle.innerHTML = '☰';
                    mobileToggle.setAttribute('aria-expanded', 'false');
                }
            });
        });
    }
}

// ヘッダーのスクロール効果
function initHeaderScrollEffect() {
    let lastScrollTop = 0;
    const header = document.querySelector('.site-header');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // 背景の透明度変更
        if (scrollTop > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        // ヘッダーの表示/非表示（オプション）
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
}

// フォーム機能強化
function initFormEnhancements() {
    // ファイルアップロードプレビュー
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    showImagePreview(input, e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
    
    // フォームバリデーション
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    showFieldError(field, 'この項目は必須です');
                    isValid = false;
                } else {
                    clearFieldError(field);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
}

// 画像プレビュー表示
function showImagePreview(input, imageSrc) {
    let preview = input.parentNode.querySelector('.image-preview');
    if (!preview) {
        preview = document.createElement('div');
        preview.className = 'image-preview';
        preview.style.cssText = 'margin-top: 10px; text-align: center;';
        input.parentNode.appendChild(preview);
    }
    
    preview.innerHTML = `
        <img src="${imageSrc}" alt="プレビュー" style="max-width: 200px; max-height: 150px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <p style="font-size: 0.9rem; color: var(--text-gray); margin-top: 5px;">プレビュー</p>
    `;
}

// フィールドエラー表示
function showFieldError(field, message) {
    clearFieldError(field);
    field.style.borderColor = 'var(--error-red)';
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.cssText = 'color: var(--error-red); font-size: 0.9rem; margin-top: 5px;';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
}

// フィールドエラー削除
function clearFieldError(field) {
    field.style.borderColor = '';
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
}

// スクロールアニメーション
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // アニメーション対象要素
    const animatedElements = document.querySelectorAll('.info-card, .portfolio-item, .president-message, .form-group');
    animatedElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.05}s, transform 0.6s ease ${index * 0.05}s`;
        observer.observe(el);
    });
    
    // アニメーションクラス
    const style = document.createElement('style');
    style.textContent = `
        .animate-in {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    `;
    document.head.appendChild(style);
}

// 施工実績フィルター機能
function initPortfolioFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    if (filterBtns.length === 0) return;
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // アクティブボタンの切り替え
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            // アイテムのフィルタリング
            portfolioItems.forEach(item => {
                if (filterValue === '*' || item.classList.contains(filterValue.substring(1))) {
                    item.style.display = 'block';
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.style.opacity = '1';
                    }, 100);
                } else {
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

// ユーティリティ関数
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}
