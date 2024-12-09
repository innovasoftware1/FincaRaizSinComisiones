function handleFileSelect(evt) {
    var files = evt.target.files; 

    var f = files[0];

      if (!f.type.match('image.*')) {
      }

      var reader = new FileReader();

      reader.onload = (function(theFile) {
        return function(e) {
          var span = document.createElement('span');
          span.innerHTML = ['<img class="thumb" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('list').innerHTML = span.innerHTML;

          document.getElementById('fotoPrincipalActualizada').value = "si";
        };
      })(f);

      reader.readAsDataURL(f);
  }

  document.getElementById('foto1').addEventListener('change', handleFileSelect, false); 