<template>
    <ul v-if="pagination.last_page != 1" class="pagination">
    <li v-if="pagination.current_page > 1">
        <a href="javascript:void(0)" aria-label="Previous" v-on:click.prevent="changePage(pagination.current_page - 1)">
            <span aria-hidden="true">«</span>
            </a>
        </li>
    <li v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}">
        <a href="javascript:void(0)" v-on:click.prevent="changePage(page)">{{ page }}</a>
        </li>
    <li v-if="pagination.current_page < pagination.last_page">
        <a href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)">
            <span aria-hidden="true">»</span>
            </a>
        </li>
    </ul>
</template>
<script>
  export default{
      props: ['pagination', 'offset'],
    computed: {
      pagesNumber() {
        if (!this.pagination.to) {
          return [];
        }
        let from = this.pagination.current_page - this.offset;
        if (from < 1) {
          from = 1;
        }
        let to = from + (this.offset * 2);
        if (to >= this.pagination.last_page) {
          to = this.pagination.last_page;
        }
        let pagesArray = [];
        for (let page = from; page <= to; page++) {
          pagesArray.push(page);
        }
          return pagesArray;
      }
    },
    methods : {
      changePage(page) {
        this.pagination.current_page = page;
        this.$emit('paginate');
      }
    }
  }
</script>


<style>

.center {
  text-align: center;
}

.pagination {
  justify-content: center;
align-items: center;
}
 

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
  margin: 0 4px;
}

.pagination li.active a {
  background-color: #4CAF50;
  color: white;
  border: 1px solid #4CAF50;
}

</style>