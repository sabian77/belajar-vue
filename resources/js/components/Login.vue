<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @submit.prevent="handleLogin">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" v-model="form.email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" v-model="form.password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        async handleLogin() {
            try {
                const response = await axios.post('/api/login', this.form);
                if (response.data.success) {
                    // Simpan token ke localStorage
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    
                    // Set default header untuk axios
                    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
                    
                    // Redirect ke home
                    this.$router.push('/');
                }
            } catch (error) {
                alert(error.response?.data?.message || 'Login gagal');
            }
        }
    }
}
</script>