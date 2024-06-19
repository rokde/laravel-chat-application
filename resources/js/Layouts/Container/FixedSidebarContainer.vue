<script setup>

</script>

<template>
    <section class="grid grid-cols-12">
        <aside class="col-span-3">
            <slot name="sidebar"/>
        </aside>
        <main class="col-span-9">
            <slot/>
        </main>
    </section>
</template>
