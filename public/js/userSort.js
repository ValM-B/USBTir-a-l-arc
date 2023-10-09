import { pagination } from "./pagination.js";
import { userList } from "./userList.js";
import { userPage } from "./userPage.js";

export const userSort ={
    //Determines if the sorting is ascending or descending
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
            //If the 'desc' class exists, then the sorting will be descending
            userSort.orientation = 'desc'
        } else {
            //If it doesn't exist, then the sorting will be ascending.
            userSort.orientation = 'asc'
        }
        // Add or remove the 'desc' class
        event.currentTarget.classList.toggle('desc');
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
            //If there is already a search for users
            const response = await fetch(window.location.origin+'/admin35786/api/users?sort='+userPage.sort+'&order='+userSort.orientation+'&search='+userPage.search)
            return await response.json();
        } else {   
            //   &order=${userSort.orientation} indicates whether the sorting will be ascending or descending
            const response = await fetch(window.location.origin+`/admin35786/api/users?sort=${btnId}&order=${userSort.orientation}`);
            return await response.json();
        }
    },
}

// Here, we check if the button has a "desc" class. If it does, we set "orientation" to "desc," then remove the class. If it doesn't have the class, we set "orientation" to "asc" and add the "desc" class. Then, we add the "orientation" to the URL to pass the orientation to the API. This way, every time we click the button, the sorting will alternate between ascending and descending.