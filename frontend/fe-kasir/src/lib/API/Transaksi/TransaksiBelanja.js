import axios from "axios";

const apiBaseUrl = "http://localhost:8000"; // Replace this with your Laravel API URL

export class TransaksiBelanja {
  // Static method to set up initial data or logic
  static async setupData(component) {
    try {
      const response = await axios.get(`${apiBaseUrl}/api/admin/pengeluaran-belanja`);
      component.transactions = response.data; // Set the fetched transactions to the component's data
      component.filteredTransactions = component.transactions; // Initialize filteredTransactions after data is set
    } catch (error) {
      console.error("Error fetching transactions:", error);
    }
  }

  // Method to add a transaction
  static addTransaction(component, newTransaction) {
    const transaction = {
      ...newTransaction,
      id: component.transactions.length + 1, // Simple logic for generating the next ID
    };
    component.transactions.push(transaction);
  }

  // Method to delete a transaction
  static deleteTransaction(component, id) {
    component.transactions = component.transactions.filter(
      (transaction) => transaction.id !== id
    );
  }

  // Method to edit a transaction (optional for now)
  static editTransaction(component, id, updatedTransaction) {
    const index = component.transactions.findIndex((transaction) => transaction.id === id);
    if (index !== -1) {
      component.transactions[index] = { ...component.transactions[index], ...updatedTransaction };
    }
  }

  // Method to format currency (IDR) for display
  static currencyFormatter(value) {
    return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(value);
  }
}
