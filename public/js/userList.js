export const userList ={

    /**
     * Adds a list of user data to the HTML table.
     * 
     * @param {array} data An array of user objects containing user data.
     */
    addUsersList:function(data){
    const tbody = document.querySelector("#user-tbody");
    tbody.innerHTML="";
    const template = document.querySelector("#user-template");
    
    data.forEach(user => {
        const newTemplate = template.content.cloneNode(true);
        newTemplate.querySelector(".user-id").textContent = user.id;
        newTemplate.querySelector(".user-licenceNumber").textContent = user.licenceNumber;
        newTemplate.querySelector(".user-firstname").textContent = user.firstname;
        newTemplate.querySelector(".user-lastname").textContent = user.lastname;
        if (user.position) {
            newTemplate.querySelector(".user-position").textContent = user.position;
        } else {
            newTemplate.querySelector(".user-position").textContent = "aucune";
        }
        
        newTemplate.querySelector(".btn-show").href = window.location.href + user.id;
        newTemplate.querySelector(".btn-edit ").href = window.location.href + user.id + "/edit";
        tbody.append(newTemplate);
    })       
    },

}