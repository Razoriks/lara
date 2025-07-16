import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

import "../scss/app.scss";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

createApp(App).use(router).mount("#app");
