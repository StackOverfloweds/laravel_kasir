<template>
    <div class="transaction-container">
        <h1 class="transaction-title">Struk Pesanan</h1>

        <!-- Tabel Pesanan -->
        <table class="order-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in selectedItems" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>Rp {{ item.price }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>Rp {{ item.price * item.quantity }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total Keseluruhan</td>
                    <td>Rp {{ totalPrice }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Dropdown untuk Payment Method -->
        <div class="payment-method">
            <label for="payment-method">Metode Pembayaran</label>
            <select v-model="paymentMethod" id="payment-method">
                <option disabled value="">Pilih Metode Pembayaran</option>
                <option value="QRIS">QRIS</option>
                <option value="Cash">Cash</option>
                <option value="Bank">Bank</option>
            </select>
        </div>

        <!-- Button Proses Pesanan -->
        <div class="process-button">
            <button class="btn-proses" @click="processOrder">
                Proses Pesanan
            </button>
        </div>

        <!-- Popup Modal -->
        <div v-if="popupVisible" class="popup-overlay">
            <div class="popup">
                <h2>{{ popupMessage }}</h2>
                <button class="popup-close" @click="closePopup">Tutup</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "TransaksiPesanan",
    data() {
        return {
            selectedItems: [],
            totalPrice: 0,
            paymentMethod: "", // State untuk metode pembayaran
            popupVisible: false,
            popupMessage: "",
            apiUrl: "http://localhost:8000", // Ganti dengan URL API backend Anda
        };
    },
    methods: {
        async processOrder() {
            if (!this.paymentMethod) {
                this.popupMessage = "Silakan pilih metode pembayaran!";
                this.popupVisible = true;
                return;
            }

            // Retrieve user data from sessionStorage and parse it
            const user = JSON.parse(sessionStorage.getItem("user")); // Assuming user is stored as an object
            const user_id = user ? user.id : null; // Extract user_id

            if (!user_id) {
                this.popupMessage = "User tidak ditemukan. Silakan login.";
                this.popupVisible = true;
                return;
            }

            try {
                const payload = {
                    user_id: user_id,
                    menu_id: this.selectedItems.map((item) => item.id), // Mengambil id menu
                    quantity: this.selectedItems.map((item) => item.quantity), // Mengambil quantity yang sudah dipastikan angka
                    total_amount: this.totalPrice,
                    payment_method: this.paymentMethod,
                    transaction_date: new Date().toISOString().split("T")[0], // Format tanggal
                };

                // Mengirim data ke backend
                await axios.post(
                    `${this.apiUrl}/api/admin/sales-transactions`,
                    payload
                );

                this.popupMessage = "Pesanan berhasil diproses!";
                this.popupVisible = true;

                // Clear selected items after successful transaction
                localStorage.removeItem("selectedItems");
            } catch (error) {
                this.popupMessage =
                    "Terjadi kesalahan saat menyimpan transaksi. Silakan coba lagi.";
                this.popupVisible = true;
            }
        },

        closePopup() {
            this.popupVisible = false;
            if (this.popupMessage === "Pesanan berhasil diproses!") {
                this.$router.push("/Kasir/Dashboard");
            }
        },
        calculateTotalPrice() {
            this.totalPrice = this.selectedItems.reduce(
                (sum, item) => sum + item.price * item.quantity,
                0
            );
        },
    },
    created() {
        const items = localStorage.getItem("selectedItems");
        this.selectedItems = items ? JSON.parse(items) : [];

        // Memastikan quantity yang ada adalah angka
        this.selectedItems.forEach((item) => {
            item.quantity = Number(item.quantity); // Mengonversi quantity ke angka
        });

        this.calculateTotalPrice();
    },
};
</script>

<style scoped>
/* Transaction Container Styling */
.transaction-container {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.transaction-title {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
    color: #333;
}

/* Table Styling */
.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.order-table thead {
    background-color: #5b9bd5;
    color: white;
}

.order-table th,
.order-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.order-table tbody tr:hover {
    background-color: #f1f5f8;
}

.order-table tfoot {
    font-weight: bold;
    background-color: #f8f9fa;
}

.order-table tfoot td {
    border-top: 2px solid #5b9bd5;
}

/* Process Button */
.process-button {
    text-align: center;
    margin-top: 20px;
}

.btn-proses {
    background-color: #5b9bd5;
    color: white;
    padding: 10px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-proses:hover {
    background-color: #4a89c7;
    transform: scale(1.05);
}

.btn-proses:active {
    transform: scale(0.95);
}

/* Popup Modal Styling */
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.popup {
    background: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
}

.popup h2 {
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.popup-close {
    background-color: #5b9bd5;
    color: white;
    padding: 10px 15px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.popup-close:hover {
    background-color: #4a89c7;
}
</style>
