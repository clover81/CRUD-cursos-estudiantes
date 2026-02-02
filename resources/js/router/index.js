import { createRouter, createWebHistory } from 'vue-router';

import Courses from '../components/Courses.vue';
import Students from '../components/Students.vue';

const routes = [
  { path: '/', redirect: '/courses' },
  { path: '/courses', component: Courses },
  { path: '/students', component: Students },
];

export const router = createRouter({
  history: createWebHistory(),
  routes,
});
