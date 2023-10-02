import { userList } from "./userList.js";
import { userSearch } from "./userSearch.js";
import { userSort } from "./userSort.js";
import { pagination } from "./pagination.js";

const app = {
    init:function() {
        userList.init();
        userSearch.init();
        userSort.init();
        pagination.init();
    }
}

document.addEventListener("DOMContentLoaded", app.init);