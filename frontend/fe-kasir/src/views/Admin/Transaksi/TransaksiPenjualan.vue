<template>
    <div class="wrapper d-flex">
      <!-- Sidebar (Navbar) -->
      <Navbar />
  
      <div class="content-container">
        <h2 class="page-title">Rekap Transaksi Penjualan</h2>
  
        <!-- Date Search Input -->
        <div class="mb-3 search-container">
          <label for="searchDate" class="form-label">Cari Berdasarkan Tanggal</label>
          <input
            type="date"
            class="form-control"
            id="searchDate"
            v-model="searchDate"
            @input="filterTransactions"
          />
        </div>
  
        <!-- Table of Transactions -->
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID Transaksi</th>
              <th>Menu</th>
              <th>Jumlah</th>
              <th>Total Harga</th>
              <th>Metode Pembayaran</th>
              <th>Tanggal Transaksi</th>
              <th>User</th> <!-- Changed to display user name -->
            </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in filteredTransactions" :key="transaction.id">
              <td>{{ transaction.id }}</td>
              <td>{{ transaction.menu_name }}</td> <!-- Updated to menu_name -->
              <td>{{ transaction.quantity }}</td>
              <td>Rp {{ transaction.total_amount }}</td>
              <td>{{ transaction.payment_method }}</td>
              <td>{{ transaction.transaction_date }}</td>
              <td>{{ transaction.user_name }}</td> <!-- Display user name -->
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import Navbar from "../../../components/Navbar.vue";
  
  export default {
    name: "TransaksiPenjualan",
    components: {
      Navbar,
    },
    data() {
      return {
        transactions: [], // To store all transactions
        filteredTransactions: [], // To store filtered transactions based on date
        searchDate: "", // Date input for filtering
        apiUrl: "http://localhost:8000", // Replace with the actual API URL
      };
    },
    methods: {
      // Fetch the transactions from the backend
      async fetchTransactions() {
        try {
          const response = await axios.get(
            `${this.apiUrl}/api/admin/sales-transactions`
          );
          console.log("Fetched Data:", response.data); // Log the fetched data
          this.transactions = response.data;
          this.filteredTransactions = response.data; // Initialize with all transactions
        } catch (error) {
          console.error("Error fetching transactions:", error);
        }
      },
  
      filterTransactions() {
        console.log("Filtering transactions by date:", this.searchDate);
        if (this.searchDate) {
          this.filteredTransactions = this.transactions.filter(
            (transaction) => {
              return transaction.transaction_date === this.searchDate;
            }
          );
        } else {
          this.filteredTransactions = this.transactions;
        }
      },
    },
    created() {
      // Fetch transactions when the component is created
      this.fetchTransactions();
    },
  };
  </script>
  
  <style scoped>
  .wrapper {
    display: flex;
    width: 100%;
  }
  
  .content-container {
    width: 100%;
    padding: 20px;
    background-color: #f9f9f9;
  }
  
  .page-title {
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
  }
  
  .search-container {
    margin-bottom: 20px;
    max-width: 400px;
  }
  
  .search-container .form-label {
    font-weight: 500;
    color: #333;
  }
  
  .table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    background-color: #fff;
  }
  
  .table th,
  .table td {
    padding: 12px 15px;
    text-align: center;
    border: 1px solid #ddd;
  }
  
  .table th {
    background-color: #007bff;
    color: white;
  }
  
  .table td {
    font-size: 1rem;
    color: #555;
  }
  
  .table tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  .table tr:hover {
    background-color: #ddd;
  }
  
  .form-control {
    border-radius: 5px;
    padding: 10px;
  }
  
  @media (max-width: 768px) {
    .table th,
    .table td {
      padding: 8px;
    }
  
    .page-title {
      font-size: 1.6rem;
    }
  
    .search-container {
      width: 100%;
    }
  }
  </style>
  