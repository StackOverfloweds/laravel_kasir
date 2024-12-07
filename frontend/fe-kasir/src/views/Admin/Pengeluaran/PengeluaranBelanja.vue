<template>
    <div class="wrapper d-flex">
      <!-- Sidebar (Navbar) -->
      <Navbar />
    
      <!-- Main Content Area -->
      <div class="content flex-grow-1 mt-5">
        <div class="container">
          <h2>Pengeluaran Belanja</h2>
          <button class="btn btn-primary mb-3" @click="showAddExpenseForm">
            Tambah Bahan Belanja
          </button>
    
          <!-- Conditionally Rendered Form for Adding or Editing Item -->
          <div v-if="isAddingExpense" class="mb-4">
            <h3>{{ isEditing ? "Edit Bahan Belanja" : "Tambah Bahan Belanja" }}</h3>
            <form @submit.prevent="isEditing ? updateExpense() : addExpense()">
              <div class="mb-3">
                <label for="itemName" class="form-label">Nama Bahan</label>
                <input
                  type="text"
                  class="form-control"
                  id="itemName"
                  v-model="newExpense.name"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="itemQuantity" class="form-label">Jumlah Bahan</label>
                <input
                  type="number"
                  class="form-control"
                  id="itemQuantity"
                  v-model="newExpense.quantity"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="itemPrice" class="form-label">Harga per Bahan</label>
                <input
                  type="number"
                  class="form-control"
                  id="itemPrice"
                  v-model="newExpense.price"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="expenseDate" class="form-label">Tanggal Belanja</label>
                <input
                  type="date"
                  class="form-control"
                  id="expenseDate"
                  v-model="newExpense.date"
                  required
                />
              </div>
              <button type="submit" class="btn btn-success">{{ isEditing ? "Update" : "Tambah Belanja" }}</button>
              <button type="button" class="btn btn-secondary ms-2" @click="cancelAddExpense">
                Batal
              </button>
            </form>
          </div>
    
          <!-- Table of Expenses -->
          <table class="table table-striped" v-if="!isAddingExpense">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama Bahan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="expense in expenses" :key="expense.id">
                <td>{{ expense.date }}</td>
                <td>{{ expense.name }}</td>
                <td>{{ expense.quantity }}</td>
                <td>{{ expense.price | currency }}</td>
                <td>
                  <button class="btn btn-warning" @click="editExpense(expense.id)">
                    Edit
                  </button>
                  <button class="btn btn-danger" @click="deleteExpense(expense.id)">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import Navbar from "../../../components/Navbar.vue";
  import { PengeluaranBelanjaLogic } from "../../../lib/API/Pengeluaran/PengeluaranBelanja";
  
  export default {
    name: "PengeluaranBelanja",
    components: {
      Navbar,
    },
    data() {
      return {
        expenses: [],
        newExpense: {
          id: null,
          name: "",
          quantity: 0,
          price: 0,
          date: "",
        },
        isAddingExpense: false, // Flag to toggle form visibility
        isEditing: false, // Flag to check if we're editing
      };
    },
    methods: {
      showAddExpenseForm() {
        this.isAddingExpense = true;
        this.isEditing = false;
        this.resetNewExpense();
      },
      cancelAddExpense() {
        this.isAddingExpense = false;
        this.isEditing = false;
        this.resetNewExpense();
      },
      addExpense() {
        PengeluaranBelanjaLogic.addExpense(this);
      },
      resetNewExpense() {
        this.newExpense = { id: null, name: "", quantity: 0, price: 0, date: "" };
      },
      editExpense(id) {
        const expense = this.expenses.find(exp => exp.id === id);
        if (expense) {
          this.newExpense = { ...expense };
          this.isAddingExpense = true;
          this.isEditing = true;
        }
      },
      updateExpense() {
        PengeluaranBelanjaLogic.editExpense(this.newExpense.id, this);
      },
      deleteExpense(id) {
        PengeluaranBelanjaLogic.deleteExpense(this, id);
      },
    },
    filters: {
      currency(value) {
        return PengeluaranBelanjaLogic.currency(value);
      },
    },
    created() {
      PengeluaranBelanjaLogic.setupData(this);
    },
  };
  </script>
  
  
  <style scoped>
  /* Wrapper for layout: navbar and content side by side */
  .wrapper {
    display: flex;
    min-height: 100vh;
  }
  
  /* Main content styling */
  .content {
    padding-left: 20px;
    padding-right: 20px;
  }
  
  /* Make sure the table takes full width */
  table {
    width: 100%;
  }
  
  /* Adjust button width to make it not too long */
  button {
    width: auto; /* Let the button take only the required space */
    padding-left: 20px;
    padding-right: 20px;
    margin-right: 10px; /* Add space between buttons */
  }
  
  /* Adjust styling for form buttons */
  .btn-secondary {
    margin-left: 10px;
  }
  
  /* Adjust modal styling */
  .modal-content {
    max-width: 500px;
    margin: 0 auto;
  }
  </style>
  