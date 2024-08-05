<template>
  <v-card>
    <v-card-title>
      <v-row>
        <v-col cols="4">
          <v-select
            v-model="itemsPerPage"
            :items="[5, 10, 15]"
            label="Items per page"
            hide-details
            class="items-per-page"
          ></v-select>
        </v-col>
        <v-col cols="3" class="ml-auto">
          <v-text-field
            v-model="search"
            label="Search"
            prepend-inner-icon="mdi-magnify"
            class="search-field"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-card-title>
    <v-data-table
      :headers="headersWithAction"
      :items="paginatedItems"
      :search="search"
      class="elevation-1 custom-data-table"
    >
      <template v-slot:bottom>
        <div class="text-center pt-2">
          <v-pagination
            v-model="page"
            :length="pageCount"
            @input="updatePagination"
          ></v-pagination>
        </div>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
export default {
  name: 'DataTable',
  props: {
    items: {
      type: Array,
      required: true,
    },
    headers: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      search: '',
      page: 1,
      itemsPerPage: 5,
    };
  },
  computed: {
    headersWithAction() {
      return this.headers;
    },
    pageCount() {
      return Math.ceil(this.items.length / this.itemsPerPage);
    },
    paginatedItems() {
      const start = (this.page - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.items.slice(start, end);
    },
  },
  methods: {
    updatePagination() {
      // Force a refresh of the paginated items when the page changes
      this.paginatedItems;
    },
  },
  watch: {
    items() {
      this.page = 1;
    },
  },
};
</script>

<style scoped>
.v-card {
  border-radius: 20px;
  overflow: hidden;
}

.search-field {
  max-width: 300px;
}

.items-per-page {
  max-width: 150px;
}

.custom-data-table {
  background-color: #fff;
}

.v-data-table__footer {
  background-color: #333 !important;
  color: #fff !important;
}

.v-pagination__item {
  background-color: #444 !important;
  color: #fff !important;
}

.v-pagination__item--active {
  background-color: #666 !important;
  color: #fff !important;
}

.v-pagination__navigation-icon {
  color: #fff !important;
}
</style>
