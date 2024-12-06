const form = document.getElementById('uploadForm');
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    const response = await fetch('php/upload.php', {
        method: 'POST',
        body: formData,
    });

    const result = await response.json();
    document.getElementById('response').innerHTML = `
        <p>${result.message}</p>
    `;

    if (result.imagePath) loadImages();
});

async function loadImages() {
    const response = await fetch('php/list_images.php');
    const images = await response.json();

    const carousel = document.getElementById('carousel');
    carousel.innerHTML = '';

    images.forEach((image) => {
        const img = document.createElement('img');
        img.src = image.image_path;
        img.alt = image.title;
        carousel.appendChild(img);
    });
}

loadImages();
