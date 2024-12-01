import "./bootstrap";

import axios from "axios";
window.axios = axios;

// Set Axios defaults (optional, e.g., CSRF token)
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
