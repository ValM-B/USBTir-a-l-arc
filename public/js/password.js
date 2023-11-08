const password = {
	password: null,
	textHelp: null,
    init:function() {
		password.textHelp = document.querySelector("#user_password_password_first_help");
		password.password = document.querySelector("#user_password_password_first");
		password.password.addEventListener("blur", password.checkPassword);
		const btnSubmit = document.querySelector("#btn-submit");
		btnSubmit.addEventListener("click", password.checkSecondPassword);
        
    },

	checkPassword:function(event) {
		const regex = /^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/;
		if(!regex.test(password.password.value)) {
			event.preventDefault();
			password.password.classList.add("is-invalid");
			password.password.classList.remove("is-valid");
			const newP = document.createElement("p");
			newP.classList.add("text-danger", "wrong-password");
			newP.innerHTML = "Le mot de passe doit contenir au moins 6 caractères dont une majuscule, une minuscule et un chiffre.";
			password.textHelp.after(newP);
		} else {
			password.password.classList.remove("is-invalid");
			password.password.classList.add("is-valid");
			if (document.querySelector(".wrong-password")) {
				document.querySelector(".wrong-password").remove();
			}
		}
	},


	checkSecondPassword:function(event) {
		
		const inputFirstPassword = document.querySelector("#user_password_password_first");
		const inputSecondPassword = document.querySelector("#user_password_password_second");
		
		if(inputFirstPassword.value != inputSecondPassword.value) {
			event.preventDefault();
			inputSecondPassword.classList.add("is-invalid");
			inputSecondPassword.classList.remove("is-valid");
			const newP = document.createElement("p");
			newP.classList.add("text-danger", "not-same-password");
			newP.innerHTML = "Les mots de passe ne correspondent pas.";
			password.textHelp.after(newP);
		}
		else {
			inputSecondPassword.classList.remove("is-invalid");
			inputSecondPassword.classList.add("is-valid");
			if (document.querySelector(".not-same-password")) {
				document.querySelector(".not-same-password").remove();
			}
		}

}
};

document.addEventListener("DOMContentLoaded", password.init);
