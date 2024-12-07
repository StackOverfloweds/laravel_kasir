export class TransaksiBelanja {
    // Static method to set up initial data or logic
    static setupData(component) {
      // Here you would typically fetch data from an API or set it up from local storage
      // In this example, I'm directly setting some initial data as an example.
      component.transactions = [
        { id: 1, name: "Gula Pasir", quantity: 10, price: 5000, date: "2024-12-01" },
        { id: 2, name: "Minyak Goreng", quantity: 5, price: 15000, date: "2024-12-02" },
      ];
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
  