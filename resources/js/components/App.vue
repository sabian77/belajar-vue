<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
            <div class="container">
                <a class="navbar-brand" href="#">Employee Management</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/divisi">Divisi</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/job">Job</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/employee">Employee</router-link>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#" @click.prevent="handleLogout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    methods: {
        async handleLogout() {
            try {
                const response = await axios.post('/api/logout');
                if (response.data.success) {
                    // Hapus token dan user dari localStorage
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    
                    // Hapus default header axios
                    delete axios.defaults.headers.common['Authorization'];
                    
                    // Redirect ke login
                    this.$router.push('/login');
                }
            } catch (error) {
                console.error('Logout error:', error);
            }
        }
    }
}
</script>