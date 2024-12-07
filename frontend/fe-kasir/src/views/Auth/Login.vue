<template>
  <div class="login-container">
      <div class="login-box">
          <h2>Login POSMate</h2>
          <form @submit.prevent="handleLogin">
              <div class="input-container">
                  <label for="username">Username</label>
                  <input
                      type="text"
                      id="username"
                      v-model="username"
                      required
                  />
              </div>

              <div class="input-container">
                  <label for="password">Password</label>
                  <input
                      type="password"
                      id="password"
                      v-model="password"
                      required
                  />
              </div>

              <button type="submit" class="login-btn">Login</button>
          </form>
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
      };
  },
  methods: {
      async handleLogin() {
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
                  alert(`Login Success`);
                  // Optionally, redirect to another page
                  this.$router.push("/dashboard");
              } else {
                  alert("Login failed. Please check your credentials.");
              }
          } catch (error) {
              console.error("Login error:", error);

              // Show an error message to the user
              alert(error || "An error occurred during login.");
          }
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
</style>
