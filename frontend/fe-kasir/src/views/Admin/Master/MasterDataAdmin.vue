<template>
    <div class="wrapper d-flex">
      <!-- Sidebar (Navbar) -->
      <Navbar />
  
      <!-- Main Content Area -->
      <div class="content flex-grow-1 mt-5">
        <div class="container">
          <h2>Data Pegawai</h2>
          <button
            v-if="!isAddingEmployee && !isEditingEmployee"
            class="btn btn-primary mb-3"
            @click="showAddEmployeeForm"
          >
            Tambah Pegawai
          </button>
  
          <!-- Form Tambah Pegawai -->
          <div v-if="isAddingEmployee" class="mb-4">
            <h3>Tambah Pegawai</h3>
            <form @submit.prevent="addEmployee">
              <div class="mb-3">
                <label for="employeeName" class="form-label">Nama Lengkap</label>
                <input
                  type="text"
                  class="form-control"
                  id="employeeName"
                  v-model="newEmployee.name"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="employeeEmail" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="employeeEmail"
                  v-model="newEmployee.email"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="employeePassword" class="form-label">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="employeePassword"
                  v-model="newEmployee.password"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="employeeRole" class="form-label">Role</label>
                <select
                  class="form-select"
                  id="employeeRole"
                  v-model="newEmployee.role"
                  required
                >
                  <option value="" disabled selected>Pilih Role</option>
                  <option value="admin">Admin</option>
                  <option value="kasir">Kasir</option>
                </select>
              </div>
              <button type="submit" class="btn btn-success">Tambah Pegawai</button>
              <button
                type="button"
                class="btn btn-secondary ms-2"
                @click="cancelAddEmployee"
              >
                Batal
              </button>
            </form>
          </div>
  
          <!-- Form Edit Pegawai -->
          <div v-if="isEditingEmployee" class="mb-4">
            <h3>Edit Pegawai</h3>
            <form @submit.prevent="updateEmployee">
              <div class="mb-3">
                <label for="editEmployeeName" class="form-label">Nama Lengkap</label>
                <input
                  type="text"
                  class="form-control"
                  id="editEmployeeName"
                  v-model="currentEmployee.name"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="editEmployeeEmail" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="editEmployeeEmail"
                  v-model="currentEmployee.email"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="employeePassword" class="form-label">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="employeePassword"
                  v-model="currentEmployee.password"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="editEmployeeRole" class="form-label">Role</label>
                <select
                  class="form-select"
                  id="editEmployeeRole"
                  v-model="currentEmployee.role"
                  required
                >
                  <option value="" disabled selected>Pilih Role</option>
                  <option value="admin">Admin</option>
                  <option value="kasir">Kasir</option>
                </select>
              </div>
              <button type="submit" class="btn btn-success">Simpan Perubahan</button>
              <button
                type="button"
                class="btn btn-secondary ms-2"
                @click="cancelEditEmployee"
              >
                Batal
              </button>
            </form>
          </div>
  
          <!-- Table of Employees -->
          <div v-if="!isAddingEmployee && !isEditingEmployee">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Lengkap</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employees" :key="employee.id">
                  <td>{{ employee.id }}</td>
                  <td>{{ employee.name }}</td>
                  <td>{{ employee.email }}</td>
                  <td>{{ employee.role }}</td>
                  <td>
                    <button
                      class="btn btn-warning"
                      @click="startEditEmployee(employee)"
                    >
                      Edit
                    </button>
                    <button
                      class="btn btn-danger"
                      @click="deleteEmployee(employee.id)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
  
      <!-- Error Popup -->
      <div v-if="isErrorPopupVisible" class="popup-overlay">
        <div class="popup-content">
          <h3>{{ errorMessage }}</h3>
          <button @click="closeErrorPopup" class="popup-btn">Close</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import MasterDataAdmin from "../../../lib/API/Master/MasterDataAdmin"; // Update the path if needed
  import Navbar from "../../../components/Navbar.vue";
  
  export default {
    name: "MasterDataAdmin",
    components: {
      Navbar,
    },
    data() {
      return {
        newEmployee: {
          name: "",
          email: "",
          password: "",
          role: "",
        },
        currentEmployee: null, // Pegawai yang sedang diedit
        isAddingEmployee: false,
        isEditingEmployee: false, // Status form edit
        employees: [], // Daftar pegawai
        errors: null, // Error validasi
        isErrorPopupVisible: false, // Status visibilitas popup error
        errorMessage: "", // Pesan error
      };
    },
    mounted() {
      this.fetchUsers(); // Fetch initial data
      this.refreshInterval = setInterval(() => {
        this.fetchUsers(); // Auto-refresh data periodically
      }, 5000); // Refresh every 5 seconds (atur sesuai kebutuhan)
    },
  
    methods: {
      showAddEmployeeForm() {
        this.isAddingEmployee = true;
      },
      cancelAddEmployee() {
        this.isAddingEmployee = false;
        this.resetNewEmployee();
      },
      async addEmployee() {
        try {
          const employeeData = await MasterDataAdmin.registerEmployee(this.newEmployee);
          this.employees.push(employeeData.user);
          this.resetNewEmployee();
          this.isAddingEmployee = false;
        } catch (error) {
          console.error(error);
          this.showErrorPopup("Error adding employee. Please try again.");
        }
      },
      resetNewEmployee() {
        this.newEmployee = {
          name: "",
          email: "",
          password: "",
          role: "",
        };
      },
      startEditEmployee(employee) {
        this.isEditingEmployee = true;
        this.currentEmployee = { ...employee }; // Clone data pegawai
      },
      cancelEditEmployee() {
        this.isEditingEmployee = false;
        this.currentEmployee = null;
      },
      async updateEmployee() {
        try {
          const updatedEmployee = await MasterDataAdmin.updateUser(
            this.currentEmployee.id, // Kirim hanya ID sebagai parameter pertama
            {
              name: this.currentEmployee.name,
              email: this.currentEmployee.email,
              password: this.currentEmployee.password,
              role: this.currentEmployee.role,
            } // Kirim data yang ingin diperbarui
          );
  
          // Cari indeks employee berdasarkan ID yang diperbarui
          const index = this.employees.findIndex((emp) => emp.id === updatedEmployee.id);
          if (index !== -1) {
            this.$set(this.employees, index, updatedEmployee); // Perbarui data di daftar employees
          }
  
          // Reset form dan state
          this.isEditingEmployee = false;
          this.currentEmployee = null;
        } catch (error) {
          console.error("Error updating employee:", error);
          this.showErrorPopup("Error updating employee. Please try again.");
        }
      },
  
      async deleteEmployee(id) {
        try {
          await MasterDataAdmin.deleteUser(id); // Hapus pengguna di backend
          this.employees = this.employees.filter((emp) => emp.id !== id); // Perbarui daftar pengguna di frontend
  
          console.log(`User with ID ${id} deleted successfully.`);
        } catch (error) {
          console.error("Error deleting user:", error);
          this.showErrorPopup("Error deleting employee. Please try again.");
        }
      },
  
      async fetchUsers() {
        try {
          this.employees = await MasterDataAdmin.getUsers();
        } catch (error) {
          console.error(error);
          this.showErrorPopup("Error fetching employees. Please try again.");
        }
      },
  
      showErrorPopup(message) {
        this.errorMessage = message;
        this.isErrorPopupVisible = true;
      },
  
      closeErrorPopup() {
        this.isErrorPopupVisible = false;
      },
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
  
  /* Table styling */
  table {
    width: 100%;
  }
  
  button {
    width: auto; /* Let the button take only the required space */
    padding-left: 20px;
    padding-right: 20px;
    margin-right: 10px; /* Add space between buttons */
  }
  
  .btn-secondary {
    margin-left: 10px;
  }
  
  /* Popup styling */
  .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .popup-content {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  .popup-btn {
    padding: 10px 20px;
    background-color: #00796b;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .popup-btn:hover {
    background-color: #004d40;
  }
  </style>
  