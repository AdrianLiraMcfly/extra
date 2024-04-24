<template>
    <AuthenticatedLayout>
        <div class="container mx-auto mt-5">
            <div class="row">
                <div class="col-md-12">
                    <h2>Usuarios</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.role_id == 1 ? 'Administrador' : 'Usuario' }}</td>
                                <td>{{ user.is_active == 1 ? 'Activo' : 'Inactivo' }}</td>
                                <td>
                                    <button-modal id_Modal="modalEditarUsuario" class="btn btn-warning" boton="Editar" @click="editUser(user.id, user.name, user.email, user.role_id)"></button-modal>
                                    <button-modal id_Modal="modalEliminarUsuario" :class="user.is_active == 1 ? 'btn btn-danger' : 'btn btn-success'" :boton="user.is_active == 1 ? 'Desactivar' : 'Activar'" @click="idUser(user.id)"></button-modal>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button-modal id_Modal="modalCrearUsuario" class="btn btn-primary" boton="Crear Usuario"></button-modal>
                </div>
            </div>
        </div>
        <Modal id_modal="modalEditarUsuario" titulo="Editar Usuario">
            <form @submit.prevent="updateUser(id)">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" v-model="editform.name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" v-model="editform.email">
                </div>
                <div class="form-group">
                    <label for="role_id">Rol</label>
                    <select class="form-control" id="role_id" v-model="editform.role_id">
                        <option value="1">Administrador</option>
                        <option value="2">Usuario</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Actualizar</button>
            </form>
        </Modal>
        <Modal id_modal="modalEliminarUsuario" titulo="Eliminar Usuario">
            <div v-if="id != ''">
            <div v-if="users.find(user => user.id == id).is_active == 1">
                <p>¿Estás seguro de desactivar este usuario?</p>
                <button @click="deleteUser(id)" class="btn btn-danger" data-bs-dismiss="modal">Desactivar</button>
            </div>
            <div v-else>
            <p>¿Estás seguro de activar este usuario?</p>
            <button @click="deleteUser(id)" class="btn btn-success" data-bs-dismiss="modal">Activar</button>
            </div>
            </div>
        </Modal>
        <Modal id_modal="modalCrearUsuario" titulo="Crear Usuario">
            <form @submit.prevent="createUser">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" v-model="form.name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control"  v-model="form.email">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" v-model="form.password">
                </div>
                <div class="form-group">
                    <label for="role_id">Rol</label>
                    <select class="form-control" v-model="form.role_id">
                        <option value="1">Administrador</option>
                        <option value="2">Usuario</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Crear</button>
            </form>
        </Modal>
    </AuthenticatedLayout>
</template>

<script>
import ButtonModal from '@/Components/ButtonModal.vue';
import Modal from '@/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { router } from '@inertiajs/vue3'

    export default {
        components: {
            AuthenticatedLayout,
            Modal,
            ButtonModal
        },
        props: {
            users: Array
        },
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    role_id: ''
                },
                editform: {
                    name: '',
                    email: '',
                    role_id: ''
                },
                id: '',
                showModal: false
            }
        },
        methods: {
            editUser(id, name, email, role_id) {
                this.id = id
                this.editform.name = name
                this.editform.email = email
                this.editform.role_id = role_id
            },
            idUser(id) {
                this.id = id
            },
            deleteUser(id) {
                router.delete(route('users.destroy', id))
                this.showModal = true
                setTimeout(() => {
                    this.showModal = false
                }, 3000)
            },
            createUser() {
                router.post(route('users.store'), this.form)
                this.form.name = ''
                this.form.email = ''
                this.form.password = ''
                this.showModal = true
                setTimeout(() => {
                    this.showModal = false
                }, 3000)
            },
            updateUser(id) {
                router.put(route('users.update', id), this.editform)
                this.editform.name = ''
                this.editform.email = ''
                this.editform.role_id = ''
                this.showModal = true
                setTimeout(() => {
                    this.showModal = false
                }, 3000)
            }

        }
    }
</script>