<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="container justificy-align-center">
                        <div class="row">
                            <div class="card bordered-primary">
                                <h1>Canales</h1>
                                <div class="card-body">
                                    <p>En esta sección podrás ver los canales de comunicación que tienes disponibles.</p>
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
                                                    <ButtonModal boton="Editar Canal" id_Modal="modalEditarCanal" color="btn-warning" />
                                                    <ButtonModal boton="Eliminar Canal" id_Modal="modalEliminarCanal" color="btn-danger" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <ButtonModal boton="Crear Canal" id_Modal="modalCrearCanal" titulo="Añadir" color="btn-primary" />
                                </div>
                        </div>
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

<script >
import ButtonModal from '@/Components/ButtonModal.vue';
import Modal from '@/Components/Modal.vue';
import { router } from '@inertiajs/vue3';

export default {
components: {
    ButtonModal,
    Modal
},
props: {
    canales: Array
},
data(){
    return{
        form: {
            nombre: ''
        },
        editform: {
            nombre: ''
        }
    }
},
methods: {
    crearCanal() {
        router.post(route('canales.store'), this.form)
        this.form = {
            nombre: ''
        }
    },
    editarCanal() {
        router.put(route('canales.update', this.editform.id), this.editform)
        this.editform = {
            nombre: ''
        }
    },
    eliminarCanal() {
        router.delete(route('canales.destroy', this.editform.id))
        this.editform = {
            nombre: ''
        }
    }
}
}
</script>
