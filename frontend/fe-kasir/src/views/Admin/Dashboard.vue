<template>
    <div class="wrapper">
        <!-- Sidebar (Navbar) -->
        <Navbar />

        <!-- Main Content (Dashboard) -->
        <div class="dashboard-container">
            <h1 class="dashboard-title">Dashboard</h1>
            <div class="dashboard-grid">
                <!-- Card 1: Total Pengeluaran Belanja -->
                <div class="card purple">
                    <h5>Total Pengeluaran Belanja</h5>
                    <p>{{ totalPengeluaranFormatted }}</p>
                </div>

                <!-- Card 2: Total Makanan -->
                <div class="card green">
                    <h5>Total Makanan</h5>
                    <p>{{ totalMakananFormatted }}</p>
                    <!-- Display total Makanan here -->
                </div>

                <!-- Card 3: Calendar -->
                <div class="card blue">
                    <h5>Calendar</h5>
                    <p>{{ currentDate }}</p>
                </div>

                <!-- Card 4: Total Pendapatan Toko -->
                <div class="card red">
                    <h5>Total Pendapatan Toko</h5>
                    <p>{{ totalPendapatanFormatted }}</p>
                    <!-- Display total revenue here -->
                </div>

                <!-- Card 5: Total Minuman -->
                <div class="card green">
                    <h5>Total Minuman</h5>
                    <p>{{ totalMinumanFormatted }}</p>
                    <!-- Display total Minuman here -->
                </div>

                <!-- Card 6: Staff Pegawai -->
                <div class="card blue">
                    <h5>Staff Pegawai</h5>
                    <div v-if="errorMessage">
                        <p class="error-message">{{ errorMessage }}</p>
                    </div>
                    <div v-else>
                        <div v-if="kasirUsers.length > 0">
                            <p v-for="user in kasirUsers" :key="user.id">
                                {{ user.name }}
                            </p>
                        </div>
                        <div v-else>
                            <p>No kasir found.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Navbar from "../../components/Navbar.vue"; // Import the Navbar component

