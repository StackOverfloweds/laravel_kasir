export const PengeluaranBelanjaLogic = {
    // Initialize data or any logic needed
    setupData(vm) {
      console.log("Setting up Pengeluaran Belanja Data");
      // Example: Initialize data or fetch data from API
      // vm.expenses = ... (fetch expenses from API or local storage)
    },
  
    // Toggle showing the add expense form
    showAddExpenseForm(vm) {
      vm.isAddingExpense = true; // Show the form
    },
  
    // Cancel adding an expense and reset the form
    cancelAddExpense(vm) {
      vm.isAddingExpense = false; // Hide the form
      vm.resetNewExpense(); // Reset the form fields
    },
  
    // Add the new expense to the expenses list
    addExpense(vm) {
      const newExpense = {
        ...vm.newExpense,
        id: vm.expenses.length + 1, // Generate a new ID based on the length of the list
      };
      vm.expenses.push(newExpense);
  
      // Reset form fields
      vm.resetNewExpense();
      vm.isAddingExpense = false; // Hide the form after adding the expense
    },
  
    // Reset the new expense form fields
    resetNewExpense(vm) {
      vm.newExpense.name = "";
      vm.newExpense.quantity = 0;
      vm.newExpense.price = 0;
      vm.newExpense.date = "";
    },
  
    // Edit an expense (can be customized with a real form or logic)
    editExpense(id) {
      alert(`Edit expense with ID: ${id}`);
    },
  
    // Delete an expense by ID
    deleteExpense(vm, id) {
      vm.expenses = vm.expenses.filter((expense) => expense.id !== id);
    },
  
    // Currency filter for formatting values
    currency(value) {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    },
  };
  