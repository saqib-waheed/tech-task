<template>
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <div>
            <label>Name</label>
            <input v-model="form.name" type="text" @focus="clearError('name')" />
            <div v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</div>
        </div>

        <div>
            <label>Surname</label>
            <input v-model="form.surname" type="text" @focus="clearError('surname')" />
            <div v-if="errors.surname" class="text-red-500">{{ errors.surname[0] }}</div>
        </div>

        <div>
            <label>Email</label>
            <input v-model="form.email" type="email" @focus="clearError('email')" />
            <div v-if="errors.email" class="text-red-500">{{ errors.email[0] }}</div>
        </div>

        <div>
            <label>Phone</label>
            <input v-model="form.phone" type="text" @focus="clearError('phone')" />
            <div v-if="errors.phone" class="text-red-500">{{ errors.phone[0] }}</div>
        </div>

        <div>
            <label>Country</label>
            <select v-model="form.country" @focus="clearError('country')">
                <option disabled value="">Select Country</option>
                <option v-for="c in countries" :key="c" :value="c">{{ c }}</option>
            </select>
            <div v-if="errors.country" class="text-red-500">{{ errors.country[0] }}</div>
        </div>

        <div>
            <label>Gender</label>
            <select v-model="form.gender" @focus="clearError('gender')">
                <option disabled value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
            <div v-if="errors.gender" class="text-red-500">{{ errors.gender[0] }}</div>
        </div>

        <div>
            <label>Password</label>
            <input v-model="form.password" type="password" @focus="clearError('password')" />
            <div v-if="errors.password" class="text-red-500">{{ errors.password[0] }}</div>
        </div>

        <div>
            <label>Confirm Password</label>
            <input v-model="form.password_confirmation" type="password" @focus="clearError('password_confirmation')" />
            <div v-if="errors.password_confirmation" class="text-red-500">{{ errors.password_confirmation[0] }}</div>
        </div>

        <div>
            <label>Profile Image</label>
            <input type="file" @change="handleFileUpload" />
            <div v-if="errors.image" class="text-red-500">{{ errors.image[0] }}</div>
        </div>

        <button type="submit">Create User</button>
    </form>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

// Reactive form state
const form = ref({
    name: '',
    surname: '',
    email: '',
    phone: '',
    country: '',
    gender: '',
    password: '',
    password_confirmation: '',
    image: null
})

// Validation error storage
const errors = ref({})

// Predefined list of countries
const countries = [
    'Pakistan',
    'India',
    'Bangladesh',
    'United States',
    'Canada',
    'United Kingdom'
]

// Handle form submission
const submitForm = async () => {
    errors.value = {} // Reset previous errors
    const payload = new FormData()

    for (const key in form.value) {
        payload.append(key, form.value[key])
    }

    try {
        await axios.post('/api/users', payload)
        alert('User created successfully!')
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        } else {
            alert('An error occurred')
        }
    }
}

// Handle file upload
const handleFileUpload = (e) => {
    form.value.image = e.target.files[0]
}

// Clear individual field error
const clearError = (field) => {
    if (errors.value[field]) {
        delete errors.value[field]
    }
}
</script>

<style scoped>
.text-red-500 {
    color: red;
    font-size: 0.875rem;
}
</style>
