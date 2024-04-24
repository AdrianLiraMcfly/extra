<template>
    <AuthenticatedLayout>
        <div v-if="$page.props.flash.message && showAlert" class="relative p-6 mb-4 text-green-700 bg-green-100 border-0 rounded-lg shadow-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="inline-block mr-5 align-middle">
                <i class="text-xl animate-bounce fas fa-bell"></i>
            </span>
            <span class="inline-block align-middle mr-8">
                <b class="font-semibold">¡Atención!</b> {{ $page.props.flash.message }}
            </span>
            <button class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="closeAlert">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Cerrar</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"></path></svg>
            </button>
        </div>
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
                <button @click="deleteUser" class="btn btn-danger" data-bs-dismiss="modal">Desactivar</button>
            </div>
            <div v-else>
                <p>¿Estás seguro de activar este usuario?</p>
                <button @click="deleteUser" class="btn btn-success" data-bs-dismiss="modal">Activar</button>
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
                showAlert: false
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
            deleteUser() {
                router.delete(route('users.destroy', this.id))
                this.showAlert = true
                setTimeout(() => {
                    this.showAlert = false
                }, 3000)
            },
            createUser() {
                router.post(route('users.store'), this.form)
                this.form.name = ''
                this.form.email = ''
                this.form.password = ''
                this.form.role_id = ''
                this.showAlert = true
                setTimeout(() => {
                    this.showAlert = false
                }, 3000)
            },
            updateUser(id) {
                router.put(route('users.update', id), this.editform)
                this.editform.name = ''
                this.editform.email = ''
                this.editform.role_id = ''
                this.showAlert = true
                setTimeout(() => {
                    this.showAlert = false
                }, 3000)
            }

        }
    }
</script>