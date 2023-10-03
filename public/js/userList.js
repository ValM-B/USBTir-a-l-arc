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
                data.forEach(user => {
                    const newTemplate = template.content.cloneNode(true);
                    newTemplate.querySelector(".user-id").textContent = user.id;
                    newTemplate.querySelector(".user-licenceNumber").textContent = user.licenceNumber;
                    newTemplate.querySelector(".user-firstname").textContent = user.firstname;
                    newTemplate.querySelector(".user-lastname").textContent = user.lastname;
                    newTemplate.querySelector(".user-position").textContent = user.position;
                    newTemplate.querySelector(".btn-show").href = window.location.href + user.id;
                    newTemplate.querySelector(".btn-edit ").href = window.location.href + user.id + "/edit";
                    tbody.append(newTemplate);
                });
            })
    }
}