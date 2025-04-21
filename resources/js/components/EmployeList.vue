<!-- resources/js/components/EmployeeList.vue -->
<template>
    <div>
        <h2>Daftar Employee</h2>
        <button class="btn btn-primary mb-3" @click="showAddModal = true">Tambah Employee</button>

        <table class="table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Divisi</th>
                    <th>Job</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="employee in employeeList" :key="employee.id">
                    <td>
                        <img :src="'/storage/employee/' + employee.foto" 
                             class="img-thumbnail" 
                             style="width: 50px; height: 50px;"
                             alt="Employee photo">
                    </td>
                    <td>{{ employee.name }}</td>
                    <td>{{ employee.nik }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.phone }}</td>
                    <td>
                        <span :class="{'badge bg-success': employee.status === 'Aktif', 
                                     'badge bg-danger': employee.status === 'Nonaktif'}">
                            {{ employee.status }}
                        </span>
                    </td>
                    <td>{{ employee.division?.name }}</td>
                    <td>{{ employee.job?.name }}</td>
                    <td>
                        <button @click="editEmployee(employee)" class="btn btn-sm btn-primary me-2">Edit</button>
                        <button @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal Tambah/Edit -->
        <div class="modal" v-if="showAddModal || showEditModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ showEditModal ? 'Edit' : 'Tambah' }} Employee</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="showEditModal ? updateEmployee() : saveEmployee()" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" v-model="form.name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIK</label>
                                        <input type="text" class="form-control" v-model="form.nik" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" v-model="form.email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" v-model="form.phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" v-model="form.status" required>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Nonaktif">Nonaktif</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Divisi</label>
                                        <select class="form-select" v-model="form.division_id" required>
                                            <option v-for="division in divisions" 
                                                    :key="division.id" 
                                                    :value="division.id">
                                                {{ division.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Job</label>
                                        <select class="form-select" v-model="form.job_id" required>
                                            <option v-for="job in jobs" 
                                                    :key="job.id" 
                                                    :value="job.id">
                                                {{ job.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto</label>
                                        <input type="file" 
                                               class="form-control" 
                                               @change="handleFileUpload" 
                                               accept="image/*"
                                               :required="!showEditModal">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" v-model="form.address" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ showEditModal ? 'Update' : 'Simpan' }}</button>
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
            employeeList: [],
            divisions: [],
            jobs: [],
            showAddModal: false,
            showEditModal: false,
            form: {
                name: '',
                nik: '',
                email: '',
                phone: '',
                status: 'Aktif',
                address: '',
                division_id: '',
                job_id: '',
                foto: null
            },
            editId: null
        }
    },
    mounted() {
        this.getEmployees();
        this.getDivisions();
        this.getJobs();
    },
    methods: {
        getEmployees() {
            axios.get('/api/employee')
                .then(response => {
                    this.employeeList = response.data.data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        getDivisions() {
            axios.get('/api/divisi')
                .then(response => {
                    this.divisions = response.data.data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        getJobs() {
            axios.get('/api/job')
                .then(response => {
                    this.jobs = response.data.data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        },
        handleFileUpload(event) {
            this.form.foto = event.target.files[0];
        },
        saveEmployee() {
            let formData = new FormData();
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            axios.post('/api/employee', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                this.getEmployees();
                this.closeModal();
                alert('Employee berhasil ditambahkan');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menambahkan employee');
            });
        },
        updateEmployee() {
            let formData = new FormData();
            Object.keys(this.form).forEach(key => {
                if (this.form[key] !== null) {
                    formData.append(key, this.form[key]);
                }
            });
            formData.append('_method', 'PUT');

            axios.post(`/api/employee/${this.editId}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                this.getEmployees();
                this.closeModal();
                alert('Employee berhasil diupdate');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengupdate employee');
            });
        },
        deleteEmployee(id) {
            if(confirm('Apakah Anda yakin ingin menghapus employee ini?')) {
                axios.delete(`/api/employee/${id}`)
                    .then(response => {
                        this.getEmployees();
                        alert('Employee berhasil dihapus');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menghapus employee');
                    });
            }
        },
        editEmployee(employee) {
            this.form = {
                name: employee.name,
                nik: employee.nik,
                email: employee.email,
                phone: employee.phone,
                status: employee.status,
                address: employee.address,
                division_id: employee.division_id,
                job_id: employee.job_id,
                foto: null
            };
            this.editId = employee.id;
            this.showEditModal = true;
        },
        closeModal() {
            this.showAddModal = false;
            this.showEditModal = false;
            this.form = {
                name: '',
                nik: '',
                email: '',
                phone: '',
                status: 'Aktif',
                address: '',
                division_id: '',
                job_id: '',
                foto: null
            };
            this.editId = null;
        }
    }
}
</script>

<style scoped>
.modal {
    display: block;
    background-color: rgba(0,0,0,0.5);
}
</style>