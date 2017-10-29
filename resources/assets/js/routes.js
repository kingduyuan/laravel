import VueRouter from 'vue-router'

let routes = [
    {
        path: "/",
        component: require('./components/ExampleComponent.vue')
    },
    {
        path: "/hello",
        component: require('./components/Hello.vue')
    }
];

export default new VueRouter({
    linkActiveClass: "active",
    routes
});