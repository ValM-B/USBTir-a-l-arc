import { pagination } from "./pagination.js";
import { userList } from "./userList.js";
import { userSort } from "./userSort.js";

export const userPage ={
    //sotcke la recherche ou le classement déjà effectués pour les réutiliser en cas de consultation d'une autre page et afficher la bonne liste d'utilisateurs (avant la liste était réinitialisée)
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
    
        if (userPage.sort && userPage.search) {
            //s'il y a déjà un une recherche et un classement des utilisateurs
            const response = await fetch(window.location.origin+'/admin35786/api/users?page='+pageNb+'&sort='+userPage.sort+'&order='+userSort.orientation+'&search='+userPage.search)
            return await response.json();
        } else if(userPage.sort){
            //s'il y a déjà un classement des utilisateurs
            const response = await fetch(window.location.origin+'/admin35786/api/users?page='+pageNb+'&sort='+userPage.sort+'&order='+userSort.orientation)
            return await response.json();
        } else if (userPage.search) {
            //s'il y a déjà une recherche des utilisateurs
            const response = await fetch(window.location.origin+'/admin35786/api/users?page='+pageNb+'&search='+userPage.search)
            return await response.json();
        } else {      
            const response = await fetch(window.location.origin+'/admin35786/api/users?page='+pageNb)
            return await response.json();
        }
    }
}
// dans getData on vérifie avant de faire l'appel à l'api si une recherche et/ou un classement ont déjà été fait avant. Lorsqu'une recherche est faite, le valeur de l'input est enrigstrée dans search, si un classement est fait le nom du champs est enregistré dans sort et l'orientation a déjà été stockée dans userSort.orientation.
//Ainsi, si search n'est pas null, on on demande à l'api de nous renvoyer la liste des utilisateurs selon cette recherche et le numéro de la page
// idem pour le classement 
// idem pour les 2 combinés