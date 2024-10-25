<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <input v-model="loginEmail" type="email" placeholder="Email" required />
            <input v-model="loginPassword" type="password" placeholder="Password" required />
            <button type="submit">Login</button>
        </form>

        <h2>Register</h2>
        <form @submit.prevent="register">
            <input v-model="registerName" type="text" placeholder="Name" required />
            <input v-model="registerEmail" type="email" placeholder="Email" required />
            <input v-model="registerPassword" type="password" placeholder="Password" required />
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      loginEmail: '',
      loginPassword: '',
      registerEmail: '',
      registerPassword: '',
      registerName: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/api/user/login', {
          email: this.loginEmail,
          password: this.loginPassword,
        });
        console.log('Login successful:', response.data);
        // Aqui você pode armazenar o token de autenticação, redirecionar o usuário, etc.
      } catch (error) {
        console.error('Error logging in:', error.response.data);
      }
    },
    async register() {
      try {
        const response = await axios.post('/api/user/register', {
          name: this.registerName,
          email: this.registerEmail,
          password: this.registerPassword,
        });
        console.log('Registration successful:', response.data);
        // Aqui você pode redirecionar o usuário ou exibir uma mensagem de sucesso.
      } catch (error) {
        console.error('Error registering:', error.response.data);
      }
    },
  },
};
</script>
