import axios from "axios";

export default class LoginAuth  {

    
    static apiUrl = "http://localhost:8000"; // Your backend URL here
    // Register a new employee
    static async Login(data) {
        try {
            const response = await axios.post(
                `${this.apiUrl}/api/auth/login`,
                {
                    name: data.name,
                    password: data.password,
                }
                );

                  // Store the token in sessionStorage
            if (response.data && response.data.token) {
                sessionStorage.setItem("authToken", response.data.token);
                sessionStorage.setItem("user", JSON.stringify(response.data.user)); // Optionally store user data
            }
                
                return response.data; // Return the user and token
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    throw error.response.data.errors; // Throw validation errors if any
                } else {
                    throw "An error occurred while login";
        }
    }
}
}