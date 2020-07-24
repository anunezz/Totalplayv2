<template>
    <div>
        <admin-menu v-if="$store.state.user.profile === 1"/>
        <users-menu v-if="$store.state.user.profile !== 1"/>
    </div>
</template>

<script>
    //import HeaderSection from "../layouts/partials/HeaderSection";
    import AdminMenu from './partials/AdminMenu';
    import UsersMenu from './partials/UsersMenu';
    import NotAssignedMenu from './partials/NotAssignedMenu';

    export default {
        components: {
            AdminMenu,
            UsersMenu,
            NotAssignedMenu,
         //   HeaderSection
        },

        created() {
            console.log("aqui... menu");
            let data = {cat_transaction_type_id : 1, action: 'Entra a inicio'};

            axios.post('/api/transaction', data).then(response => {
            }).catch(error => {
                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });
        },
    }
</script>

<style scoped>

</style>
