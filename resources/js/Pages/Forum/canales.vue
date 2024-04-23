<template>
    <AuthenticatedLayout>
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Canales</h1>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>  
import ButtonModal from '@/Components/ButtonModal.vue';
import Modal from '@/Components/Modal.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { route } from 'laravel-jetstream';

export default {
components: {
    ButtonModal,
    Modal,
    AuthenticatedLayout
},
}
</script>