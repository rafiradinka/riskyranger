// Ketika di-scroll, background navbar yg transparan akan jadi berwarna
const navbar = document.getElementsByTagName("nav")[0];
window.addEventListener("scroll", function () {
  console.log(window.scrollY);
  if (this.window.scrollY > 1) {
    navbar.classList.replace("bg-transparent", "nav-color");
  } else if (this.window.scrollY <= 0) {
    navbar.classList.replace("nav-color", "bg-transparent");
  }
});

// Add and Remove active class
const navbarLink = document.querySelectorAll(".nav-link");

navbarLink.forEach((navLink) => {
  navLink.addEventListener("click", () => {
    document.querySelector(".active")?.classList.remove("active");
    navLink.classList.add("active");
  });
});




