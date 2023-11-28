const navbar = {
    init:function() {
		window.addEventListener("scroll", function() {
			let nav = document.querySelector("#navbar");
			let logo = document.querySelectorAll(".logo");
			nav.classList.toggle("sticky", window.scrollY > 0);
			logo.forEach(element => {
				element.classList.toggle("logo-sticky", window.scrollY > 0);
			});
		});
	}
}

document.addEventListener("DOMContentLoaded", navbar.init);