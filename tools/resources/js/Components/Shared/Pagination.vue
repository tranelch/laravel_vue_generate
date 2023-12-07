<template>
  <div v-if="links && Object.keys(links).length > 3" class="pagination-wrap">
    <div class="select-input-wrap">
      <label for="rowsPerPage">
        Rows per page
      </label>
      <select
        id="rowsPerPage"
        name="rowsPerPage"
        class="select-input"
        @change="rowsPerPageChange($event)"
      >
        <option value="50" :selected="(perPage == 50)">50</option>
        <option value="100" :selected="(perPage == 100)">100</option>
        <option value="150" :selected="(perPage == 150)">150</option>
        <option value="200" :selected="(perPage == 200)">200</option>
        <option value="1000" :selected="(perPage == 1000)">1000</option>
      </select>
    </div>

    <div class="page-info">
      {{ from }} - {{ to }} of {{ total }} items
    </div>
    <div class="page-links">
      <template v-for="link in links">
        <Link
          v-if="link.url"
          :key="link.url"
          :href="link.url"
          :class="{ 'active' : link.active }"
        >
          <span v-html="link.label"></span>
        </Link>
      </template>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    components: {
        Link
    },

    props: {
        from: Number,
        to: Number,
        perPage: Number,
        links: Array,
        total: Number
    },

    emits: ['rowsPerPageChange'],

    setup (props, {emit}) {
        const rowsPerPageChange = (event) => {
            emit('rowsPerPageChange', event.target.value);
        }

        return {
            rowsPerPageChange
        }
    },
}
</script>

<style scoped>
.pagination-wrap {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    color: #666666;
    font-size: 12px;
    align-items: center;
    padding: 15px 1px 5px 1px;
    width: 100%;
    max-width: 100%;
    min-width: min-content;
}

.pagination-wrap .page-info {
}

.pagination-wrap .page-links {
    margin-left: 15px;
}

.pagination-wrap .page-links a {
    margin-left: 10px;
}

@media (max-width: 767px) {
    .pagination-wrap {
        flex-direction: column;
    }

    .pagination-wrap .page-info {
        margin: 5px 0px 5px 0px;
    }

    .pagination-wrap .page-links {
        margin: 5px 0px 5px 0px;
    }
}
</style>