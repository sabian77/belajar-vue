<template>
    <div class="container">
        <h2>Daftar Pekerjaan</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="job in jobs" :key="job.id">
                    <td>{{ job.name }}</td>
                    <td>{{ job.deskripsi }}</td>
                    <td>
                        <button @click="editJob(job)" class="btn btn-primary">Edit</button>
                        <button @click="deleteJob(job.id)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            jobs: []
        }
    },
    mounted() {
        this.getJobs();
    },
    methods: {
        getJobs() {
            axios.get('/api/job')
                .then(response => {
                    this.jobs = response.data.data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        deleteJob(id) {
            if(confirm('Apakah Anda yakin ingin menghapus pekerjaan ini?')) {
                axios.delete(`/api/job/${id}`)
                    .then(response => {
                        this.getJobs();
                        alert('Pekerjaan berhasil dihapus');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menghapus pekerjaan');
                    });
            }
        }
    }
}
</script>