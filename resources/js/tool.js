import VueQRCodeComponent from "vue-qrcode-component";

Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'nova-ug-baskets',
            path: '/nova-ug-baskets',
            component: require('./components/Tool'),
        },
    ])

    Vue.component('qr-code', VueQRCodeComponent);
})

