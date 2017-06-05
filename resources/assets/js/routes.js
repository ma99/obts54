import VueRouter from 'vue-router';

let routes = [
    {
        path: '/dashboard',
        component: require('./views/Home')
    },

    {
        //path: '/about',
        path: '/about',
        component: require('./views/About')
    },

    {
        path: '/contact',
        component: require('./views/Contact')
    },
     {
        path: '/profile',
        component: require('./views/Profile')
    },
     {
        path: '/roles',
        component: require('./views/Roles')
    },
     {
        path: '/staff-list',
        component: require('./views/Staff-list')
    },

    {   
        path: '*',
        //component: fourohfour
        component: require('./views/Fourohfour')
    },
];

export default new VueRouter({
    routes,
    linkActiveClass: 'active',
    mode: 'history',
    base: '/admin/'
});