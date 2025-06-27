<script>
export default {
    name: "NotFound"
}
</script>

<template>
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">Hello there</h1>
                <p class="py-6">
                   Page not found
                </p>
                <button class="btn btn-primary">
                    <router-link :to="{name : 'app.dashboard'}">
                        Go to dashboard
                    </router-link>
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