export default {
    name: "Dashboard",
    components: {
        Navbar, // Register the Navbar component
    },
    data() {
        return {
            transactions: [], // Store all transactions for expenses
            totalPengeluaran: 0, // Store the total of the transactions
            totalPengeluaranFormatted: "", // Formatted total of transactions
            totalPendapatan: 0, // Store total revenue
            totalPendapatanFormatted: "", // Formatted total revenue
            totalMakanan: 0, // Store total food sales
            totalMakananFormatted: "", // Formatted total food sales
            totalMinuman: 0, // Store total drink sales
            totalMinumanFormatted: "", // Formatted total drink sales
            currentDate: "", // Store today's date in a formatted string
            kasirUsers: [], // Store filtered users with the "kasir" role
            menus: [], // Store menu items
            errorMessage: "", // Store error messages
            apiBaseUrl: "http://localhost:8000", // Replace with your actual API URL
        };
    },
    methods: {
        // Fetch the transactions for pengeluaran-belanja (expenses) and calculate total expenses
        async setupData() {
            try {
                // Fetch the transactions for expenses
                const expenseResponse = await axios.get(
                    `${this.apiBaseUrl}/api/admin/pengeluaran-belanja`
                );
                this.transactions = expenseResponse.data; // Store the fetched data

                // Calculate the total Pengeluaran Belanja (Expenses)
                this.totalPengeluaran = this.transactions.reduce(
                    (total, transaction) => {
                        return total + (transaction.price || 0); // Add each transaction's price
                    },
                    0
                );

                // Format the totalPengeluaran as Rupiah (e.g., Rp 5,000)
                this.totalPengeluaranFormatted = new Intl.NumberFormat(
                    "id-ID",
                    {
                        style: "currency",
                        currency: "IDR",
                    }
                ).format(this.totalPengeluaran);

                // Get today's date and format it
                const today = new Date();
                this.currentDate = new Intl.DateTimeFormat("id-ID", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                }).format(today);

                // Fetch sales transactions for pendapatan (revenue)
                await this.fetchTransactions(); // Fetch and calculate total revenue
                await this.fetchMenus(); // Fetch menus to calculate Makanan and Minuman
                await this.getUsers(); // Fetch users with the kasir role
            } catch (error) {
                this.errorMessage =
                    "Error fetching dashboard data. Please try again."; // Display the error message in the UI
                console.error("Error fetching data:", error);
            }
        },

        // Fetch the sales transactions and calculate total revenue
        async fetchTransactions() {
            try {
                const response = await axios.get(
                    `${this.apiBaseUrl}/api/admin/sales-transactions`
                );
                const salesTransactions = response.data;

                // Calculate total revenue (total_amount of each transaction)
                this.totalPendapatan = salesTransactions.reduce(
                    (total, transaction) => {
                        const amount = parseFloat(transaction.total_amount); // Parse the total_amount as a number
                        return total + (isNaN(amount) ? 0 : amount); // Add to total, fallback to 0 if NaN
                    },
                    0
                );

                // Format the totalPendapatan as Rupiah (e.g., Rp 5,000)
                this.totalPendapatanFormatted = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                }).format(this.totalPendapatan);
            } catch (error) {
                console.error("Error fetching transactions:", error);
                this.errorMessage = "Failed to fetch transaction data.";
            }
        },

        // Fetch menus and calculate total Makanan and Minuman count
        async fetchMenus() {
            try {
                const response = await axios.get(
                    `${this.apiBaseUrl}/api/admin/menus`
                );
                this.menus = response.data; // Store the fetched menu items

                // Count the number of 'Makanan' items
                this.totalMakanan = this.menus.filter(
                    (menu) => menu.category.toLowerCase().includes("makanan") // Case-insensitive check for 'makanan'
                ).length; // Get the count of items in the 'Makanan' category

                // Count the number of 'Minuman' items
                this.totalMinuman = this.menus.filter(
                    (menu) => menu.category.toLowerCase().includes("minuman") // Case-insensitive check for 'minuman'
                ).length; // Get the count of items in the 'Minuman' category

                // Store the total counts as formatted strings (optional, for display purposes)
                this.totalMakananFormatted = this.totalMakanan.toString(); // Display the total Makanan count
                this.totalMinumanFormatted = this.totalMinuman.toString(); // Display the total Minuman count
            } catch (error) {
                console.error("Error fetching menus:", error);
            }
        },

        // Get all users (employees) with role 'kasir'
        async getUsers() {
            try {
                const response = await axios.get(
                    `${this.apiBaseUrl}/api/admin/users`
                );

                // Filter users by the 'kasir' role
                this.kasirUsers = response.data.filter(
                    (user) => user.role === "kasir"
                );
            } catch (error) {
                this.errorMessage =
                    "Error fetching staff data. Please try again."; // Display the error message in the UI
                console.error("Error fetching users:", error);
            }
        },
    },
    created() {
        this.setupData(); // Fetch data when the component is created
    },
};
</script>

<style scoped>
/* Wrapper for the entire layout */
.wrapper {
    display: flex;
    height: 100vh;
}

/* Main Dashboard Styling */
.dashboard-container {
    flex-grow: 1;
    padding: 20px;
    background-color: #f0f0f0;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card h5 {
    margin-bottom: 10px;
    font-size: 1.25rem;
    font-weight: bold;
}

.purple {
    background-color: #9c4de1;
    color: #fff;
}

.green {
    background-color: #7ecf7e;
    color: #fff;
}

.red {
    background-color: #ff6f61;
    color: #fff;
}

.blue {
    background-color: #5b9bd5;
    color: #fff;
}

.error-message {
    color: red;
    font-size: 1rem;
    font-weight: bold;
}
</style>
