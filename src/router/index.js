import { createRouter, createWebHistory } from 'vue-router'
import ProductView from '../views/ProductView.vue'
import HomePage from '@/components/HomePage.vue'
import LoginForm from '@/components/LoginForm.vue'
import RegisterForm from '@/components/RegisterForm.vue'
import CourseMaterials from '@/components/CourseMaterialsPage.vue'
import Assessment from '@/components/AssessmentPage.vue'
import UserManagement from '@/components/ManageUser.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomePage
    },{
      path: '/login',
      name: 'login',
      component: LoginForm
    },
    {
      path: '/register',
      name: 'register',   
      component: RegisterForm
    },
    // {
    //   path: '/user',
    //   name: 'user',
    //   component: () => import('../components/fetchUser.vue')
    // },
    {
      path: '/course-materials',
      name: 'courseMaterials',
      component: CourseMaterials
    },
    {
      path: '/assessment',
      name: 'assessment',
      component: Assessment
    },
    {
      path: '/user-management',
      name: 'UserManagement',
      component: UserManagement,
    }
    // {
    //   path: '/product',
    //   name: 'product',
    //   component: Product
    // }
  ]
})

export default router
