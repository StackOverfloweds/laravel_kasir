import axios from "axios";

export default class LogoutUser  {

    
    static apiUrl = "http://localhost:8000"; // Your backend URL here
    // Register a new employee
    static async Logout() {
        try {
            const response = await axios.delete(
                `${this.apiUrl}/api/auth/logout`,
                {
                    headers: {
                        Authorization: `Bearer ${sessionStorage.getItem('authToken')}` // Get token from sessionStorage
                    }
                });

                  // If logout is successful, clear the session storage
                  sessionStorage.removeItem('authToken'); // Remove the token from sessionStorage
                  sessionStorage.removeItem('user'); // Remove the token from sessionStorage

                // Redirect the user to the login page
                return response.data; // Return the user and token
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    throw error.response.data.errors; // Throw validation errors if any
                } else {
                    throw "An error occurred while logout";
        }
    }
}
}