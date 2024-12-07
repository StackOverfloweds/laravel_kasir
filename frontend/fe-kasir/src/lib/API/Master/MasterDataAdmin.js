export default {
    data() {
      return {
        employees: [
          { id: 1, name: "John Doe", username: "johndoe" },
          { id: 2, name: "Jane Smith", username: "janesmith" },
        ],
        newEmployee: {
          name: "",
          username: "",
          password: "",
        },
        isAddingEmployee: false, // Flag to toggle form visibility
      };
    },
    methods: {
      showAddEmployeeForm() {
        this.isAddingEmployee = true; // Show the form
      },
      cancelAddEmployee() {
        this.isAddingEmployee = false; // Hide the form
        this.resetNewEmployee(); // Reset the form data
      },
      addEmployee() {
        const newEmployee = {
          ...this.newEmployee,
          id: this.employees.length + 1,
        };
        this.employees.push(newEmployee);
  
        // Reset form fields
        this.resetNewEmployee();
        this.isAddingEmployee = false; // Hide the form after adding the employee
      },
      resetNewEmployee() {
        this.newEmployee.name = "";
        this.newEmployee.username = "";
        this.newEmployee.password = "";
      },
      editEmployee(id) {
        alert(`Edit employee with ID: ${id}`);
      },
      deleteEmployee(id) {
        this.employees = this.employees.filter((emp) => emp.id !== id);
      },
    },
  };