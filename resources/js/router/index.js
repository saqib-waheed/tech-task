import { createRouter, createWebHistory } from 'vue-router';

import UserList from '../views/UserList.vue';
import UserForm from '../views/UserForm.vue';
import UserDetail from '../views/UserDetail.vue';

const routes = [
    { path: '/', name: 'users', component: UserList },
    { path: '/users/create', name: 'createUser', component: UserForm },
    { path: '/users/:id', name: 'userDetail', component: UserDetail },
    { path: '/users/:id/edit', name: 'editUser', component: UserForm },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
