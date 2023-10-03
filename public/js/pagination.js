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

	/**
	 * Adds pagination elements based on the provided number of pages and current page.
	 * 
	 * @param {int} nbPages The total number of pages.
	 * @param {int} currentPage The current page.
	 */
	addPagination : function(nbPages, currentPage)
	{
		for (let i = 1; i <= nbPages; i++) {
			
			const pageTemplate = document.querySelector('#page-template');
			const newPage = pageTemplate.content.cloneNode(true);
			newPage.querySelector("a").textContent =  i;
			newPage.querySelector("li").id = "page-"+i;
			
			if (i === currentPage) {
				newPage.querySelector("li").classList.add("active");
			}

			if (currentPage === 1) {
				pagination.btnPrevious.classList.add("disabled")
			}

			if (currentPage === nbPages) {
				pagination.btnNext.classList.add("disabled")
			}
			pagination.paginationList.insertBefore(newPage, pagination.btnNext);
		}

		userPage.initBtnPage();
	},

	/**
	 * Resets the pagination component by removing all pagination buttons except for the previous and next buttons.
	 */
	resetPagination : function()
	{
		const btnsPagination = pagination.paginationList.children;

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