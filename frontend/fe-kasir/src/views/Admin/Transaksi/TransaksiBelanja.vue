<template>
    <div class="wrapper d-flex">
      <!-- Sidebar (Navbar) -->
      <Navbar />
      
      <div class="content-container">
        <h2 class="page-title">Rekap Transaksi Belanja</h2>
        
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
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Nama Bahan</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="transaction in filteredTransactions" :key="transaction.id">
              <td>{{ transaction.date }}</td>
              <td>{{ transaction.name }}</td>
              <td>{{ transaction.quantity }}</td>
              <td>{{ currencyFormatter(transaction.price) }}</td>
              <td>{{ currencyFormatter(transaction.quantity * transaction.price) }}</td>
            </tr>
          </tbody>
        </table>
        
        <!-- Total Amount -->
        <div class="total-amount">
          <h3>Total Belanja: {{ currencyFormatter(totalAmount) }}</h3>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Navbar from "../../../components/Navbar.vue"; 
  import { TransaksiBelanja } from "../../../lib/API/Transaksi/TransaksiBelanja";
  
  export default {
    name: "TransaksiBelanja",
    components: {
      Navbar
    },
    data() {
      return {
        transactions: [],  // Holds the full list of transactions
        searchDate: "",
        filteredTransactions: [],  // Holds filtered transactions based on search date
      };
    },
    computed: {
      totalAmount() {
        // Calculate the total amount for the filtered transactions
        return this.filteredTransactions.reduce(
          (total, transaction) => total + transaction.quantity * transaction.price,
          0
        );
      }
    },
    methods: {
      filterTransactions() {
        // Filter transactions based on the search date
        this.filteredTransactions = this.searchDate
          ? this.transactions.filter((transaction) => transaction.date === this.searchDate)
          : this.transactions;
      },
      currencyFormatter(value) {
        return TransaksiBelanja.currencyFormatter(value);
      }
    },
    created() {
      // Fetch the transaction data when the component is created
      TransaksiBelanja.setupData(this);
    }
  };
  </script>
  
  <style scoped>
  .wrapper {
    display: flex;
    min-height: 100vh;
  }
  
  .content-container {
    margin-left: 250px;
    padding: 30px;
    background-color: #ecf0f1;
    width: calc(100% - 250px);
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
  }
  
  .page-title {
    font-size: 2rem;
    margin-bottom: 20px;
  }
  
  .search-container {
    max-width: 300px;
    margin-bottom: 20px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  table th, table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  
  table th {
    background-color: #3498db;
    color: white;
  }
  
  table tr:hover {
    background-color: #f0f8ff;
  }
  
  .total-amount {
    margin-top: 20px;
    font-size: 1.5rem;
    font-weight: bold;
  }
  
  .total-amount h3 {
    color: #27ae60;
  }
  
  /* Responsive design */
  @media (max-width: 768px) {
    .wrapper {
      flex-direction: column;
    }
  
    .content-container {
      margin-left: 0;
      width: 100%;
    }
  
    .page-title {
      font-size: 1.5rem;
    }
  }
  </style>
  