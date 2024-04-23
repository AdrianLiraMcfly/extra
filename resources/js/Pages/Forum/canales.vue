<template>
    <AuthenticatedLayout>
        <div class="container mx-auto mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Canales</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="canal in canales" :key="canal.id">
                                        <td>{{ canal.nombre }}</td>
                                        <td>
                                            <button-modal id_modal="modalEditarCanal" class="btn btn-warning"></button-modal>
                                            <button-modal id_modal="modalEliminarCanal" class="btn btn-danger">E</button-modal>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal id="modalCrearCanal" titulo="Crear Canal">
    <form @submit.prevent="crearCanal">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" v-model="form.nombre">
        </div>
        <button type="submit" class="btn btn-primary">Crear Canal</button>
    </form>
</Modal>

<Modal id="modalEditarCanal" titulo="Editar Canal">
    <form @submit.prevent="editarCanal">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" v-model="editform.nombre">
        </div>
        <button type="submit" class="btn btn-warning">Editar Canal</button>
    </form>
</Modal>

<Modal id="modalEliminarCanal" titulo="Eliminar Canal">
    <form @submit.prevent="eliminarCanal">
        <p>¿Estás seguro de que deseas eliminar este canal?</p>
        <button type="submit" class="btn btn-danger">Eliminar Canal</button>
    </form>
</Modal>
    </AuthenticatedLayout>
</template>

<script>  
import ButtonModal from '@/Components/ButtonModal.vue';
import Modal from '@/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router } from '@inertiajs/vue3';

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
    }
},
methods: {
    obtenerCanal(id) {
        this.id = id
    },
    crearCanal() {
        router.post(route('canales.store'), this.form)
    },
    editarCanal() {
        router.put(route('canales.update', this.id), this.editform)
    },
    eliminarCanal() {
        router.delete(route('canales.destroy', this.id))
    }
}
}
</script>