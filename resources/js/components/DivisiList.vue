<template>
    <div class="container">
        <h2>Daftar Divisi</h2>
        <div class="row">
            <!-- Table untuk menampilkan data -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="divisi in divisiList" :key="divisi.id">
                        <td>{{ divisi.name }}</td>
                        <td>{{ divisi.deskripsi }}</td>
                        <td>
                            <button @click="editDivisi(divisi)" class="btn btn-primary">Edit</button>
                            <button @click="deleteDivisi(divisi.id)" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            divisiList: [],
        }
    },
    mounted() {
        this.getDivisi();
    },
    methods: {
        getDivisi() {
            axios.get('/api/divisi')
                .then(response => {
                    this.divisiList = response.data.data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        deleteDivisi(id) {
            if(confirm('Apakah Anda yakin ingin menghapus divisi ini?')) {
                axios.delete(`/api/divisi/${id}`)
                    .then(response => {
                        this.getDivisi(); // Refresh data
                        alert('Divisi berhasil dihapus');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menghapus divisi');
                    });
            }
        },
        editDivisi(divisi) {
            // Implementasi edit
        }
    }
}
</script>