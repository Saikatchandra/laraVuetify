<<<<<<< HEAD

<template>
  <v-data-table
    item-key="name" 
	class="elevation-1" 
	
=======
<template>
	<!-- <v-alert type="info"> Roel component </v-alert>	 -->
	<v-data-table 
	item-key="name" 
	class="elevation-1" 
	loading="loading"
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
	loading-text="Loading... Please wait"
    :headers="headers"
    :items="roles"
    sort-by="calories"
<<<<<<< HEAD
=======
	>
		
		<template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>My CRUD</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark class="mb-2" v-on="on">New Item</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.name" label="Dessert name"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
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
                  </v-col>
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
	</v-data-table>
</template>
<template>
  <v-data-table
    :headers="headers"
    :items="roles"
    sort-by="calories"
    class="elevation-1"
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
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
<<<<<<< HEAD
      <v-snackbar
		  v-model="snackbar"
		>
		     Role Delete successfully!
		      <v-btn
		        color="error"
		        text
		        @click="snackbar = false"
		      >
		        Close
		      </v-btn>
		    </v-snackbar>
=======
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
  </v-data-table>
</template>

<script>
  export default {
    data: () => ({
      loading: false,
      dialog: false,
<<<<<<< HEAD
      snackbar: false,
=======
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
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
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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
			 axios.get('/api/roles',{})
        // .then(res => console.log(res.data.roles) )
        	.then(res => this.roles = res.data.roles )
        	.catch(err => {
        		if(err.response.status == 401)
        			localStorage.removeItem('token');
        		    this.$router.push('/login');
        	})
      },
     

      editItem (item) {
        this.editedIndex = this.roles.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.roles.indexOf(item)
<<<<<<< HEAD
        let decide =  confirm('Are you sure you want to delete this item?')
        if(decide){
        	 axios.delete('/api/roles/'+item.id)
		        .then(res => {
		        	this.snackbar = true
		            this.roles.splice(index, 1)
		        })
		        .catch(err => console.log(err.response))
		     }
=======
        confirm('Are you sure you want to delete this item?') && this.roles.splice(index, 1)
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
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
<<<<<<< HEAD
         axios.put('/api/roles/'+this.editedItem.id, {'name': this.editedItem.name})
	          .then(res => Object.assign(this.roles[this.editedIndex], res.data.role))
	          .catch(err => console.log(err.response))
          // Object.assign(this.roles[this.editedIndex], this.editedItem)
=======
          Object.assign(this.roles[this.editedIndex], this.editedItem)
>>>>>>> 013b3b04339bc5e1c3fd1261669922a6773f1102
        } else {
        	axios.post('/api/roles',{'name': this.editedItem.name})
      	     // .then(res => console.dir(res.data) )
      	     .then(res => this.roles.push(res.data.role))
	      	 .catch(err => console.dir(err.response))
	        }
	        this.close()
	      },
    },
}
  
</script>
<style scoped></style>