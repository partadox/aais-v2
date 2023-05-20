// Script Get File Name Upload dan Preview Image
function previewimg() {
    const foto      = document.querySelector('#foto');
    const fotolabel = document.querySelector('.custom-file-label');
    const imgpreview = document.querySelector('.img-preview');

    fotolabel.textContent = foto.files[0].name;

    const filefoto = new FileReader();
    filefoto.readAsDataURL(foto.files[0]);

    filefoto.onload = function(e) {
        imgpreview.src = e.target.result;
    }
}