<template>
    <AuthenticatedLayout>
        <div v-if="$page.props.flash.message && showAlert" class="relative p-6 mb-4 text-green-700 bg-green-100 border-0 rounded-lg shadow-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="inline-block mr-5 align-middle">
                <i class="text-xl animate-bounce fas fa-bell"></i>
            </span>
            <span class="inline-block align-middle mr-8">
                <b class="font-semibold">¡Atención!</b> {{ $page.props.flash.message }} {{ $page.props.flash.error }}
            </span>
            <button class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="closeAlert">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Cerrar</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"></path></svg>
            </button>
        </div>
        <div class="container mx-auto mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Temas del Canal: {{ canal.nombre }}</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tema</th>
                                        <th>Autor</th>
                                        <th>Status</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="tema in temas" :key="tema.id">
                                        <template v-if="tema.is_active == 1 || $page.props.auth.user.role_id == '1'">
                                        <td>{{ tema.titulo }}</td>
                                        <td>{{ tema.user.name }}</td>
                                        <td>{{ tema.is_active == 1 ? 'Activo' : 'Inactivo' }}</td>
                                        <td>
                                            <button-modal v-if="$page.props.auth.user.role_id == '1'" id_Modal="modalEditarTema" class="btn btn-warning" boton="Editar" @click="editTema(tema.id, tema.titulo)"></button-modal>
                                            <button-modal v-if="$page.props.auth.user.role_id == '1'" id_Modal="modalEliminarTema" :class="tema.is_active == 1 ? 'btn btn-danger' : 'btn btn-success'" :boton="tema.is_active == 1 ? 'Desactivar' : 'Activar'" @click="obtenerTema(tema.id)"></button-modal>
                                            <Link :href="route('tema.show', tema.id)">
                                            <button type="button" class="btn btn-success" >Ver</button>
                                            </Link> 
                                        </td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                            <button-modal id_Modal="modalCrearTema" class="btn btn-primary" boton="Crear Tema"></button-modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal id_modal="modalCrearTema" titulo="Crear Tema">
            <form @submit.prevent="crearTema">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="titulo" v-model="form.titulo">
                    <p v-if="errors.titulo" class="text-red-500 text-xs italic">{{ errors.titulo }}</p>
                </div>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Crear</button>
            </form>
        </Modal>
        <Modal id_modal="modalEditarTema" titulo="Editar Tema">
            <form @submit.prevent="editarTema">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="titulo" v-model="editform.titulo">
                    <p v-if="errors.titulo" class="text-red-500 text-xs italic">{{ errors.titulo }}</p>
                </div>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Editar</button>
            </form>
        </Modal>
        <Modal id_modal="modalEliminarTema" titulo="Eliminar Tema">
            <div v-if="id !=null">
                <div v-if="temas.find(tema => tema.id === id).is_active == 1">
                    <p>¿Estas seguro de querer desactivar este tema?</p>
                    <button class="btn btn-danger" @click="eliminarTema"  data-bs-dismiss="modal">Eliminar</button>
                </div>
                <div v-else>
                    <p>¿Estas seguro de querer activar este tema?</p>
                    <button class="btn btn-success" @click="eliminarTema" data-bs-dismiss="modal">Activar</button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script>  
import ButtonModal from '@/Components/ButtonModal.vue';
import Modal from '@/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

export default {
components: {
    ButtonModal,
    Modal,
    Link,
    AuthenticatedLayout
},
props: {
    canal: Object,
    temas: Array,
    errors: {}
},
data() {
    return {
        form: {
            titulo: '',	 
        },
        editform: {
            titulo: '',
        },
        id: null,
        showAlert: false,
    }
},
methods: {
    obtenerTema(id) {
        this.id = id
    },
    crearTema() {
        router.post(route('tema.store', this.canal.id), this.form)
        this.form = {
            titulo: '',
        }
        this.showAlert = true
        setTimeout(() => {
            this.showAlert = false
        }, 3000)
    },
    editTema(id, titulo) {
        this.id = id
        this.editform.titulo = titulo
    },
    editarTema() {
        //como se paran los 2 como objeto,se quedan asi
        router.put(route('tema.update', {canal: this.canal.id, tema: this.id}), this.editform)
        this.editform = {
            titulo: '',
        }
        this.showAlert = true
        setTimeout(() => {
            this.showAlert = false
        }, 3000)
        this.id = null
    },
    eliminarTema() {
        router.delete(route('tema.destroy', {canal: this.canal.id, tema: this.id}))
        this.showAlert = true
        setTimeout(() => {
            this.showAlert = false
        }, 3000)
        this.id = null
    }
}
}
</script>