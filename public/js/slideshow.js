export default function setupSlideshow() {
    const slideshow = document.querySelector('.slideshow');
    let isHovering = false;
    let slideInterval;

    function switchSlide() {
        const slides = document.querySelectorAll('.slideshow .slide');
        const slideWidth = slides[0].offsetWidth + 10; // Include gap
        slideshow.scrollBy({ left: slideWidth, behavior: 'smooth' });

        if (slideshow.scrollLeft + slideshow.offsetWidth >= slideshow.scrollWidth) {
            slideshow.scrollTo({ left: 0, behavior: 'smooth' });
        }
    }

    function startSlideshow() {
        slideInterval = setInterval(switchSlide, 3000);
    }

    slideshow.addEventListener('mouseenter', () => {
        isHovering = true;
        clearInterval(slideInterval);
    });

    slideshow.addEventListener('mouseleave', () => {
        isHovering = false;
        startSlideshow();
    });

    startSlideshow();
}
