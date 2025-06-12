<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LogIn, ArrowLeft } from 'lucide-vue-next';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar sesión" />

        <!-- BOTÓN DE REGRESO AL INICIO -->
        <div class="flex justify-start mb-6">
            <Link
                href="/"
                class="flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow border border-gray-300 transition font-semibold"
            >
                <ArrowLeft class="w-4 h-4" /> Inicio
            </Link>
        </div>

        <div class="flex flex-col items-center mb-6">
            <LogIn class="w-12 h-12 text-blue-500 mb-2" />
            <h1 class="text-2xl font-extrabold text-blue-800 mb-1">Iniciar sesión</h1>
            <p class="text-gray-600 text-sm">Accede a tu cuenta para ntinuar</p>
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 text-center">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <div>
                <InputLabel for="email" value="Correo electrónico" class="font-semibold text-gray-700" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 shadow-sm"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="ejemplo@correo.com"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Contraseña" class="font-semibold text-gray-700" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full border-2 border-blue-200 focus:border-blue-500 rounded-xl p-3 shadow-sm"
                    v-model="form.password"
                    reqcouired
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center mt-2">
                <Checkbox name="remember" v-model:checked="form.remember" />
                <span class="ms-2 text-sm text-gray-600">Recordarme</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between mt-4 gap-2">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400"
                >
                    ¿Olvidaste tu contraseña?
                </Link>
                <PrimaryButton
                    class="flex items-center gap-2 justify-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-lg font-bold transition"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    <LogIn class="w-5 h-5" /> Ingresar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
