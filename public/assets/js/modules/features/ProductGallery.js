export class ProductGallery {
    constructor() {
        this.mainSwiper = null;
        this.thumbsSwiper = null;
        this.touchStartX = null;
        this.touchStartY = null;
    }

    init() {
        this.initializeProductGallery();
        this.initializeRelatedProducts();
        this.initializeTouchEvents();
    }

    initializeProductGallery() {
        // Initialize thumbnail slider
        this.thumbsSwiper = new Swiper('.product-gallery__thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            watchSlidesProgress: true,
            breakpoints: {
                320: {
                    slidesPerView: 3,
                },
                576: {
                    slidesPerView: 4,
                },
                768: {
                    slidesPerView: 5,
                }
            }
        });

        // Initialize main slider
        this.mainSwiper = new Swiper('.product-gallery__main', {
            spaceBetween: 0,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            thumbs: {
                swiper: this.thumbsSwiper
            },
            zoom: {
                maxRatio: 2,
                toggle: true
            },
            keyboard: {
                enabled: true,
                onlyInViewport: false
            }
        });

        // Add double tap to zoom functionality
        let lastTap = 0;
        const mainSlider = document.querySelector('.product-gallery__main');

        if (mainSlider) {
            mainSlider.addEventListener('touchend', (e) => {
                const currentTime = new Date().getTime();
                const tapLength = currentTime - lastTap;

                if (tapLength < 300 && tapLength > 0) {
                    const slide = e.target.closest('.swiper-slide');
                    if (slide) {
                        this.toggleZoom(e, slide);
                    }
                }
                lastTap = currentTime;
            });
        }
    }

    initializeRelatedProducts() {
        new Swiper('.related-slider', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                992: {
                    slidesPerView: 4,
                }
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });
    }

    initializeTouchEvents() {
        const gallery = document.querySelector('.product-gallery');
        if (!gallery) return;

        gallery.addEventListener('touchstart', (e) => {
            this.touchStartX = e.touches[0].clientX;
            this.touchStartY = e.touches[0].clientY;
        }, {passive: true});

        gallery.addEventListener('touchmove', (e) => {
            if (!this.touchStartX || !this.touchStartY) return;

            const touchEndX = e.touches[0].clientX;
            const touchEndY = e.touches[0].clientY;

            const deltaX = this.touchStartX - touchEndX;
            const deltaY = this.touchStartY - touchEndY;

            // If horizontal swipe is more significant than vertical
            if (Math.abs(deltaX) > Math.abs(deltaY)) {
                if (deltaX > 50) {
                    this.mainSwiper?.slideNext();
                } else if (deltaX < -50) {
                    this.mainSwiper?.slidePrev();
                }
            }

            this.touchStartX = null;
            this.touchStartY = null;
        }, {passive: true});
    }

    toggleZoom(e, slide) {
        const image = slide.querySelector('img');
        if (!image) return;

        if (slide.dataset.zoomed) {
            // Reset zoom
            image.style.transform = '';
            slide.dataset.zoomed = '';
        } else {
            // Calculate zoom position based on touch position
            const touch = e.changedTouches[0];
            const rect = slide.getBoundingClientRect();
            const offsetX = (touch.clientX - rect.left) / rect.width;
            const offsetY = (touch.clientY - rect.top) / rect.height;

            image.style.transformOrigin = `${offsetX * 100}% ${offsetY * 100}%`;
            image.style.transform = 'scale(2)';
            slide.dataset.zoomed = 'true';
        }
    }

    // Method to handle fullscreen mode
    enterFullscreen(element) {
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    }

    // Utility method to preload images for smoother transitions
    preloadImages(imageUrls) {
        imageUrls.forEach(url => {
            const img = new Image();
            img.src = url;
        });
    }

    // Method to update gallery
    updateGallery(images) {
        if (this.mainSwiper && this.thumbsSwiper) {
            this.mainSwiper.removeAllSlides();
            this.thumbsSwiper.removeAllSlides();

            images.forEach(image => {
                this.mainSwiper.appendSlide(`
                    <div class="swiper-slide">
                        <div class="swiper-zoom-container">
                            <img src="${image.url}" alt="${image.alt}">
                        </div>
                    </div>
                `);

                this.thumbsSwiper.appendSlide(`
                    <div class="swiper-slide">
                        <img src="${image.thumbnail}" alt="${image.alt}">
                    </div>
                `);
            });

            this.mainSwiper.update();
            this.thumbsSwiper.update();
        }
    }
}
