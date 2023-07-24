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
        v-for="i in (pages > 5 ? 5 : pages)"
        :key="i"
        :class="{'btn-active btn-neutral': props.data.current_page === i}"
    >
      {{i}}
    </button>

    <button
        class="join-item btn btn-xs md:btn-sm lg:btn-md"
        :class="{ 'btn-disabled': props.data.current_page === pages}"
        @click="emit('update',props.data.current_page + 1)"
    >
      »
    </button>
  </div>
</template>

<script setup>
/*
 * the pages variable is computed by dividing the total number of items by the number of items per page.
 * NOTE: the loop will only run 5 times if the number of pages is greater than 5.
 */
const props = defineProps(['data']);
const emit = defineEmits(['update']);
const pages = Math.ceil(props.data.total/props.data.per_page);


</script>