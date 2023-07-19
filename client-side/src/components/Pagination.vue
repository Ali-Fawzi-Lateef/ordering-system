<template>
  <div class="join">
    <button
        class="join-item btn btn-xs md:btn-sm lg:btn-md"
        :class="{ 'btn-disabled': props.data.current_page === 1}"
        @click="emit('update',props.data.current_page - 1)"
    >
      «
    </button>

    <button
        @click="emit('update',i)"
        class="join-item btn btn-xs md:btn-sm lg:btn-md"
        v-for="i in Math.ceil(props.data.total/props.data.per_page)"
        :key="i"
        :class="{'btn-info': props.data.current_page === i}"
    >
      {{i}}
    </button>

    <button
        class="join-item btn btn-xs md:btn-sm lg:btn-md"
        :class="{ 'btn-disabled': props.data.current_page === Math.ceil(props.data.total/props.data.per_page)}"
        @click="emit('update',props.data.current_page + 1)"
    >
      »
    </button>
  </div>
</template>

<script setup>

const props = defineProps(['data']);
const emit = defineEmits(['update']);

</script>