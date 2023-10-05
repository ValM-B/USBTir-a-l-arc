import { pagination } from "./pagination.js";
import { userList } from "./userList.js";
import { userPage } from "./userPage.js";

export const userSearch = {

    searchInput : null,

    init: function(){
     
       const btnSearch = document.querySelector("#button-addon2");
       btnSearch.addEventListener("click",userSearch.handleClick);

       userSearch.searchInput = document.querySelector(".form-control");
       userSearch.searchInput.addEventListener('keypress', function(event) {
        if (event.keyCode === 13) {userSearch.handleClick();}
       })
    } ,

    /**
     * Fetches user data based on a search query.
     *
     * @returns {Promise} A promise that resolves to the fetched user data.
     */
    getData: async function(){
        userPage.search = userSearch.searchInput.value;
        
        const response = await fetch(window.location.origin+`/admin35786/api/users?search=${userPage.search}`);
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