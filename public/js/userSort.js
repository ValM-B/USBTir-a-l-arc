import { pagination } from "./pagination.js";
import { userList } from "./userList.js";
import { userPage } from "./userPage.js";

export const userSort ={

    orientation : null,

    init:function(){
        const btns = document.querySelectorAll('.btn-sort');
        for (const btn of btns) {
            btn.addEventListener('click', userSort.handleClick);
        }
    },

    /**
     * Handles the click event for sorting buttons and update the user list
     *
     * @param {Event} event - The click event object.
     */
    handleClick: function(event){
        
        const btnId = event.currentTarget.id;
        userPage.sort = btnId;
        if(event.currentTarget.classList.contains('desc'))
        {
            userSort.orientation = 'desc'
        } else {
            userSort.orientation = 'asc'
        }
        event.currentTarget.classList.toggle('desc');
        console.log(userSort.orientation);
        const userLists= userSort.getData(btnId) 
        .then(data => {
             
            userList.addUsersList(data.users);
            pagination.resetPagination();
            pagination.addPagination(data.nbPages, data.currentPage);
            
        })
    },

    /**
     * Fetches user data from the API based on sorting criteria and search query.
     *
     * @param {string} btnId - The sorting criteria.
     * @returns {Promise} A promise that resolves to the fetched user data.
     */
    getData: async function(btnId){ 
        if (userPage.search) {
            
            const response = await fetch(window.location.origin+'/admin35786/api/users?sort='+userPage.sort+'&search='+userPage.search)
            return await response.json();
        } else {      
            const response = await fetch(window.location.origin+`/admin35786/api/users?sort=${btnId}`);
            return await response.json();
        }
    },
}