<template>
    <div class="wrapper">
        <!-- Sidebar -->
        <Navbar />

        <!-- Main Content -->
        <div class="dashboard-container">
            <h1 class="dashboard-title">Transaksi Pesanan</h1>

            <!-- Category Tabs -->
            <div class="category-tabs">
                <button
                    v-for="category in categories"
                    :key="category"
                    :class="[
                        'category-tab',
                        { active: activeCategory === category },
                    ]"
                    @click="changeCategory(category)"
                >
                    {{ category }}
                </button>
            </div>

            <!-- Food Card Grid -->
            <div class="dashboard-grid">
                <div
                    class="food-card"
                    v-for="item in filteredItems"
                    :key="item.id"
                >
                    <img
                        :src="item.image || 'https://via.placeholder.com/150'"
                        alt="Food Image"
                        class="food-image"
                    />
                    <h3 class="food-name">{{ item.name }}</h3>
                    <p class="food-description">{{ item.description }}</p>
                    <p class="food-price">Rp {{ item.price }}</p>
                    <div class="quantity-control">
                        <button @click="decreaseQuantity(item)">-</button>
                        <span>{{ item.quantity }}</span>
                        <button @click="increaseQuantity(item)">+</button>
                    </div>
                </div>
            </div>

            <!-- Button Transaksi -->
            <div class="transaction-button" v-if="hasSelectedItems">
                <router-link
                    to="/Kasir/Transaksi_Pesanan"
                    class="btn-transaksi"
                    @click="goToTransaction"
                >
                    Transaksi
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Navbar from "../../components/Kasir/Navbar.vue";

export default {
    name: "DashboardKasir",
    components: {
        Navbar,
    },
    data() {
        return {
            categories: [],
            activeCategory: "",
            menuItems: [],
            apiUrl: "http://localhost:8000",
        };
    },
    computed: {
        filteredItems() {
            return this.menuItems.filter(
                (item) => item.category === this.activeCategory
            );
        },
        hasSelectedItems() {
            return this.menuItems.some((item) => item.quantity > 0);
        },
    },
    methods: {
        changeCategory(category) {
            this.activeCategory = category;
        },
        increaseQuantity(item) {
            item.quantity++;
        },
        decreaseQuantity(item) {
            if (item.quantity > 0) {
                item.quantity--;
            }
        },
        async fetchMenus() {
            try {
                const response = await axios.get(
                    `${this.apiUrl}/api/admin/menus`
                );
                this.menuItems = response.data.map((menu) => ({
                    id: menu.id,
                    name: menu.name,
                    price: menu.price,
                    category: menu.category,
                    description: menu.description,
                    image: menu.image_url || "https://via.placeholder.com/150",
                    quantity: 0,
                }));
                this.categories = [
                    ...new Set(this.menuItems.map((menu) => menu.category)),
                ];
                if (this.categories.length > 0) {
                    this.activeCategory = this.categories[0];
                }
            } catch (error) {
                console.error("Error fetching menus:", error);
            }
        },
        goToTransaction() {
            const selectedItems = this.menuItems.filter(
                (item) => item.quantity > 0
            );
            localStorage.setItem(
                "selectedItems",
                JSON.stringify(selectedItems)
            );
        },
    },
    created() {
        this.fetchMenus();
    },
};
</script>

<style scoped>
/* Wrapper for layout */
.wrapper {
    display: flex;
    height: 100vh;
}

/* Main Dashboard Styling */
.dashboard-container {
    flex-grow: 1;
    padding: 20px;
    background-color: #e7f2f2;
}

/* Title Styling */
.dashboard-title {
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

/* Category Tabs */
.category-tabs {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.category-tab {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 20px;
    padding: 10px 20px;
    margin: 0 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.category-tab.active {
    background-color: #5b9bd5;
    color: white;
    font-weight: bold;
}

/* Grid Layout */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    padding: 10px;
}

/* Food Card Styling */
.food-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
    padding: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.food-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
}

.food-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    margin-bottom: 10px;
}

.food-name {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.food-description {
    font-size: 0.9rem;
    color: #888;
    margin-bottom: 10px;
}

.food-price {
    color: #666;
    margin-bottom: 15px;
}

.quantity-control {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.quantity-control button {
    background-color: #5b9bd5;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 1rem;
}

.quantity-control span {
    font-size: 1rem;
    font-weight: bold;
}

/* Transaction Button Styling */
.transaction-button {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.btn-transaksi {
    display: inline-block;
    background-color: #5b9bd5;
    color: white;
    font-size: 1.2rem;
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;
    padding: 15px 30px;
    border: none;
    border-radius: 50px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-transaksi:hover {
    background-color: #4a89c7;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.btn-transaksi:active {
    transform: translateY(0);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
}
</style>
