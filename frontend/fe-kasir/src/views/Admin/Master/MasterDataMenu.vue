<template>
  <div class="wrapper d-flex">
      <!-- Sidebar (Navbar) -->
      <Navbar />

      <!-- Main Content Area -->
      <div class="content flex-grow-1 mt-5">
          <div class="container">
              <h2>Data Menu</h2>
              <button class="btn btn-primary mb-3" @click="showAddMenuForm">
                  Tambah Menu
              </button>

              <!-- Conditionally Rendered Form -->
              <div v-if="isAddingMenu" class="mb-4">
                  <h3>{{ newMenu.id ? "Edit Menu" : "Tambah Menu" }}</h3>
                  <form @submit.prevent="saveMenu">
                      <div class="mb-3">
                          <label for="menuName" class="form-label">Nama Menu</label>
                          <input
                              type="text"
                              class="form-control"
                              id="menuName"
                              v-model="newMenu.name"
                              required
                          />
                      </div>
                      <div class="mb-3">
                          <label for="category" class="form-label">Kategori</label>
                          <input
                              type="text"
                              class="form-control"
                              id="category"
                              v-model="newMenu.category"
                              required
                          />
                      </div>
                      <div class="mb-3">
                          <label for="price" class="form-label">Harga</label>
                          <input
                              type="number"
                              class="form-control"
                              id="price"
                              v-model="newMenu.price"
                              required
                          />
                      </div>
                      <div class="mb-3">
                          <label for="description" class="form-label">Deskripsi</label>
                          <textarea
                              class="form-control"
                              id="description"
                              v-model="newMenu.description"
                              required
                          ></textarea>
                      </div>

                      <div class="mb-3">
                          <label for="image" class="form-label">Gambar</label>
                          <input
                              type="file"
                              class="form-control"
                              id="image"
                              @change="handleImageUpload"
                          />
                          <p v-if="newMenu.image">{{ newMenu.image.name }}</p>
                      </div>

                      <button type="submit" class="btn btn-success">
                          {{ newMenu.id ? "Update" : "Tambah" }} Menu
                      </button>
                      <button
                          type="button"
                          class="btn btn-secondary ms-2"
                          @click="cancelAddMenu"
                      >
                          Batal
                      </button>
                  </form>
              </div>

              <!-- Table of Menus -->
              <table class="table table-striped" v-if="!isAddingMenu">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nama Menu</th>
                          <th>Kategori</th>
                          <th>Harga</th>
                          <th>Deskripsi</th>
                          <th>Gambar</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="menu in menus" :key="menu.id">
                          <td>{{ menu.id }}</td>
                          <td>{{ menu.name }}</td>
                          <td>{{ menu.category }}</td>
                          <td>{{ menu.price }}</td>
                          <td>{{ menu.description }}</td>
                          <td>
                              <img
                                  :src="menu.image_url"
                                  alt="Image"
                                  width="50"
                              />
                          </td>
                          <td>
                              <button
                                  class="btn btn-danger"
                                  @click="deleteMenu(menu.id)"
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
</template>


<script>
// Import the JavaScript logic from the separate file
import MasterDataMenuLogic from "../../../lib/API/Master/MasterDataMenu";
import Navbar from "../../../components/Navbar.vue";

export default {
    name: "MasterDataMenu",
    components: {
        Navbar,
    },
    mixins: [MasterDataMenuLogic], // Mixin the JS logic into this component
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