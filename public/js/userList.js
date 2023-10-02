import { pagination } from "./pagination.js";


export const userList ={
    init:function(){
        const tbody = document.querySelector("#user-tbody");
        const template = document.querySelector("#user-template");
        const getListUser = async function(){
            const response = await fetch('http://localhost:8000/api/users');
            return await response.json();
        }
        const showListUsers = getListUser()
            .then(data => {
                
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

                pagination.addPagination(data);

                // const pagination = document.querySelector('.pagination');

                // for (let i = 1; i <= data.nbPages; i++) {
                    
                //     const pageTemplate = document.querySelector('#page-template');
                //     const newPage = pageTemplate.content.cloneNode(true);
                //     newPage.querySelector("a").textContent =  i;
                //     newPage.querySelector("li").id = "page-"+i;
                    
                //     if (i === data.currentPage) {
                //         console.log(data.currentPage);
                //         newPage.querySelector("li").classList.add("active");
                //     }

                //     if (data.currentPage === 1) {
                //         document.querySelector("#previous").classList.add("disabled")
                //     }

                //     if (data.currentPage === data.nbPages) {
                //         document.querySelector("#next").classList.add("disabled")
                //     }
                //     pagination.insertBefore(newPage, document.querySelector('#next'));
                // }

                // userPage.init();
                
            })
    }
}