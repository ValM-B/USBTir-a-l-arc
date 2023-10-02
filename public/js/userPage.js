import { pagination } from "./pagination.js";

export const userPage ={
    tbody : null,
    btnsPage : null,
    init:function(){
        userPage.tbody = document.querySelector(".user-tbody");

        userPage.btnsPage = document.querySelectorAll(".page-item");
       
        for (const btn of userPage.btnsPage) {
            btn.addEventListener("click", userPage.handleClick);
        }
    //  TODO charge le page 1 en init
    },

    handleClick: function(event)
    {
        event.preventDefault();
        const btnId = event.currentTarget.id;
       
        
        if (btnId === "previous" && !event.currentTarget.classList.contains('disabled')) {
            console.log("ok")
        } else if (btnId === "next" && !event.currentTarget.classList.contains('disabled')){
            console.log("ok next")
        } else if(!event.currentTarget.classList.contains('active')){
            const pageNb = btnId.slice(5);
            const usersList = userPage.getData(pageNb)
                .then(data => {
                    
                    const tbody = document.querySelector("#user-tbody");
                    tbody.innerHTML="";
                    const template = document.querySelector("#user-template");
                    data.users.forEach(user => {

                        
                        const newTemplate = template.content.cloneNode(true);
                        newTemplate.querySelector(".user-id").textContent = user.id;
                        newTemplate.querySelector(".user-licenceNumber").textContent = user.licenceNumber;
                        newTemplate.querySelector(".user-firstname").textContent = user.firstname;
                        newTemplate.querySelector(".user-lastname").textContent = user.lastname;
                        newTemplate.querySelector(".user-position").textContent = user.position;
                        
                        newTemplate.querySelector(".btn-show").href = window.location.href + user.id;
                        newTemplate.querySelector(".btn-edit ").href = window.location.href + user.id + "/edit";
                        tbody.append(newTemplate);
                    })
    
                    pagination.resetPagination();
                    pagination.addPagination(data);
                })
            
        }
    },

    getData: async function( pageNb )
    {
        const response = await fetch('http://localhost:8000/api/users?page='+pageNb)
        return await response.json();
    }
}