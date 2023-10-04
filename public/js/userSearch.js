import { pagination } from "./pagination.js";
import { userList } from "./userList.js";
import { userPage } from "./userPage.js";

export const userSearch = {

    init: function(){
     
       const btnSearch = document.querySelector("#button-addon2");
       btnSearch.addEventListener("click",userSearch.handleClick); 
    } ,

    /**
     * Fetches user data based on a search query.
     *
     * @returns {Promise} A promise that resolves to the fetched user data.
     */
    getData: async function(){
        const inputSearch = document.querySelector(".form-control");
        userPage.search = inputSearch.value;
        
        const response = await fetch(window.location.origin+`/admin35786/api/users?search=${inputSearch.value}`);
        return await response.json();
    },

    /**
     * Handles the click event for the search button and updates the user list.
     */
    handleClick : function(){

        const userLists= userSearch.getData() 
        .then(data => {
             
            userList.addUsersList(data.users);
            pagination.resetPagination();
            pagination.addPagination(data.nbPages, data.currentPage);
            
        })
        document.querySelector(".form-control").value ="";
    }
}