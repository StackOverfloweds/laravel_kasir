import axios from "axios";
import Navbar from "../../../components/Navbar.vue";

export default {
  name: "MasterDataMenu",
  components: {
    Navbar,
  },
  data() {
    return {
      menus: [],
      newMenu: {
        id: null,
        name: "",
        category: "",
        price: "",
        image: null,
        description: "",
      },
      isAddingMenu: false,
      apiUrl: "http://localhost:8000", // Your API base URL
    };
  },
  mounted() {
    this.fetchMenus(); // Fetch menus when the component is mounted
  },
  methods: {
    // Fetch menus from the backend
    async fetchMenus() {
      try {
        const response = await axios.get(`${this.apiUrl}/api/admin/menus`);
        this.menus = response.data;
      } catch (error) {
        console.error("Error fetching menus:", error);
      }
    },

    // Show the add menu form
    showAddMenuForm() {
      this.isAddingMenu = true;
      this.resetNewMenu();
    },

    // Cancel adding or editing menu
    cancelAddMenu() {
      this.isAddingMenu = false;
      this.resetNewMenu();
    },

    // Reset the newMenu data
    resetNewMenu() {
      this.newMenu = {
        id: null,
        name: "",
        category: "",
        price: "",
        image: null,
        description: "",
      };
    },

    // Save or update a menu
    async saveMenu() {
      const formData = new FormData();
      formData.append("name", this.newMenu.name);
      formData.append("category", this.newMenu.category);
      formData.append("price", this.newMenu.price);
      formData.append("description", this.newMenu.description);
      if (this.newMenu.image) {
        formData.append("image", this.newMenu.image);
      }
    
      try {
        // Add new menu (always use POST)
        const response = await axios.post(`${this.apiUrl}/api/admin/menus`, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        
        // Add the new menu to the list
        this.menus.push(response.data);
    
        // Reset form after submission
        this.resetNewMenu();
        this.isAddingMenu = false;
      } catch (error) {
        console.error("Error saving menu:", error);
      }
    },
    
    // Delete a menu
    async deleteMenu(id) {
      if (confirm("Are you sure you want to delete this menu?")) {
        try {
          await axios.delete(`${this.apiUrl}/api/admin/menus/${id}`);
          this.menus = this.menus.filter(menu => menu.id !== id);
        } catch (error) {
          console.error("Error deleting menu:", error);
        }
      }
    },

    // Handle image upload
    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.newMenu.image = file; // Store the file object for later upload
      }
    },
  },
};
