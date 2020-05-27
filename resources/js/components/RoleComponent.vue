
<template>
  <v-data-table
    item-key="name" 
  	class="elevation-1" 
  	color="error"
    :loading="loading"
  	loading-text="Loading... Please wait"
    :headers="headers"
    :items="roles.data"
    :server-items-length="roles.total"
    :items-per-page=5
    @pagination="paginate"
    sort-by="calories"
    :footer-props="{
       itemsPerPageOptions: [5,10],
       itemsPerPageText: 'Roles per page'
  }"
  >
    <template v-slot:top>
      <v-toolbar flat color="dark">
        <v-toolbar-title>Role Management </v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark class="mb-2" v-on="on">Add New Role</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-text-field v-model="editedItem.name" label="Role name"></v-text-field>
                  </v-col>
                  <!-- <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.calories" label="Calories"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.carbs" label="Carbs (g)"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.protein" label="Protein (g)"></v-text-field>
                  </v-col> -->
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
     <v-snackbar
      v-model="snackbar"
    >
      {{ text }}
      <v-btn
        color="pink"
        text
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </v-snackbar>
  </v-data-table>
</template>

<script>
  export default {
    data: () => ({
      loading: false,
      dialog: false,
      snackbar: false,
      text: '',
      headers: [
        {
          text: '#',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Name', value: 'name' },
        { text: 'Created at', value: 'created_at' },
        { text: 'Updated at', value: 'updated_at' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      roles: [],
      editedIndex: -1,
      editedItem: {
      	id:'',
        name: '',
        created_at: '',
        updated_at: ''
      
      },
      defaultItem: {
        id:'',
        name: '',
        created_at: '',
        updated_at: ''
        
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Role' : 'Edit Role'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      paginate(e){
        console.dir(e)
         axios.get(`/api/roles?page=${e.page}`,{params:{'per_page':e.itemsPerPage}})
        // .then(res => console.log(res.data.roles) )
          .then(res => this.roles = res.data.roles )
          .catch(err => {
            if(err.response.status == 401)
              localStorage.removeItem('token');
                this.$router.push('/login');
          })
      },
      initialize () {
        
        	// Add a request interceptor
			axios.interceptors.request.use((config) => {  // conver into ES6 format remove (function) add (=>) then we can this keyword also
			    // Do something before request is sent
			    this.loading = true;
			    return config;
			  }, (error) => {
			    // Do something with request error
			    this.loading = false;
			    return Promise.reject(error);
			  });

			// Add a response interceptor
			axios.interceptors.response.use((response) => {
			    // Any status code that lie within the range of 2xx cause this function to trigger
			    // Do something with response data
			    this.loading = false;
			    return response;
			  }, (error) => {
			    // Any status codes that falls outside the range of 2xx cause this function to trigger
			    // Do something with response error
			    this.loading = false;
			    return Promise.reject(error);
			  });
			
      },
     

      editItem (item) {
        this.editedIndex = this.roles.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.roles.indexOf(item)
        let decide =  confirm('Are you sure you want to delete this item?')
        if(decide){
        	 axios.delete('/api/roles/'+item.id)
		        .then(res => {
		        	this.snackbar = true
		            this.roles.splice(index, 1)
		        })
		        .catch(err => console.log(err.response))
		     }
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
      	
        if (this.editedIndex > -1) {
        const index = this.editedIndex
         axios.put('/api/roles/'+this.editedItem.id, {'name': this.editedItem.name})
	          .then(res => { 
              this.text = "Record Update Successfully";
              this.snackbar = true
              Object.assign(this.roles[index], res.data.role)
            
            })
	          .catch(err => {
                console.log(err.response)
                this.text = "Error Updating Record"
                this.snackbar = true
           })
          // Object.assign(this.roles[this.editedIndex], this.editedItem)
        } else {
        	axios.post('/api/roles',{'name': this.editedItem.name})
      	     // .then(res => console.dir(res.data) )
      	     .then(res => {
              this.text = "Record Added Successfully";
              this.snackbar = true
              this.roles.push(res.data.role)
           
            })
	      	 .catch(err => { 
              console.dir(err.response)
              this.text = "Error Inserting Record"
              this.snackbar = true
            })
	        }
	       this.close()
	      },
    },
}
  
</script>
<style scoped></style>