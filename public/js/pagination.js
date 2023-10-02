import { userPage } from "./userPage.js";

export const pagination ={

	paginationList : null,
	init : function()
	{
		pagination.paginationList = document.querySelector('.pagination');

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
				document.querySelector("#previous").classList.add("disabled")
			}

			if (data.currentPage === data.nbPages) {
				document.querySelector("#next").classList.add("disabled")
			}
			pagination.paginationList.insertBefore(newPage, document.querySelector('#next'));
		}

		userPage.init();
	},

	removePages : function()
	{
		const btnsPagination = pagination.paginationList.children;

		// remove all the children from the list except the first and the last (previous and next button)
		for (let i = children.length - 2; i > 0; i--) {
			parentElement.removeChild(children[i]);
		}
	}
}