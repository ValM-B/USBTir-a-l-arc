import { userPage } from "./userPage.js";

export const pagination ={

	paginationList : null,
	btnPrevious : null,
	btnNext :null,

	init : function()
	{
		pagination.paginationList = document.querySelector('.pagination');
		pagination.btnPrevious = document.querySelector("#previous");
		pagination.btnNext = document.querySelector("#next")

	},

	addPagination : function(data)
	{
		for (let i = 1; i <= data.nbPages; i++) {
			
			const pageTemplate = document.querySelector('#page-template');
			const newPage = pageTemplate.content.cloneNode(true);
			newPage.querySelector("a").textContent =  i;
			newPage.querySelector("li").id = "page-"+i;
			
			if (i === data.currentPage) {
				console.log(data.currentPage);
				newPage.querySelector("li").classList.add("active");
			}

			if (data.currentPage === 1) {
				pagination.btnPrevious.classList.add("disabled")
			}

			if (data.currentPage === data.nbPages) {
				pagination.btnNext.classList.add("disabled")
			}
			pagination.paginationList.insertBefore(newPage, pagination.btnNext);
		}

		userPage.init();
	},

	resetPagination : function()
	{
		const btnsPagination = pagination.paginationList.children;

		// remove all the children from the list except the first and the last (previous and next button)
		for (let i = btnsPagination.length - 2; i > 0; i--) {
			pagination.paginationList.removeChild(btnsPagination[i]);
		}

		if(pagination.btnPrevious.classList.contains('disabled'))
		{
			pagination.btnPrevious.classList.remove('disabled')
		}
		if(pagination.btnNext.classList.contains('disabled'))
		{
			pagination.btnNext.classList.remove('disabled')
		}
	}
}