import axios from "axios";

const apiBaseUrl = "http://localhost:8000"; // Replace this with your Laravel API URL

export const PengeluaranBelanjaLogic = {
  // Fetch the expenses from the API
  async setupData(vm) {
    try {
      const response = await axios.get(`${apiBaseUrl}/api/admin/pengeluaran-belanja`);
      vm.expenses = response.data; // Set the fetched expenses to the component's data
    } catch (error) {
      console.error("Error fetching expenses:", error);
    }
  },

  // Toggle showing the add expense form
  showAddExpenseForm(vm) {
    vm.isAddingExpense = true;
    vm.isEditing = false; // Reset editing flag when opening form
    vm.resetNewExpense();
  },

  // Cancel adding an expense and reset the form
  cancelAddExpense(vm) {
    vm.isAddingExpense = false;
    vm.isEditing = false;
    vm.resetNewExpense();
  },

  // Add a new expense by making an API call to the backend
  async addExpense(vm) {
    try {
      const response = await axios.post(`${apiBaseUrl}/api/admin/pengeluaran-belanja`, vm.newExpense);
      vm.expenses.push(response.data); // Add the new expense to the list
      vm.resetNewExpense();
      vm.isAddingExpense = false;
    } catch (error) {
      console.error("Error adding expense:", error);
    }
  },

  // Reset the new expense form fields
  resetNewExpense(vm) {
    vm.newExpense = {
      id: null,
      name: "",
      quantity: 0,
      price: 0,
      date: "",
    };
  },

  // Edit an expense (update logic with PUT request)
  async editExpense(id, vm) {
    try {
      const response = await axios.put(`${apiBaseUrl}/api/admin/pengeluaran-belanja/${id}`, vm.newExpense);
      // Find and update the expense in the local list
      const index = vm.expenses.findIndex(exp => exp.id === id);
      if (index !== -1) {
        vm.expenses[index] = response.data; // Replace the old data with updated one
      }
      vm.resetNewExpense();
      vm.isAddingExpense = false;
      vm.isEditing = false;
    } catch (error) {
      console.error("Error editing expense:", error);
    }
  },

  // Delete an expense by making an API call to delete it from the backend
  async deleteExpense(vm, id) {
    try {
      await axios.delete(`${apiBaseUrl}/api/admin/pengeluaran-belanja/${id}`);
      vm.expenses = vm.expenses.filter((expense) => expense.id !== id); // Remove from local state
    } catch (error) {
      console.error("Error deleting expense:", error);
    }
  },

  // Currency filter for formatting values
  currency(value) {
    return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(value);
  },
};
