<template>
  <div class="wrapper d-flex">
    <!-- Sidebar (Navbar) -->
    <Navbar />

    <!-- Main Content Area -->
    <div class="content flex-grow-1 mt-5">
      <div class="container">
        <h2>Data Pegawai</h2>
        <button class="btn btn-primary mb-3" @click="showAddEmployeeForm">
          Tambah Pegawai
        </button>

        <!-- Conditionally Rendered Form -->
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
              <label for="employeeUsername" class="form-label">Username</label>
              <input
                type="text"
                class="form-control"
                id="employeeUsername"
                v-model="newEmployee.username"
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
            <button type="submit" class="btn btn-success">Tambah Pegawai</button>
            <button type="button" class="btn btn-secondary ms-2" @click="cancelAddEmployee">
              Batal
            </button>
          </form>
        </div>

        <!-- Table of Employees -->
        <table class="table table-striped" v-if="!isAddingEmployee">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Lengkap</th>
              <th>Username</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="employee in employees" :key="employee.id">
              <td>{{ employee.id }}</td>
              <td>{{ employee.name }}</td>
              <td>{{ employee.username }}</td>
              <td>
                <button class="btn btn-warning" @click="editEmployee(employee.id)">
                  Edit
                </button>
                <button class="btn btn-danger" @click="deleteEmployee(employee.id)">
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
// Import the JavaScript logic from the separate file
import MasterDataAdminLogic from '../../../lib/API/Master/MasterDataAdmin';
import Navbar from "../../../components/Navbar.vue";

export default {
  name: "MasterDataAdmin",
  components: {
    Navbar,
  },
  mixins: [MasterDataAdminLogic], // Mixin the JS logic into this component
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
