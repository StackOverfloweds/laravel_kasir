// src/views/Admin/MasterDataMenu.js

export default {
    data() {
      return {
        menus: [
          { id: 1, name: "Menu 1", category: "Category 1", price: 10000, image: "menu1.jpg" },
          { id: 2, name: "Menu 2", category: "Category 2", price: 15000, image: "menu2.jpg" },
        ],
        newMenu: {
          name: "",
          category: "",
          price: "",
          image: null,
        },
        isAddingMenu: false, // Flag to toggle form visibility
      };
    },
    methods: {
      showAddMenuForm() {
        this.isAddingMenu = true; // Show the form
      },
      cancelAddMenu() {
        this.isAddingMenu = false; // Hide the form
        this.resetNewMenu(); // Reset the form data
      },
      addMenu() {
        const newMenu = {
          ...this.newMenu,
          id: this.menus.length + 1,
        };
        this.menus.push(newMenu);
  
        // Reset form fields
        this.resetNewMenu();
        this.isAddingMenu = false; // Hide the form after adding the menu
      },
      resetNewMenu() {
        this.newMenu.name = "";
        this.newMenu.category = "";
        this.newMenu.price = "";
        this.newMenu.image = null;
      },
      editMenu(id) {
        alert(`Edit menu with ID: ${id}`);
      },
      deleteMenu(id) {
        this.menus = this.menus.filter((menu) => menu.id !== id);
      },
      handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
          this.newMenu.image = file.name; // Store image file name (you can modify this logic for actual image upload)
        }
      },
    },
  };
  