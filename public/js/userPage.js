import { pagination } from "./pagination.js";
import { userList } from "./userList.js";

export const userPage ={
    
    search : null,
    sort : null,
    /**
     * Initializes the user page with user data of de first page
     */
    init:function(){
        
        const getUserList = async function(){
            const response = await fetch(window.location.origin+'/admin35786/api/users');
            return await response.json();
        }
        const showListUsers = getUserList()
            .then(data => {
                userList.addUsersList(data.users);
                pagination.addPagination(data.nbPages, data.currentPage);
            })
    
    },

    /**
     * Initializes the button click event handlers for pagination buttons.
     */
    initBtnPage: function(){
        const btnsPage = document.querySelectorAll(".page-item");
        for (const btn of btnsPage) {
            if (!btn.classList.contains('disabled')) {
                btn.addEventListener("click", userPage.handleClick);
            } else {
                btn.removeEventListener("click", userPage.handleClick);
            }
        }
    },

    /**
     *  Handles a click event on pagination buttons and updates the user list.
     * @param {Event} event 
     */
    handleClick: function(event)
    {
        event.preventDefault();
        const btnId = event.currentTarget.id;
        const currentPage = parseInt(document.querySelector(".pagination .active").id.slice(5));
               
        if (btnId === "previous") {
            const pageNb = currentPage - 1;
            userPage.updateUsersList(pageNb);
            
        } else if (btnId === "next"){
           
            const pageNb = currentPage + 1;
            userPage.updateUsersList(pageNb);
            
        } else if(!event.currentTarget.classList.contains('active')){
            const pageNb = btnId.slice(5);
            userPage.updateUsersList(pageNb);
        }
    },

    /**
     * Updates the user list by fetching data for the specified page number.
     * 
     * @param {int} pageNb The page number for which to fetch user data.
     */
    updateUsersList: function(pageNb)
    {
        const usersList = userPage.getData(pageNb)
            .then(data => {
                
                userList.addUsersList(data.users);
                pagination.resetPagination();
                pagination.addPagination(data.nbPages, data.currentPage);
            })
    },

    /**
     * Retrieves user data for a specific page number from the API.
     * 
     * @param {int} pageNb The page number for which to retrieve user data.
     * @returns {Promise} A promise that resolves to the fetched user data.
     */
    getData: async function( pageNb )
    {
        if(userPage.sort){
            const response = await fetch(window.location.origin+'/admin35786/api/users?page='+pageNb+'&sort='+userPage.sort)
            return await response.json();
        }
        const response = await fetch(window.location.origin+'/admin35786/api/users?page='+pageNb)
        return await response.json();
    }
}