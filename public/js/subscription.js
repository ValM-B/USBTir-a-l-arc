const subscription = {

    btn : null,

    init:function() {
        subscription.btn = document.querySelector(".btn-subscription");
        subscription.btn.addEventListener("click", subscription.handleClick);
        
    },

    handleClick: async function(){
        const userId = subscription.btn.id.slice(5);
        fetch(window.location.origin+'/admin35786/api/users/'+userId+'/subscription',{
            method: 'PUT',
            headers: {
                'Content-Type' : 'application/json'
            },
            body: JSON.stringify({
                "subscription": true
            })
        })
        .then(response => {
            if (response.status === 200){
                return response.json()
                 .then(data => {
                    const success = document.querySelector(".alert-success")
                    success.hidden = false;
                    setTimeout(() => {success.hidden = true;}, 5000);
                    subscription.btn.hidden = true;
                    document.querySelector("#subscription").textContent = "Payée";
                });

            } else{
                return response.json()
                .then(data => {
                    const danger = document.querySelector(".alert-danger");
                    danger.querySelector("p").textContent = "Echec de la mise à jour : "+data.message;
                    danger.hidden = false;
                    setTimeout(() => {danger.hidden = true;}, 5000);
                });
            }
        })
        .catch(error => {
            const danger = document.querySelector(".alert-danger");
            danger.querySelector("p").textContent = "Une erreur s'est produite";
            danger.hidden = false;
            setTimeout(() => {danger.hidden = true;}, 5000);
        })
    }
}

document.addEventListener("DOMContentLoaded", subscription.init);