<template>
    <div v-if="user">
        <h2>{{ user.name }} {{ user.surname }}</h2>
        <p>Email: {{ user.email }}</p>
        <p>Phone: {{ user.phone }}</p>
        <p>Country: {{ user.country }}</p>
        <p>Gender: {{ user.gender }}</p>
        <img v-if="user.profile_image" :src="`/storage/${user.profile_image}`" class="w-48 mt-2" />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const route = useRoute();
const user = ref(null);

onMounted(async () => {
    const res = await axios.get(`/api/users/${route.params.id}`);
    user.value = res.data;
});
</script>
