  <template>
  <div>
    <h2>Articles</h2>
    <form @submit.prevent="addProduct" class="mb-3">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="id" v-model="product.id">
        <input type="text" class="form-control" placeholder="type" v-model="product.product_type">
        <input type="text" class="form-control" placeholder="price" v-model="product.product_price">
        <input type="text" class="form-control" placeholder="name" v-model="product.product_name">
      </div>
  <!--       <div class="form-group">
         <textarea class="form-control" placeholder="  " ></textarea>
      </div> -->
      <button type="submit" class="btn btn-light btn-block">save</button>
    </form>

      <nav aria-label="Page navigation example">
        <ul class ="pagination">
            <li v-bind:class="[{disable: !pagination.prev_page_url}]" class ="page-item"><a class="page-link" href="#" @click="fetchProducts(pagination.prev_page_url)">Previous</a></li>
            <li class="page-item disable"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
            <li v-bind:class="[{disable: !pagination.next_page_url}]" class ="page-item"><a class="page-link" href="#" @click="fetchProducts(pagination.next_page_url)">Next</a></li>
        </ul>
      </nav>
    <div class="card card-body" v-for = "product in products" v-bind:key="product.id">
      <h3>{{ product.id }}</h3>
      <p>{{ product.product_name }}</p>
      <p>{{ product.product_price }}</p>
      <p>{{ product.product_type }}</p>
      <hr>
      <button @click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
      <button @click="editProduct(product)" class="btn btn-warning mb-2">Edit</button>
    </div>
  </div>
</template>


<script>
  export default{
    data(){
      return{
        products: [],
        product: {
          id : '',
          product_name : '',
          product_type : '',
          product_type : ''    
        },
        id : '',
        pagination : {},
        edit : false
      }
    },

    created(){
      this.fetchProducts();
    },
    methods :{
      fetchProducts(page_url) {
        let vm = this;
        page_url = page_url || '/api/products';
        fetch(page_url)
          .then(res => res.json())
          .then(res => {
            this.products = res.data;
            vm.makePagination(res.meta, res.links);
          })
          .catch(error => console.log(error));
      },
      makePagination(meta, links){
        let pagination = {
          current_page: meta.current_page,
          last_page: meta.last_page,
          next_page_url: links.next,
          prev_page_url: links.prev
        }
        this.pagination = pagination;
      },
      deleteProduct(id) {
        if(confirm('Are You Sure?')) {
          fetch(`api/product/${id}`, {
            method: 'delete'
          })
          .then(res => res.json())
          .then(data => {
            alert('product removed');
            this.fetchProducts();
          })
          .catch(err => console.log(error));
        }
      },
      addProduct(){
        if(this.edit === false) {
          //add
          fetch('api/product',{
            method: 'post',
            body: JSON.stringify(this.product),
            headers: {
              'content-type' : 'application/json'
            }
          })
            .then(res => res.json())
            .then(data => {
              this.product.id = '';
              this.product.product_name = '';
              alert('add product');
              this.fetchProducts();
            })
            .catch(err => console.log(err));
          }else{
            //updata
            fetch('api/product',{
              method: 'put',
              body: JSON.stringify(this.product),
              headers: {
                'content-type' : 'application/json'
            }
          })
            .then(res => res.json())
            .then(data => {
              this.product.id = '';
              this.product.product_name = '';
              this.product.product_price = '';
              this.product.product_type = '';
              alert('updata product');
              this.fetchProducts();
            })
            .catch(err => console.log(err));
          }
        },
      editProduct(product){
        this.edit = true;
        this.product.id = product.id;
        this.product.product_name = product.product_name;
        this.product.product_type = product.product_type;
        this.product.product_price = product.product_price; 
      }
  }
};

</script>