export const userSearch = {
    init: function(){
       const inputSearch = document.querySelector(".form-control");
       const boutonSearch = document.querySelector("#button-addon2");

       boutonSearch.addEventListener("click", async function() { // Ajout de "async" ici
           const userSearchValue = inputSearch.value;

           try {
               const response = await fetch(`/search-user?search=${userSearchValue}`);
               const data = await response.json();

               console.log(data); // afficher les utilisateurs renvoyés par le serveur
           } catch (error) {
               console.error("Erreur lors de la recherche:", error);
           }
       });
    } 
}
