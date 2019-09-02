let btn = document.getElementById('btn-create');
let modal = document.getElementById('myModal');
let spans = document.querySelector('.close');

btn.addEventListener('click', function () {
   modal.style.display = "block";
});


spans.addEventListener('click', function () {
   modal.style.display = "none";
});


window.addEventListener('click', function (e) {
   if(e.target === modal){
      modal.style.display = "none";
   }
});