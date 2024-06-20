<template>
    <div>
        <h2>Register</h2>
        <form @submit.prevent="register">
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
            email: '',
            password: '',
            message: '',
        };
    },
    methods: {
        async register() {
            try {
                // Check if the email already exists
                const emailCheckResponse = await fetch(`http://localhost:3000/users?email=${this.email}`);
                const users = await emailCheckResponse.json();

                if (users.length > 0) {
                    // Email already exists, prompt user to log in
                    this.message = 'Email already exists. Please log in.';
                    console.log('Email already exists');
                    return;
                }

                // Email does not exist, proceed with registration
                const newUser = {
                    email: this.email,
                    password: this.password, // You might want to hash the password before sending
                    role: 'user',
                };

                const registerResponse = await fetch('http://localhost:3000/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(newUser),
                });


                if (!registerResponse.ok) {
                    throw new Error('Failed to register user');
                }
                this.message = 'User registered successfully!';
                const data = await registerResponse.json();
                console.log('User registered:', data);

                // Optionally, reset form fields or redirect user
                this.email = '';
                this.password = '';
                setTimeout(() => {
                    this.message = ''
                }, 3000);
            } catch (error) {
                console.error('Error:', error);
                this.message = 'An error occurred. Please try again.';
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
</style>