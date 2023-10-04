
import { userSearch } from "./userSearch.js";
import { userSort } from "./userSort.js";
import { pagination } from "./pagination.js";
import { userPage } from "./userPage.js";

const app = {
    init:function() {
        pagination.init();
        userPage.init();
        userSearch.init();
        userSort.init();
        
    }
}

document.addEventListener("DOMContentLoaded", app.init);

