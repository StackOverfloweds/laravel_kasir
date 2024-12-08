<template>
  <div class="login-container">
    <div class="login-box">
      <h2>Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="input-container">
          <label for="username">Username</label>
          <input type="text" id="username" v-model="username" required />
        </div>

        <div class="input-container">
          <label for="password">Password</label>
          <input type="password" id="password" v-model="password" required />
        </div>

        <button type="submit" class="login-btn">Login</button>
      </form>
    </div>
  </div>

  <!-- Loading Spinner -->
  <div v-if="isLoading" class="loading-overlay">
    <div class="loading-spinner"></div>
  </div>

  <!-- Popup for success or failure -->
  <div v-if="isPopupVisible" class="popup-overlay">
    <div class="popup-content">
      <h3>{{ popupMessage }}</h3>
      <button @click="closePopup" class="popup-btn">Close</button>
    </div>
  </div>
</template>

<script>
import LoginAuth from "../../lib/API/Auth/LoginAuth";

export default {
  data() {
    return {
      username: "",
      password: "",
      isPopupVisible: false, // Track whether the popup is visible
      popupMessage: "", // Message for the popup
      isLoading: false, // Track the loading state
    };
  },
  methods: {
    async handleLogin() {
      this.isLoading = true; // Show the loading spinner

      try {
        // Call the login API with the user's credentials
        const loginData = {
          name: this.username,
          password: this.password,
        };

        const response = await LoginAuth.Login(loginData);

        // Assuming the response contains a token and user details
        if (response.token) {
          console.log("Login successful:", response);
          sessionStorage.setItem("authToken", response.token);
          sessionStorage.setItem("user", JSON.stringify(response.user));

          // Show success message
          this.popupMessage = "Login successful!";
          this.isPopupVisible = true;

          // Redirect to the dashboard after 2 seconds
          setTimeout(() => {
            this.$router.push("/dashboard");
          }, 2000);
        } else {
          this.popupMessage = "Login failed. Please check your credentials.";
          this.isPopupVisible = true;
        }
      } catch (error) {
        console.error("Login error:", error);

        // Show error message
        this.popupMessage = error || "An error occurred during login.";
        this.isPopupVisible = true;
      } finally {
        this.isLoading = false; // Hide the loading spinner once the process is done
      }
    },

    closePopup() {
      this.isPopupVisible = false; // Close the popup
    },
  },
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #e0f7fa;
}

.login-box {
  padding: 20px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  width: 300px;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

.input-container {
  margin-bottom: 15px;
}

.input-container label {
  font-size: 14px;
  margin-bottom: 5px;
  display: block;
}

.input-container input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.login-btn {
  width: 100%;
  padding: 10px;
  background-color: #00796b;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.login-btn:hover {
  background-color: #004d40;
}

/* Loading Spinner Styles */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.loading-spinner {
  border: 4px solid rgba(0, 0, 0, 0.1);
  border-top: 4px solid #00796b;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Popup styles */
.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.popup-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.popup-btn {
  padding: 10px 20px;
  background-color: #00796b;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.popup-btn:hover {
  background-color: #004d40;
}
</style>
