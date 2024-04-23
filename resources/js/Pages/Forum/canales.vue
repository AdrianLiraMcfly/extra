<template>
    <AuthenticatedLayout>
        <div v-if="showAlert" class="alert" :class="alertClass" role="alert">
                    {{ alertMessage }}
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
                                            <button class="btn btn-success">Ver</button>
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

export default {
components: {
    ButtonModal,
    Modal,
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
        this.alertMessage = 'Canal creado'
        this.alertClass = 'alert-success'
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
        this.alertMessage = 'Canal editado'
        this.alertClass = 'alert-success'
        setTimeout(() => {
            this.showAlert = false
        }, 3000)
        this.id = null
    },
    eliminarCanal() {
        router.delete(route('canales.destroy', this.id))
        if(this.canales.find(canal => canal.id === this.id).is_active == 1) {
            this.showAlert = true
            this.alertMessage = 'Canal desactivado'
            this.alertClass = 'alert-danger'
        } else {
            this.showAlert = true
            this.alertMessage = 'Canal activado'
            this.alertClass = 'alert-success'
        }
        setTimeout(() => {
            this.showAlert = false
        }, 3000)
        this.id = null
    }
}
}
</script>