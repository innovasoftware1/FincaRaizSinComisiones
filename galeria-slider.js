let currentIndex = 0;

function moveSlide(direction) {
    const images = document.querySelectorAll('.slider-wrapper img');
    const totalImages = images.length;
    const imageWidth = images[0].clientWidth + 10;
    const sliderWidth = document.querySelector('.slider-container').clientWidth;
    const imagesPerView = Math.floor(sliderWidth / imageWidth);

    if (direction === 1 && currentIndex + imagesPerView >= totalImages) return;
    if (direction === -1 && currentIndex <= 0) return;

    currentIndex = Math.max(0, Math.min(currentIndex + direction, totalImages - imagesPerView));

    let translateXValue = currentIndex * imageWidth;

    if (currentIndex + imagesPerView >= totalImages) {
        const remainingWidth = totalImages * imageWidth - sliderWidth;
        translateXValue = Math.max(remainingWidth, currentIndex * imageWidth);
    }

    document.querySelector('.slider-wrapper').style.transform = `translateX(-${translateXValue}px)`;
}
