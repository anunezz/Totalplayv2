export default {
    methods: {
        startLoading() {
            return this.$store.dispatch(
                'loading/spinner', {msg: 'Cargando Datos...', status: true}, {root: true});
        },

        stopLoading() {
            return this.$store.dispatch('loading/spinner', {}, {root: true});
        }
    },
};
