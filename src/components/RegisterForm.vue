<template>
    <div>
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="name" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="password" required>
            </div>
            <div>
                <button type="submit">Register</button>
            </div>
            <div v-if="message" class="message">{{ message }}</div>
        </form>
    </div>
</template>

<script>
export default {
    name: "Register",
    data() {
        return {
            name: '',
            email: '',
            password: '',
            message: '',
        };
    },
    methods: {
        async register() {
            try {
                // Task 2 json-server
                // const emailCheckResponse = await fetch(`http://localhost:3000/users?email=${this.email}`);
                // const users = await emailCheckResponse.json();

                // if (users.length > 0) {
                //     // Email already exists, prompt user to log in
                //     this.message = 'Email already exists. Please log in.';
                //     console.log('Email already exists');
                //     return;
                // }

                // Task 3 php(non-RESTful)
                // Check if the email already exists
                // const emailCheckResponse = await fetch(`http://localhost/php-backend/index.php?action=getUserByEmail&type=user&email=${this.email}`);

                // Task 4 php(RESTful)
                const emailCheckResponse = await fetch(`http://localhost/php-RESTful/api/users?email=${this.email}`);
                const user = await emailCheckResponse.json();
                if (user && user.email) {
                    // Email already exists, prompt user to log in
                    this.message = 'Email already exists. Please log in.';
                    console.log('Email already exists');
                    return;
                }

                // Email does not exist, proceed with registration
                const newUser = {
                    name: this.name,
                    email: this.email,
                    password: this.password, // You might want to hash the password before sending
                };
                // Task 3 php(non-RESTful)
                // const registerResponse = await fetch('http://localhost/php-backend/index.php?action=createUser&type=user', {

                // Task 4 php(RESTful)

                const registerResponse = await fetch('http://localhost/php-RESTful/api/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(newUser),
                });

                const data = await registerResponse.json();

                if (registerResponse.status === 409) {
                    this.message = data.error || 'Email already exists. Please log in.';
                    return;
                }

                if (!registerResponse.ok) {
                    throw new Error(data.error || 'Failed to register user');
                }

                this.message = 'User registered successfully!';
                console.log('User registered:', data);

                // Optionally, reset form fields or redirect user
                this.name = '';
                this.email = '';
                this.password = '';
                setTimeout(() => {
                    this.message = ''
                }, 3000);
            } catch (error) {
                console.error('Error:', error);
                this.message = error.message || 'An error occurred. Please try again.';
            }
        },
    },
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

.message {
    color: rgb(0, 0, 0);
    margin-top: 1rem;
}
</style>
