import { pagination } from "./pagination.js";
import { userList } from "./userList.js";

export const userSearch = {
    init: function(){
     
       const boutonSearch = document.querySelector("#button-addon2");

       boutonSearch.addEventListener("click",userSearch.handleClick); 
    } ,
     getData: async function(){
        const inputSearch = document.querySelector(".form-control");
        
        const response = await fetch(window.location.origin+`/admin35786/api/users?search=${inputSearch.value}`);
        return await response.json();
    },
    handleClick : function(){
        const userLists= userSearch.getData() 
        .then(data => {
             
            userList.addUsersList(data.users);
             pagination.resetPagination();
            pagination.addPagination(data.nbPages, data.currentPage);
            
        })
    }
}