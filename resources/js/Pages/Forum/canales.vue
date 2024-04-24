<template>
    <AuthenticatedLayout>
         <!-- asi pones la alerta, en este caso como le puse message con el with en el prop.flash le pones .message -->
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
                    <div class="card">
                        <div class="card-header">Canales</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Canal</th>
                                        <th>status</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="canal in canales" :key="canal.id">
                                        <td>{{ canal.nombre }}</td>
                                        <td>{{ canal.is_active == 1 ? 'Activo' : 'Inactivo' }}</td>
                                        <td>
                                            <button-modal id_Modal="modalEditarCanal" class="btn btn-warning" boton="Editar" @click="editCanal(canal.id, canal.nombre)"></button-modal>
                                            <button-modal id_Modal="modalEliminarCanal" :class="canal.is_active == 1 ? 'btn btn-danger' : 'btn btn-success'" :boton="canal.is_active == 1 ? 'Desactivar' : 'Activar'" @click="obtenerCanal(canal.id)"></button-modal>
                                           <Link :href="route('canales.show', canal.id)">
                                            <button type="button" class="btn btn-success">Ver</button>
                                            </Link> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button-modal id_Modal="modalCrearCanal" class="btn btn-primary" boton="Crear Canal"></button-modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal id_modal="modalCrearCanal" titulo="Crear Canal">
            <form @submit.prevent="crearCanal">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" v-model="form.nombre">
                </div>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Crear</button>
            </form>
        </Modal>
        <Modal id_modal="modalEditarCanal" titulo="Editar Canal">
            <form @submit.prevent="editarCanal">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" v-model="editform.nombre">
                </div>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Editar</button>
            </form>
        </Modal>
        <Modal id_modal="modalEliminarCanal" titulo="Eliminar Canal">
            <p>¿Estás seguro de eliminar este canal?</p>
            <button class="btn btn-danger" @click="eliminarCanal" data-bs-dismiss="modal">Eliminar</button>
        </Modal>
    </AuthenticatedLayout>
</template>

<script>  
import ButtonModal from '@/Components/ButtonModal.vue';
import Modal from '@/Components/Modal.vue';
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export default {
components: {
    ButtonModal,
    Modal,
    Link,
    AuthenticatedLayout
},
props: {
    canales: Array,
    usuarios: Array
},
data() {
    return {
        form: {
            nombre: '',
        },
        editform: {
            nombre: '',
        },
        id: null,
        showAlert: false,
        alertMessage: '',
        alertClass: '',
    }
},
methods: {
    obtenerCanal(id) {
        this.id = id
    },
    crearCanal() {
        router.post(route('canales.store'), this.form)
        this.form = {
            nombre: '',
        }
        this.showAlert = true
        setTimeout(() => {
            this.showAlert = false
        }, 3000)
    },
    editCanal(id, nombre) {
        this.id = id
        this.editform.nombre = nombre
    },
    editarCanal() {
        router.put(route('canales.update', this.id), this.editform)
        this.editform = {
            nombre: '',
        }
        this.showAlert = true
        setTimeout(() => {
            this.showAlert = false
        }, 3000)
        this.id = null
    },
    eliminarCanal() {
        router.delete(route('canales.destroy', this.id))
        if(this.canales.find(canal => canal.id === this.id).is_active == 1) {
            this.showAlert = true
        } else {
            this.showAlert = true
        }
        setTimeout(() => {
            this.showAlert = false
        }, 3000)
        this.id = null
    }
}
}
</script>