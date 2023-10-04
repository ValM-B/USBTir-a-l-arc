import { pagination } from "./pagination.js";
import { userList } from "./userList.js";

export const userSort ={
    init:function(){
        const btns = document.querySelectorAll('.btn-sort');
        for (const btn of btns) {
            btn.addEventListener('click', userSort.handleClick);
        }
    },

    handleClick: function(event){
        const btnId = event.currentTarget.id;
        const userLists= userSort.getData(btnId) 
        .then(data => {
             
            userList.addUsersList(data.users);
            pagination.resetPagination();
            pagination.addPagination(data.nbPages, data.currentPage);
            
        })
    },
    getData: async function(btnId){        
        const response = await fetch(window.location.origin+`/admin35786/api/users?sort=${btnId}`);
        return await response.json();
    },
}