// src/services/MasterDataAdmin.js
import axios from "axios";

export default class MasterDataAdmin {
    static apiUrl = "http://localhost:8000"; // Your backend URL here

    // Register a new employee
    static async registerEmployee(employeeData) {
        console.log(employeeData);
        try {
            const response = await axios.post(
                `${this.apiUrl}/api/auth/register`,
                {
                    name: employeeData.name,
                    email: employeeData.email,
                    password: employeeData.password,
                    role: employeeData.role,
                }
            );

            return response.data; // Return the user and token
        } catch (error) {
            if (error.response && error.response.data.errors) {
                throw error.response.data.errors; // Throw validation errors if any
            } else {
                throw "An error occurred while registering the employee.";
            }
        }
    }

    // Get all users (employees)
    static async getUsers() {
        try {
            const response = await axios.get(`${this.apiUrl}/api/admin/users`);

            // Check if the data is empty
            if (!response.data || response.data.length === 0) {
                return []; // Return an empty array instead of a message
            }

            return response.data; // Return the list of users if there are any
        } catch (error) {
            // Handle error and display the message
            throw (
                "Error fetching users: " +
                (error.response?.data?.message ||
                    error.message ||
                    "No data available")
            );
        }
    }

    static async updateUser(id, employeeData) {
        try {
            const response = await axios.patch(
                `${this.apiUrl}/api/auth/register/${id}`, // Endpoint dengan ID
                employeeData // Data yang ingin diperbarui
            );
            return response.data; // Data pengguna yang diperbarui
        } catch (error) {
            if (error.response && error.response.data.errors) {
                throw error.response.data.errors; // Tangani error validasi
            } else {
                throw "An error occurred while updating the employee.";
            }
        }
    }

    static async deleteUser(id) {
        try {
            const response = await axios.delete(
                `${this.apiUrl}/api/auth/register/${id}`
            );

            return response.data;
        } catch (error) {
            if (error.response && error.response.data.errors) {
                throw error.response.data.errors; // Tangani error validasi
            } else {
                throw "An error occurred while updating the employee.";
            }
        }
    }
}
