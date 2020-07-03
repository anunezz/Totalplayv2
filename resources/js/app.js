require("./main");
import App from "./components/views/layouts/App.vue";
import store from "./store";
import VueRouter from "vue-router";
import {routes} from "./routes.js";

import {MessageBox} from 'element-ui';

const router = new VueRouter({
    mode: "history",
    base: __dirname,
    linkActiveClass: "active",
    routes: routes,
    linkExactActiveClass: "active",
});

store.dispatch('getUserInfo')
    .then(() => {setNotice()})
    .catch(() => {setNotice()});

function setNotice() {
    return new Vue({
        el: "#app",
        router,
        store,
        render: h => h(App),
        data() {
            return {
                idleActive: false
            }
        },
        onIdle() {
            if (window.sessionStorage.getItem("SERIDH_token") && this.idleActive === false) {
                this.idleActive = true;
                this.removeSession();
            }
        },
        methods: {
            removeSession() {

                let closeIn60Seconds = setTimeout(() => {
                    axios.post("/api/logout")
                        .then(response => {
                            if (response.data.authenticated === false) {
                                store.dispatch('logout');
                                this.$router.push("/ingresar");
                            } else {
                                this.$message({
                                    type: "warning",
                                    message: "No fue posible cerrar su sesión."
                                });
                            }

                            this.idleActive = false;
                            MessageBox.close();
                        })
                        .catch(error => {
                            this.idleActive = false;
                            MessageBox.close();
                            this.$message({
                                type: "warning",
                                message: "No fue posible cerrar su sesión."
                            });
                        });
                }, 30000); // Will close on 30 seconds

                this.$confirm(
                    'La aplicación se cerrará en los próximos 30 segundos, ningún cambio será guardado.',
                    'La sessión expirará pronto',
                    {
                        confirmButtonText: 'Continuar en la aplicación',
                        showClose: false,
                        showCancelButton: false,
                        closeOnPressEscape: false,
                        closeOnClickModal: false,
                        type: 'warning',
                        center: true
                    })
                    .then(_ => {
                        this.idleActive = false;
                        clearTimeout(closeIn60Seconds);
                        done();
                    })
                    .catch(_ => {

                    });
            }

        }
    });
}
