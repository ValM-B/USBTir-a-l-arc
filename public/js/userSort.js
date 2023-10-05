import { pagination } from "./pagination.js";
import { userList } from "./userList.js";
import { userPage } from "./userPage.js";

export const userSort ={
    //détermine si le classement est croissant ou décroissant
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
            //si la classe desc existe alors le classement sera décroissant
            userSort.orientation = 'desc'
        } else {
            //si elle nexiste pas alors le classement sera croissant
            userSort.orientation = 'asc'
        }
        // ajoute ou retire la classe desc
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
            //s'il y a déjà un une recherche des utilisateurs
            const response = await fetch(window.location.origin+'/admin35786/api/users?sort='+userPage.sort+'&order='+userSort.orientation+'&search='+userPage.search)
            return await response.json();
        } else {   
            //   &order=${userSort.orientation} indique si le classement sera croissant ou décroissant
            const response = await fetch(window.location.origin+`/admin35786/api/users?sort=${btnId}&order=${userSort.orientation}`);
            return await response.json();
        }
    },
}

// ici on vérifie si le bouton a une classe desc s'il l'a on indique que "orientation" = desc puis on supprime la classe, s'il ne l'a pas on indique orientation = asc et on ajoute la classe desc, puis on ajoute l'orientation dans l'url afin de transmettre l'orientation à l'api. Ainsi à chaque fois qu'on clique sur le bouton le classement sera un coup asc un coup desc.