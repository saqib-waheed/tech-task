<template>
    <div>
        <router-link to="/users/create" class="btn">Create User</router-link>
        <table class="table-auto w-full mt-4">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }} {{ user.surname }}</td>
                <td>{{ user.email }}</td>
                <td>
                    <router-link :to="`/users/${user.id}`">View</router-link> |
                    <router-link :to="`/users/${user.id}/edit`">Edit</router-link> |
                    <button @click="deleteUser(user.id)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const users = ref([]);

const fetchUsers = async () => {
    const res = await axios.get('/api/users');
    users.value = res.data;
};

const deleteUser = async (id) => {
    await axios.delete(`/api/users/${id}`);
    fetchUsers();
};

onMounted(fetchUsers);
</script>
