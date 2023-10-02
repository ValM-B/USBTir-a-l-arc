import { userList } from "./userList.js";
import { userPage } from "./userPage.js";
import { userSearch } from "./userSearch.js";
import { userSort } from "./userSort.js";

const app = {
    init:function() {
        userList.init();
        userPage.init();
        userSearch.init();
        userSort.init();
    }
}

// {{ path('app_back_user_show', {'id': user.id}) }}
document.addEventListener("DOMContentLoaded", app.init);