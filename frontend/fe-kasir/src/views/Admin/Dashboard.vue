<template>
    <div class="wrapper">
      <!-- Sidebar (Navbar) -->
      <Navbar />
  
      <!-- Main Content (Dashboard) -->
      <div class="dashboard-container">
        <h1 class="dashboard-title">Dashboard</h1>
        <div class="dashboard-grid">
          <!-- Card 1 -->
          <div class="card purple">
            <h5>Total Pengeluaran Belanja</h5>
          </div>
  
          <!-- Card 2 -->
          <div class="card green">
            <h5>Total Makanan</h5>
          </div>
  
          <!-- Card 3 -->
          <div class="card blue">
            <h5>Calender</h5>
          </div>
  
          <!-- Card 4 -->
          <div class="card red">
            <h5>Total Pendapatan Toko</h5>
          </div>
  
          <!-- Card 5 -->
          <div class="card green">
            <h5>Total Minuman</h5>
          </div>
  
          <!-- Card 6 -->
          <div class="card blue">
            <h5>Staff Pegawai</h5>
            <p>Dyah Adventa</p>
            <p>Puti Maharani</p>
          </div>
  
          <!-- Card 7 -->
          <div class="card green">
            <h5>About Warung Makan</h5>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Navbar from "../../components/Navbar.vue";  // Import the Navbar component
  
  export default {
    name: "Dashboard",
    components: {
      Navbar, // Register the Navbar component
    },
  };
  </script>
  
  <style scoped>
  /* Wrapper for the entire layout */
  .wrapper {
    display: flex;
    height: 100vh;
  }
  
  /* Main Dashboard Styling */
  .dashboard-container {
    flex-grow: 1;
    padding: 20px;
    background-color: #f0f0f0;
  }
  
  .dashboard-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
  }
  
  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }
  
  .card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .card h5 {
    margin-bottom: 10px;
    font-size: 1.25rem;
    font-weight: bold;
  }
  
  .purple {
    background-color: #9c4de1;
    color: #fff;
  }
  
  .green {
    background-color: #7ecf7e;
    color: #fff;
  }
  
  .red {
    background-color: #ff6f61;
    color: #fff;
  }
  
  .blue {
    background-color: #5b9bd5;
    color: #fff;
  }
  </style>
  