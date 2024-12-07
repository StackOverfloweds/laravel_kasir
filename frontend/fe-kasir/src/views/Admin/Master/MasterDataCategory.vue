<template>
  <div class="wrapper d-flex">
    <!-- Sidebar (Navbar) -->
    <Navbar />

    <!-- Main Content Area -->
    <div class="content flex-grow-1 mt-5">
      <div class="container">
        <h2>Data Kategori</h2>
        <button class="btn btn-primary mb-3" @click="showAddCategoryForm">
          Tambah Kategori
        </button>

        <!-- Conditionally Rendered Form -->
        <div v-if="isAddingCategory" class="mb-4">
          <h3>Tambah Kategori</h3>
          <form @submit.prevent="addCategory">
            <div class="mb-3">
              <label for="categoryName" class="form-label">Nama Kategori</label>
              <input
                type="text"
                class="form-control"
                id="categoryName"
                v-model="newCategory.name"
                required
              />
            </div>
            <button type="submit" class="btn btn-success">Tambah Kategori</button>
            <button type="button" class="btn btn-secondary ms-2" @click="cancelAddCategory">
              Batal
            </button>
          </form>
        </div>

        <!-- Table of Categories -->
        <table class="table table-striped" v-if="!isAddingCategory">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Kategori</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="category in categories" :key="category.id">
              <td>{{ category.id }}</td>
              <td>{{ category.name }}</td>
              <td>
                <button class="btn btn-warning" @click="editCategory(category.id)">
                  Edit
                </button>
                <button class="btn btn-danger" @click="deleteCategory(category.id)">
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
import MasterDataCategoryLogic from '../../../lib/API/Master/MasterDataCategory';
import Navbar from "../../../components/Navbar.vue";

export default {
  name: "MasterDataCategory",
  components: {
    Navbar,
  },
  mixins: [MasterDataCategoryLogic], // Mixin the JS logic into this component
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
