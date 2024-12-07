import { createRouter, createWebHistory } from 'vue-router'

// Import Views (pages/components)
import Login from '../views/Auth/Login.vue'
import Dashboard from '../views/Admin/Dashboard.vue'
import MasterDataAdmin from '../views/Admin/Master/MasterDataAdmin.vue'
import MasterDataCategory from '../views/Admin/Master/MasterDataCategory.vue'
import MasterDataMenu from '../views/Admin/Master/MasterDataMenu.vue'

// Pengeluaran Routes (Expenses)
import PengeluaranBelanja from '../views/Admin/Pengeluaran/PengeluaranBelanja.vue'
import  TransaksiBelanja  from '../views/Admin/Transaksi/TransaksiBelanja.vue'
// Define Routes
const routes = [
  // Login route (this will be the root route)
  {
    path: '/',
    name: 'Login',
    component: Login, // This is the Login Page
  },

  // Admin routes (these are only accessible after login)
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard, // Admin Dashboard
  },
  {
    path: '/master-data/admin',
    name: 'MasterDataAdmin',
    component: MasterDataAdmin, // Master Data Admin Page
  },
  {
    path: '/master-data/category',
    name: 'MasterDataCategory',
    component: MasterDataCategory, // Master Data Category Page
  },
  {
    path: '/master-data/menu',
    name: 'MasterDataMenu',
    component: MasterDataMenu, // Master Data Menu Page
  },

  // Pengeluaran Routes (Expenses)
  {
    path: '/pengeluaran/belanja',
    name: 'PengeluaranBelanja',
    component: PengeluaranBelanja, // Pengeluaran Belanja (Expenses) Page
  },

  // Transaksi Belanja (Expense Transaction)
  {
    path: '/transaksi/belanja',
    name: 'TransaksiBelanja',
    component: TransaksiBelanja, // Transaction Recap Page
  },

  // Optionally, redirect any unknown routes to login
  {
    path: '/:pathMatch(.*)*',
    redirect: '/', // If route doesn't match, redirect to login page
  }
]

// Create the router instance
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL), // Uses history mode for cleaner URLs
  routes, // Add routes to the router
})

export default router