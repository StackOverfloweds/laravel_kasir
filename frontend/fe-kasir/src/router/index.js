import { createRouter, createWebHistory } from 'vue-router'

// Import Views (pages/components)
import Login from '../views/Auth/Login.vue'
import Dashboard from '../views/Admin/Dashboard.vue'
import MasterDataAdmin from '../views/Admin/Master/MasterDataAdmin.vue'
import MasterDataMenu from '../views/Admin/Master/MasterDataMenu.vue'

// Pengeluaran Routes (Expenses)
import PengeluaranBelanja from '../views/Admin/Pengeluaran/PengeluaranBelanja.vue'
import TransaksiBelanja from '../views/Admin/Transaksi/TransaksiBelanja.vue'
import TransaksiPenjualan from "../views/Admin/Transaksi/TransaksiPenjualan.vue"

// import kasir 
import DashboardKasir from "../views/Kasir/DashboardKasir.vue"
import TransaksiPesanan from "../views/Kasir/Transaksi_Pesanan/TransaksiPesanan.vue"

// Import Not Available Page
import NotAvailable from '../views/NotAvailable.vue'

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
    meta: { requiresAuth: true, role: 'admin' }, // Add a custom meta field for authentication check
  },
  {
    path: '/master-data/admin',
    name: 'MasterDataAdmin',
    component: MasterDataAdmin, // Master Data Admin Page
    meta: { requiresAuth: true, role: 'admin' }, // Protected route for admin
  },
  {
    path: '/master-data/menu',
    name: 'MasterDataMenu',
    component: MasterDataMenu, // Master Data Menu Page
    meta: { requiresAuth: true, role: 'admin' }, // Protected route for admin
  },

  // Pengeluaran Routes (Expenses)
  {
    path: '/pengeluaran/belanja',
    name: 'PengeluaranBelanja',
    component: PengeluaranBelanja, // Pengeluaran Belanja (Expenses) Page
    meta: { requiresAuth: true, role: 'admin' }, // Protected route for admin
  },

  // Transaksi Belanja (Expense Transaction)
  {
    path: '/transaksi/belanja',
    name: 'TransaksiBelanja',
    component: TransaksiBelanja, // Transaction Recap Page
    meta: { requiresAuth: true, role: 'admin' }, // Protected route for admin
  },
  {
    path: '/transaksi/Penjualan',
    name: 'TransaksiPenjualan',
    component: TransaksiPenjualan, // Transaction Recap Page
    meta: { requiresAuth: true, role: 'admin' }, // Protected route for admin
  },

  // Kasir Routes
  {
    path: '/Kasir/Dashboard',
    name: 'DashboardKasir',
    component: DashboardKasir, // Kasir Dashboard
    meta: { requiresAuth: true, role: 'kasir' }, // Protected route for kasir
  },
  {
    path: '/Kasir/Transaksi_Pesanan',
    name: 'TransaksiPesanan',
    component: TransaksiPesanan, // Kasir Dashboard
    meta: { requiresAuth: true, role: 'kasir' }, // Protected route for kasir
  },

  // Route to show when accessing unavailable routes
  {
    path: '/not-available',
    name: 'NotAvailable',
    component: NotAvailable, // Show this when route doesn't exist
  },

  // Catch-all route for undefined paths
  {
    path: '/:pathMatch(.*)*',
    redirect: '/not-available', // Redirect to "Not Available" page for undefined routes
  }
]

// Create the router instance
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL), // Uses history mode for cleaner URLs
  routes, // Add routes to the router
})

// Navigation Guard to protect routes that require authentication
router.beforeEach((to, from, next) => {
  const token = sessionStorage.getItem('authToken'); // Get token from sessionStorage
  const user = sessionStorage.getItem('user'); // Get user data from sessionStorage
  
  if (token && user) {
    const parsedUser = JSON.parse(user); // Assuming 'user' is a JSON string
    const role = parsedUser.role;

    // If route requires authentication and role doesn't match
    if (to.meta.requiresAuth) {
      if (to.meta.role && to.meta.role !== role) {
        // Redirect to the appropriate dashboard based on role
        if (role === 'admin') {
          next('/dashboard'); // Redirect admin to admin dashboard
        } else if (role === 'kasir') {
          next('/Kasir/Dashboard'); // Redirect kasir to kasir dashboard
        } else {
          next('/'); // Default to login if role is unknown
        }
      } else {
        next(); // Proceed to the requested route
      }
    } else {
      next(); // Proceed to the requested route if no authentication is required
    }
  } else if (to.meta.requiresAuth) {
    // If route requires authentication but no token is found, redirect to Login
    next('/');
  } else {
    // Proceed to the requested route if no token is required
    next();
  }
})

export default router
