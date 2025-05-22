window.addEventListener('scroll', function(){
    const header = document.querySelector('.sideViewLeft');
    const scrollTriggerPx = window.innerHeight;

    if(window.scrollY > scrollTriggerPx){
        header.classList.add('movedUp');
    } else {
        header.classList.remove('movedUp');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const sideViewLeft = document.querySelector('.sideViewLeft');
    const scrollThreshold = 100;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > scrollThreshold) {
            sideViewLeft.classList.add('movedUp');
        } else {
            sideViewLeft.classList.remove('movedUp');
        }
    });

    const images = [
        "../images/home mini gallery/1.jpg",
        "../images/home mini gallery/2.jpg",
        "../images/home mini gallery/3.jpg",
        "../images/home mini gallery/4.jpg"
    ];
    
    const imgBox = document.querySelector('.img-box');
    const mainImage = imgBox.querySelector('img');
    const thumbnailImages = document.querySelectorAll('.minidisplay img');
    const prevButton = document.querySelector('.button-back');
    const nextButton = document.querySelector('.button-forward');
    
    if (mainImage) {
        imgBox.removeChild(mainImage);
    }
    
    let currentIndex = 0;
    let carouselInterval;
    
    images.forEach((imgSrc, index) => {
        const img = document.createElement('img');
        img.src = imgSrc;
        img.alt = `Cafe image ${index + 1}`;
        img.style.opacity = index === 0 ? '1' : '0';
        img.style.position = 'absolute';
        img.style.top = '0';
        img.style.left = '0';
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        img.style.transition = 'opacity 1s ease-in-out';
        imgBox.appendChild(img);
    });
    
    const allImages = document.querySelectorAll('.img-box img');
    
    function updateCarousel(direction) {
        allImages[currentIndex].style.opacity = '0';
        
        if (direction === 'next') {
            currentIndex = (currentIndex + 1) % images.length;
        } else if (direction === 'prev') {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
        }
        
        allImages[currentIndex].style.opacity = '1';
        
        updateThumbnails();
    }
    
    function updateThumbnails() {
        thumbnailImages.forEach((img, index) => {
            let thumbIndex = (currentIndex + index + 1) % images.length;
            img.src = images[thumbIndex];
            img.style.filter = index === 0 ? 'brightness(1)' : 'brightness(0.7)';
        });
    }
    
    function nextImage() {
        updateCarousel('next');
    }
    
    function prevImage() {
        updateCarousel('prev');
    }
    
    nextButton.addEventListener('click', nextImage);
    prevButton.addEventListener('click', prevImage);
    
    thumbnailImages.forEach((img, index) => {
        img.addEventListener('click', () => {
            allImages[currentIndex].style.opacity = '0';
            
            currentIndex = (currentIndex + index + 1) % images.length;
            
            allImages[currentIndex].style.opacity = '1';
            
            updateThumbnails();
        });
    });
    
    function startCarousel() {
        carouselInterval = setInterval(nextImage, 5000);
    }
    
    updateThumbnails();
    startCarousel();
    
    imgBox.addEventListener('mouseenter', () => {
        clearInterval(carouselInterval);
    });
    
    imgBox.addEventListener('mouseleave', startCarousel);
});
