<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
            <div v-if="message" class="message">{{ message }}</div>
        </form>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            email: '',
            password: '',
            message: '',
        };
    },
    methods: {
        async login() {
            try {
                // Task 2 json-server
                // const response = await fetch(`http://localhost:3000/users?email=${this.email}&password=${this.password}`);
                // const users = await response.json();

                // if (users.length > 0) {
                //     const user = users[0];
                //     if (user.password === this.password) {
                //         // Login successful
                //         console.log('Login Successful!');
                //         this.message = 'Login Successful!';
                //         // Optionally, you can redirect the user to another page
                //         setTimeout(() => {
                //             this.$emit('login-success', user.email);
                //             this.$router.push('/');
                //         }, 3000);
                //     } else {
                //         // Password does not match
                //         this.message = 'Invalid email or password. Please try again.';
                //     }
                // } else {
                //     // Email does not exist
                //     this.message = 'Invalid email or password. Please try again.';
                // }

                // Task 3 php(non-RESTful)
                // const response = await fetch('http://localhost/php-backend/index.php?action=loginUser&type=user', {

                // Task 4 php(RESTful)
                const response = await fetch('http://localhost/php-RESTful/api/loginUser', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: this.email,
                        password: this.password
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // Login successful
                    console.log('Login Successful!');
                    this.message = 'Login Successful!';
                    // Optionally, you can redirect the user to another page
                    setTimeout(() => {
                        this.$emit('login-success', data.email);
                        this.$router.push('/');
                    }, 3000);
                } else {
                    // Invalid email or password
                    this.message = data.error || 'Invalid email or password. Please try again.';
                }
            } catch (error) {
                console.error('Error:', error);
                this.message = 'An error occurred. Please try again.';
            }
        },
    }
};
</script>

<style scoped>
h2 {
    margin-bottom: 1rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
}

input {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 1rem;
}

button {
    padding: 0.5rem 1rem;
}
</style>