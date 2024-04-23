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
                                </div>
                                <div class="card-footer">
                                    <ButtonModal boton="Crear Canal" id_Modal="modalCrearCanal" color="btn-primary" />
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>

    <Modal id_modal="modalCrearCanal" titulo="Crear Canal">
        <form action="">
            <div class="form-group">
                <label for="nombre">Nombre del Canal</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Canal">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Crear Canal</button>
            </div>
        </form>
    </Modal>

    <Modal id_modal="modalEditarCanal" titulo="Editar Canal">
        <form action="">
            <div class="form-group">
                <label for="nombre">Nombre del Canal</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Canal">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Editar Canal</button>
            </div>
        </form>
    </Modal>

    <Modal id_modal="modalEliminarCanal" titulo="Eliminar Canal">
        <form action="">
            <div class="form-group">
                <label for="nombre">Nombre del Canal</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del Canal">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Eliminar Canal</button>
            </div>
        </form>
    </Modal>
</template>

<script >
import ButtonModal from '@/Components/ButtonModal.vue';
import Modal from '@/Components/Modal.vue';

export default {
components: {
    ButtonModal,
    Modal
},
props: {
    canales: Array
},
methods: {
    crearCanal() {
        console.log('Crear Canal');
    },
    editarCanal() {
        console.log('Editar Canal');
    },
    eliminarCanal() {
        console.log('Eliminar Canal');
    }
}
}
</script>
