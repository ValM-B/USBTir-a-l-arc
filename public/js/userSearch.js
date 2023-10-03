export const userSearch = {
    init: function(){
     
       const boutonSearch = document.querySelector("#button-addon2");

       boutonSearch.addEventListener("click",userSearch.handleClick); 
    } ,
     getData: async function(){
        const inputSearch = document.querySelector(".form-control");
        const response = await fetch(`http://localhost:8000/api/users?search=${inputSearch.Value}`);
        return await response.json();
    },
    handleClick : function(){
        const userList= userSearch.getData() 
        .then(data => {console.log(data)
            
        })
    }
}