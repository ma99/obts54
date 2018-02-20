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
        path: '/staff-management',
        component: require('./views/StaffManagement')
    },
    //User
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
        component: require('./views/StaffList')
    },
    //Bus 
    {
        path: '/bus',
        component: require('./views/bus/Bus')
    },
    {
        path: '/list',
        component: require('./views/bus/BusList')
    },
    {
        path: '/route',
        component: require('./views/bus/Route')
    },
    {
        path: '/seat-plan',
        component: require('./views/bus/SeatPlan')
    },
    {
        path: '/schedule',
        component: require('./views/bus/Schedule')
    },
    {
        path: '/city',
        component: require('./views/city/City')
    },
    {
        path: '/stop',
        component: require('./views/city/Stop')
    },
    //404
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