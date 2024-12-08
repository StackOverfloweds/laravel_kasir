<template>
  <nav class="navbar">
    <div class="logo-container">
      <img src="../../assets/logo.png" alt="Logo" class="logo" />
      <span class="admin-name">Kasir</span>
    </div>
    <ul class="nav-links">
<!-- 
      <li><router-link to="/Kasir/Transaksi_Pesanan" class="nav-link">Transaksi Pesanan</router-link></li> -->
      <!-- Logout link -->
      <li><a href="#" @click="logout" class="nav-link">Logout</a></li>
    </ul>
  </nav>
</template>

<script>
import LogoutUser from '../../lib/API/Auth/LogoutUser'; // Import LogoutUser class

export default {
  name: "Navbar",
  data() {
    return {
      isDropdownVisible: false, // Track the visibility of the Master Data dropdown
      isTransactionDropdownVisible: false, // Track the visibility of the Transaksi dropdown
    };
  },
  methods: {
    toggleDropdown() {
      this.isDropdownVisible = !this.isDropdownVisible; // Toggle the Master Data dropdown menu
    },
    toggleTransactionDropdown() {
      this.isTransactionDropdownVisible = !this.isTransactionDropdownVisible; // Toggle the Laporan Transaksi dropdown menu
    },
    async logout() {
      try {
        // Call the logout method to invalidate the token
        const response = await LogoutUser.Logout(); 

        // Optionally, redirect to the login page
        this.$router.push('/'); // Navigate to login page after logout

        // Show a success message
        alert(response.message || 'Successfully logged out');
      } catch (error) {
        console.error('Logout error:', error);
        alert('An error occurred while logging out.');
      }
    }
  },
};
</script>

<style scoped>
/* Full height navbar */
.navbar {
  background-color: #f1f1f1;
  width: 250px;
  height: 100vh; /* Full height */
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between; /* Ensure navbar items are spaced out */
}

.logo-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}

.logo {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}

.admin-name {
  font-size: 14px;
  margin-top: 5px;
}

.nav-links {
  list-style-type: none;
  padding: 0;
  flex-grow: 1; /* Allow the navigation links to fill available space */
}

.nav-link {
  display: block;
  color: #333;
  padding: 10px;
  text-decoration: none;
  margin-bottom: 10px;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.nav-link:hover {
  background-color: #ddd;
}

.dropdown {
  position: relative;
}

.dropdown-menu {
  display: block;
  position: absolute;
  top: 40px; /* Adjust based on your design */
  left: 0;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 10px 0;
  width: 100%;
}

.dropdown-menu .nav-link {
  padding-left: 20px; /* Indentation for submenu items */
}

.dropdown-menu .nav-link:hover {
  background-color: #e6e6e6;
}

/* Logout link at the bottom */
.nav-links li:last-child {
  margin-top: auto; /* Push the logout link to the bottom */
}

/* Responsive Styles */
@media (max-width: 768px) {
  .navbar {
    width: 100%; /* Full width on small screens */
    padding: 10px;
  }

  .logo {
    width: 40px;
    height: 40px;
  }

  .admin-name {
    font-size: 12px;
  }

  .nav-links {
    display: flex;
    flex-direction: column;
  }

  .dropdown-menu {
    position: static;
    box-shadow: none;
    padding: 5px 0;
  }

  .nav-link {
    padding: 8px 10px;
  }
}
</style>
