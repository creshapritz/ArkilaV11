
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('menu-button').addEventListener('click', function () {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('expanded');  // Toggle the 'active' class to show/hide the sidebar
    });

   




    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');
    const reviewsWrapper = document.querySelector('.reviews-wrapper');

    // Scroll distance to move three boxes at a time (adjust if box width changes)
    const scrollAmount = 300;

    if (window.innerWidth > 768) {
        leftArrow.addEventListener('click', () => {
            reviewsWrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        rightArrow.addEventListener('click', () => {
            reviewsWrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    }

    let slideIndex = 1;
    let slideInterval;

    showSlides(slideIndex);
    startAutoSlide();


    function currentSlide(n) {
        clearInterval(slideInterval);
        showSlides(slideIndex = n);
        startAutoSlide(); // Restart the automatic slideshow
    }

    // Function to go to the next slide
    function nextSlide() {
        clearInterval(slideInterval);
        showSlides(slideIndex += 1);
        startAutoSlide();
    }

    // Function to show slides based on the index
    function showSlides(n) {
        let slides = document.getElementsByClassName("slide");
        let dots = document.getElementsByClassName("dot");

        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }

        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none"; // Hide all slides
        }

        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", ""); // Remove active class from all dots
        }

        slides[slideIndex - 1].style.display = "block"; // Show the current slide
        dots[slideIndex - 1].className += " active"; // Add active class to the current dot
    }

    // Function to start automatic slideshow
    function startAutoSlide() {
        slideInterval = setInterval(() => {
            showSlides(slideIndex += 1);
        }, 3000); // Change slide every 3 seconds
    }

    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        spaceBetween: 20,
        loop: true,
        centeredSlides: true,
        freeMode: true,
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 10
            },
        }
    });

});



