// Creamos un nuevo archivo por que este archivo solo lo queremos en una vista, no en todas.
const navbar = document.querySelector(".navbar");
const welcome = document.querySelector(".welcome");
const navbarToggle = document.querySelector("#navbarSupportedContent");

const resizeBakgroundImg = () => {
  const height = window.innerHeight - navbar.clientHeight;
  welcome.style.height = `${height}px`;
};


navbarToggle.ontransitionend = resizeBakgroundImg;
navbarToggle.ontransitionstart = resizeBakgroundImg;
window.onresize = resizeBakgroundImg;
window.onload = resizeBakgroundImg;

//Para quitar el padding de la ventana maestra únicamente en esta ventana de welcome
document.querySelector('main').classList.remove('py-4')
