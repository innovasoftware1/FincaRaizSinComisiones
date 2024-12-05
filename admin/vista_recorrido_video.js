const videoInput = document.getElementById('video_url');
const recorridoInput = document.getElementById('recorrido_360_url');

function extractYouTubeId(url) {
    const regex = /(?:https?:\/\/(?:www\.)?youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|https?:\/\/(?:www\.)?youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    const match = url.match(regex);
    return match ? match[1] : null;
}

videoInput.addEventListener('input', function() {
    const videoUrl = videoInput.value;
    const videoId = extractYouTubeId(videoUrl);

    if (videoId) {
        const embedUrl = `https://www.youtube.com/embed/${videoId}`;
        document.getElementById('videoPreview').innerHTML = `<iframe width="560" height="315" src="${embedUrl}" frameborder="0" allowfullscreen></iframe>`;
    } else {
        document.getElementById('videoPreview').innerHTML = ''; 
    }
});

recorridoInput.addEventListener('input', function() {
    const recorridoUrl = recorridoInput.value;
    if (recorridoUrl) {
        document.getElementById('recorridoPreview').innerHTML = `<iframe width="560" height="315" src="${recorridoUrl}" frameborder="0" allowfullscreen></iframe>`;
    } else {
        document.getElementById('recorridoPreview').innerHTML = ''; 
    }
});
