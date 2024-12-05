function handleUrlInput(evt) {
    if (evt.target.id === 'recorrido_360_url') {
        var recorridoUrl = evt.target.value;
        var recorridoContainer = document.createElement('div');

        if (recorridoUrl) {
            recorridoContainer.innerHTML = '<iframe width="100%" height="400px" src="' + recorridoUrl + '" frameborder="0" allowfullscreen></iframe>';
            document.getElementById('recorridoPreview').innerHTML = ''; 
            document.getElementById('recorridoPreview').appendChild(recorridoContainer);
        }
    }

    if (evt.target.id === 'video_url') {
        var videoUrl = evt.target.value;
        var videoId = videoUrl.split('v=')[1]; 
        if (videoId) {
            var embedUrl = `https://www.youtube.com/embed/${videoId}`;
            var videoContainer = document.createElement('div');
            videoContainer.innerHTML = '<iframe width="100%" height="315" src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe>';
            document.getElementById('videoPreview').innerHTML = ''; 
            document.getElementById('videoPreview').appendChild(videoContainer);
        }
    }
}

document.getElementById('recorrido_360_url').addEventListener('input', handleUrlInput, false);
document.getElementById('video_url').addEventListener('input', handleUrlInput, false);

document.querySelector('form').addEventListener('submit', function(event) {
    var formData = new FormData(this); 

    console.log('Formulario enviado:', Object.fromEntries(formData));
});
