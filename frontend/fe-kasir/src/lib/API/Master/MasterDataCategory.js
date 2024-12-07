export default {
    data() {
      return {
        categories: [
          { id: 1, name: "Category 1" },
          { id: 2, name: "Category 2" },
        ],
        newCategory: {
          name: "",
        },
        isAddingCategory: false, // Flag to toggle form visibility
      };
    },
    methods: {
      showAddCategoryForm() {
        this.isAddingCategory = true; // Show the form
      },
      cancelAddCategory() {
        this.isAddingCategory = false; // Hide the form
        this.resetNewCategory(); // Reset the form data
      },
      addCategory() {
        const newCategory = {
          ...this.newCategory,
          id: this.categories.length + 1,
        };
        this.categories.push(newCategory);
  
        // Reset form fields
        this.resetNewCategory();
        this.isAddingCategory = false; // Hide the form after adding the category
      },
      resetNewCategory() {
        this.newCategory.name = "";
      },
      editCategory(id) {
        alert(`Edit category with ID: ${id}`);
      },
      deleteCategory(id) {
        this.categories = this.categories.filter((cat) => cat.id !== id);
      },
    },
  };